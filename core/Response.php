<?php
namespace core;

class Response
{
    /**
     * 输出字符串
     * @param string $message
     */
    public static function sendMsg(string $message)
    {
        echo $message;
    }
    
    /**
     * 输出json字符串
     * @param array $arr
     */
    public static function sendJson(array $arr)
    {
        header('Content-type:application/json');
        echo json_encode($arr);
    }
    /**
     * 404处理
     */
    public static function goNotFound()
    {
        http_response_code(404);
        die('<h1>Page not found</h1>');
    }
    
    /**
     * 403处理
     */
    public static function goForbidden()
    {
        http_response_code(403);
        die('<h1>Forbidden<h1> <h2>Access to this resource on the server is denied!<h2>');
    }
}