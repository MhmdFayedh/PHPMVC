<?php 

require_once __DIR__."/vendor/autoload.php";



use Dotenv\Dotenv;
use app\core\Application;
use app\Controller\AppController;
use app\Controller\AuthController;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['BD_DNS'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];

$app = new Application(__DIR__, $config);

$app->DB->applyMigrations();