<?php
namespace app\core;
use app\core\Application;

class Controller 
{
    private string $layout = 'main';

    public function render($view, $params = [])
    {
        return Application::$app->router->render($view, $params);
    }

    public function getLayout()
    {
        return $this->layout = 'main';
    }

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }
}
