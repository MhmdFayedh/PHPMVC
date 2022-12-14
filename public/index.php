<?php 

require_once __DIR__."/../vendor/autoload.php";



use Dotenv\Dotenv;
use app\core\Application;
use app\Controller\AppController;
use app\Controller\AuthController;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => \app\model\User::class,
    'db' => [
        'dsn' => $_ENV['BD_DNS'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [AppController::class, 'homeIndex']); 
$app->router->get('/contact', [AppController::class, 'contactIndex']);
$app->router->post('/contact', [AppController::class, 'store']);


$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();