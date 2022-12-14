<?php 

namespace app\core;

use app\core\Application as CoreApplication;
use Collator;

class Application 
{
    public static string $ROOT_DIR;
    public string $userClass;
    public static Application  $app;
    public Request $request;
    public Router $router;
    public Response $response;
    public Controller $controller;
    public Database $DB;
    public Session $session;
    public ?DBModel $user;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->DB = new Database($config['db']);
        $this->session = new Session();

        $primaryValue = $this->session->get('user');

        if($primaryValue){
        $primaryKey = $this->userClass::primaryKey();
        $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
    } else {
        $this->user = null;
    }
    }

    public function run(){
        echo  $this->router->resolve();
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    
    public function setController(): void
    {
        $this->controller;
    }

    public function login(DBModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public function isGust()
    {
        return !self::$app->user;
    }
}