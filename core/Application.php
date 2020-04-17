<?php
namespace core;

class Application
{
    public $config;
    public $route;
    
    public static $app;

    public function __construct(array $config)
    {
        $this->config = $config;
        self::$app = $this;
    }

    public function run()
    {
        list($controllerName, $actionName) = $this->route();
        Ioc::runMethod($controllerName, $actionName);
    }

    public function route(string $namesapce = 'controllers\\') : array
    {
        $request = $_REQUEST;
        $router = $request['r'];
        unset($request['r']);
        $this->route = $router;
        list($controllerName, $actionName) = explode('/', $router);
        $controllerName = $namesapce . ucfirst($controllerName) . 'Controller';
        $actionName = 'action' . ucfirst($actionName);
        return [$controllerName, $actionName];
    }
}