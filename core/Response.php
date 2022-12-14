<?php 
namespace app\core;


class Response 
{
    public function setResponse(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}