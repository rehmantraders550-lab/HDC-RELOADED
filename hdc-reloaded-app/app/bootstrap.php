<?php
declare(strict_types=1);
define('ROOT', dirname(__DIR__));
require_once ROOT.'/app/CommercialRules.php';
require_once ROOT.'/app/ArtworkStorage.php';
$envFile=ROOT.'/.env';
if (is_file($envFile)) foreach(file($envFile, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES) as $line) { $line=trim($line); if ($line===''||str_starts_with($line,'#')||!str_contains($line,'=')) continue; [$k,$v]=explode('=',$line,2); $_ENV[trim($k)]=trim(trim($v),"\"'"); }
function envv(string $k,string $d=''): string { return (string)($_ENV[$k]??$d); }
function e(?string $s): string { return htmlspecialchars($s??'',ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function db(): PDO { static $pdo; if($pdo instanceof PDO)return $pdo; $dsn='mysql:host='.envv('DB_HOST','127.0.0.1').';port='.envv('DB_PORT','3306').';dbname='.envv('DB_NAME','hdc_printing').';charset=utf8mb4'; $pdo=new PDO($dsn,envv('DB_USER'),envv('DB_PASSWORD'),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]); return $pdo; }
function start_secure_session(): void { if(session_status()===PHP_SESSION_ACTIVE)return; ini_set('session.use_strict_mode','1');
    session_name('hdc_session'); session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off','samesite'=>'Lax','path'=>'/']); session_start(); }
function csrf_token(): string { start_secure_session(); return $_SESSION['csrf']??=bin2hex(random_bytes(32)); }
function csrf_check(): void { start_secure_session(); if(!hash_equals($_SESSION['csrf']??'',(string)($_POST['_csrf']??''))){http_response_code(419);exit('Session expired. Return to the form and try again.');} }
function require_admin(): void { start_secure_session(); if(empty($_SESSION['admin_id'])){header('Location: /admin/login');exit;} }
function route_path(): string { $p=parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH)?:'/';return rtrim($p,'/')?:'/'; }
function redirect(string $u): never { header('Location: '.$u,true,303);exit; }
function flash(string $t): void { start_secure_session();$_SESSION['flash']=$t; }
function take_flash(): string { start_secure_session();$s=(string)($_SESSION['flash']??'');unset($_SESSION['flash']);return $s; }
function product_by_slug(string $slug): ?array { $q=db()->prepare('SELECT p.* FROM products p WHERE p.slug=? AND p.status='published' AND p.public_visibility=1 AND p.production_approved=1 AND EXISTS (SELECT 1 FROM configuration_profiles cp WHERE cp.product_id=p.id AND cp.approved=1) LIMIT 1');$q->execute([$slug]);return $q->fetch()?:null; }
