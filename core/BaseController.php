<?php
namespace core;

class BaseController
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * 渲染并输出视图
     * @param string $view 视图文件路径
     * @param array $params 要渲染的数据
     * @return boolean
     */
    public function render(string $view, array $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require_once 'views/' . $view . Application::$app->config['template']['suffix'];
        Response::sendMsg(ob_get_clean());
        return true;
    }
    
    /**
     * 输出json
     * @param array $jsonArr
     * @return boolean
     */
    public function sendJson(array $jsonArr)
    {
        Response::sendJson($jsonArr);
        return true;
    }
}