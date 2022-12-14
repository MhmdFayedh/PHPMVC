<?php 

namespace app\Controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\model\User;
use app\model\LoginForm;

class AuthController extends Controller
{
    public function login(Request $request, Response $response){
        // $this->setLayout('auth');
        $loginForm = new LoginForm();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()){
                $response->redirect('/');
                return;
            }
        }
        return $this->render('login' , [
            'model' => $loginForm,
        ]);
    }



    public function register(Request $request, Response $response)
    {
        $user = new User();
        if($request->isPost()){
            $user->loadData($request->getBody());
            
            if($user->validate() && $user->save()){
                Application::$app->session->setFlash('success', 'Thanks For Registering');
                $response->redirect('/');
                exit;
            }

            
        }
        
        return $this->render('register', [
            'model' => $user,
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
}