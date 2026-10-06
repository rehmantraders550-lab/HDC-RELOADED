<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(404);exit;}

require dirname(__DIR__).'/app/bootstrap.php';
$email=strtolower(trim($argv[1]??''));
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){fwrite(STDERR,"Usage: php bin/create-admin.php admin@example.com\n");exit(2);}
if(PHP_OS_FAMILY==='Windows'){fwrite(STDERR,"Run this command in a Unix-compatible PHP CLI so the password prompt can be hidden.\n");exit(2);}
fwrite(STDOUT,'New password (14+ characters): ');system('stty -echo');$password=trim((string)fgets(STDIN));system('stty echo');fwrite(STDOUT,"\nConfirm password: ");system('stty -echo');$confirm=trim((string)fgets(STDIN));system('stty echo');fwrite(STDOUT,"\n");
if(strlen($password)<14||!hash_equals($password,$confirm)){fwrite(STDERR,"Passwords must match and be at least 14 characters.\n");exit(2);}
$q=db()->prepare('INSERT INTO admin_users(email,password_hash) VALUES(?,?)');$q->execute([$email,password_hash($password,PASSWORD_DEFAULT)]);echo "Administrator created for $email\n";
