<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(404);exit;}

require dirname(__DIR__).'/app/bootstrap.php';
$pdo=db();$pdo->exec('CREATE TABLE IF NOT EXISTS schema_migrations (migration VARCHAR(190) PRIMARY KEY, applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
$file=ROOT.'/database/001_schema.sql';$key=basename($file);$q=$pdo->prepare('SELECT migration FROM schema_migrations WHERE migration=?');$q->execute([$key]);
if(!$q->fetch()){$sql=file_get_contents($file);foreach(array_filter(array_map('trim',explode(';',$sql))) as $statement)$pdo->exec($statement);$s=$pdo->prepare('INSERT INTO schema_migrations(migration) VALUES(?)');$s->execute([$key]);echo "Applied $key\n";}else echo "Already applied: $key\n";
