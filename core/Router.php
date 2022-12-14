<?php

namespace app\core;

class Router 
{
    private Request $request;
    private Response $response;
    protected array $routes = [];

    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMehtod();
        $callback = $this->routes[$method][$path] ?? false;
        

        if($callback === false){
            Application::$app->response->setResponse(404);
            return $this->render('not-found');

        }
        if(is_string($callback)){
            return $this->render($callback);
        }

        if(is_array($callback)){
            if(is_array($callback)){
                [$class, $method] = $callback;
    
                if(class_exists($class)){
                    $class = new $class();
                    if(method_exists($class, $method)){
                        return call_user_func_array([$class, $method],[
                            $this->request, 
                            $this->response]);
                    }
                }
            }
        }
        
        return call_user_func($callback);
    }

    public function render($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContet = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContet, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR. "/View/layout/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params){
        foreach($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR. "/View/$view.php";
        return ob_get_clean();
    }
}