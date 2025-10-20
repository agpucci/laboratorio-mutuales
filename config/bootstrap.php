<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/config.php';

spl_autoload_register(function($class){
    $map=[
        'Core\\'        => APP_ROOT.'/app/core/',
        'Controllers\\' => APP_ROOT.'/app/controllers/',
        'Models\\'      => APP_ROOT.'/app/models/'
    ];
    foreach($map as $p=>$dir){
        if(strpos($class,$p)===0){
            $path=$dir.str_replace('\\','/',substr($class,strlen($p))).'.php';
            if(file_exists($path)) require $path;
        }
    }
});

session_start();
if(empty($_SESSION['csrf_token'])) $_SESSION['csrf_token']=bin2hex(random_bytes(32));
