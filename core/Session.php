<?php 

namespace app\core;

class Session 
{
    protected const FLASH_KEY = 'flash_msgs';

    public function __construct()
    {
        session_start();
        $flashMsgs = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMsgs as $key => &$flashMsg){
            $flashMsg['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMsgs;

        
    }
    
    public function setFlash($key, $msg)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $msg,
        ];

    }

    public function getFlash(string $key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
    public function __destruct()
    {
        $flashMsgs = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMsgs as $key => &$flashMsg){
            if($flashMsg['remove']){
                unset($flashMsgs[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMsgs;
    }
}