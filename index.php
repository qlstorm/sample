<?php

    use lib\Init;

    function autoload($className) {
        include str_replace('\\', '/', $className) . '.php';
    }

    spl_autoload_register('autoload');

    $param = 0;

    $controller = 'loads';

    $action = 'show';

    if (isset($_SERVER['PATH_INFO'])) {
        $url = explode('/', $_SERVER['PATH_INFO']);

        $controller = $url[1];
        
        if (isset($url[2])) {
            $param = $url[2];
        }

        if (!is_numeric($param)) {
            $action = $param;
        }

        if (isset($url[3])) {
            $param = $url[3];
        }
    }
    
    Init::init();

    call_user_func("controllers\\$controller::$action", (int)$param);
    