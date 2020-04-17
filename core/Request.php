<?php
namespace core;

class Request
{
    /**
     * 获取get请求中的参数的值
     * @param string $key 参数名
     * @param mixed $default　默认值
     * @return mixed
     */
    public function get(string $key = null, $default = NULL)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }
    
    /**
     * 获取post请求中的参数的值
     * @param string $key 参数名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function post(string $key = null, $default = NULL)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }
    
    /**
     * 判断是否是post请求
     * @return bool
     */
    public function isPost() : bool
    {
        return !empty($_POST);
    }
}