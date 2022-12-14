<?php 

namespace app\Controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class AppController extends Controller
{
    


    public function homeIndex(){

        $params = [
            'name' => "MohammedBinFayedh",
            'edu' => "bachelor of computer science",
            'gradute_at' => '2022/11/21',
            'specialty' => 'Web Developer, PHP and Laravel Developer'
        ];
        return $this->render('home', $params);
    }

    public function contactIndex(){
        return $this->render('contact');
    }
    public function store()
    {
        $body = Application::$app->request->getBody();
        echo "<pre>";    
        print_r($body);
        echo "</pre>";
        exit;
    }
}