<?php
require 'vendor/autoload.php';


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo $_ENV['SERVER_NAME'];
echo $_ENV['DB_USER'];
echo $_ENV['DB_PASSWORD'];
echo $_ENV['DB_NAME'];
