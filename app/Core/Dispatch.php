<?php

namespace App\Core;

use Exception;
use Throwable;

class Dispatch
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public static function actionController($controller, $action, $params = [])
    {

        if (!class_exists($controller)) {
            return site()->errorPage();
        }

        $method= self::getMethodFromAction($action);

        $controller_object = new $controller();

        if (!is_callable([$controller_object, $method])) {
            return site()->errorPage();
        }

        return $controller_object->$method($params);
    }

    public static function getMethodFromAction(string $action): string
    {
        return lcfirst($action) . 'Action';
    }
}
