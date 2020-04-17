<?php
namespace core;

use ReflectionClass;
use ReflectionException;

# 依赖注入容器类
class Ioc
{
    /**
     * 根据类名获取类的实例
     * @param string $className　类名
     * @param array $params 类的构造函数的参数
     * @return object|NULL
     */
    public static function getInstence(string $className, array $params = [])
    {
        try {
            $reflectionClass = self::getReflectionClass($className);
            return self::getInstance($reflectionClass, $params);
        } catch (ReflectionException $e) {
            Response::sendMsg($e->getMessage());
        }
    }
    /**
     * 获取ReflectionClass类的实例
     * @param string $className　类名
     * @return object
     */
    private static function getReflectionClass(string $className)
    {
        return new ReflectionClass($className);
    }
    
    /**
     * 根据ReflectionClass类的实例获取目标类的实例
     * @param ReflectionClass $reflectionClass
     * @param array $params　类的构造函数的参数
     * @return object
     */
    private static function getInstance(ReflectionClass $reflectionClass, array $params = [])
    {
        $reflectConstruct = $reflectionClass->getConstructor();
        if ($reflectConstruct === null) {
            return $reflectionClass->newInstanceArgs();
        }
        $parameters = $reflectConstruct->getParameters();
        $parameters = self::handleParameters($parameters);
        return $reflectionClass->newInstanceArgs(array_merge($parameters, $params));
    }
    
    /**
     * 类的参数处理
     * @param array $parameters 要处理的参数
     * @return array
     */
    private static function handleParameters(array $parameters = [])
    {
        foreach ($parameters as $index => $parameter) {
            if ($parameterClass = $parameter->getClass()) {
                $parameterClassName = $parameterClass->getName();
                $ParameterObj = self::getInstence($parameterClassName);
                $parameters[$index] = $ParameterObj;
            } else if ($parameter->isDefaultValueAvailable()) {
                $parameters[$index] = $parameter->getDefaultValue();
            } else {
                switch ($parameter->getType()) {
                    case 'int':
                        $parameters[$index] = 0;
                        break;
                    case 'string':
                        $parameters[$index] = '';
                        break;
                    case 'array':
                        $parameters[$index] = [];
                        break;
                    case 'float':
                        $parameters[$index] = 0;    
                        break;
                    default:
                        $parameters[$index] = '';
                        break;
                }
            }
        }
        return $parameters;
    }
    
    /**
     *　执行方法
     * @param string $className　类名
     * @param string $methodsName　方法名
     * @param array $constructParams　类的构造函数的参数
     * @param array $methodParams　方法的参数
     * @return mixed
     */
    public static function runMethod(string $className, string $methodsName, array $constructParams = [], array $methodParams = [])
    {
        try {
            $reflectionClass = self::getReflectionClass($className);
            $method = $reflectionClass->getMethod($methodsName);
            if ($method->isStatic()) {
                $obj = null;
            } else {
                $obj = self::getInstance($reflectionClass, $constructParams);
            }
            $method->invokeArgs($obj, $methodParams);
        } catch (ReflectionException $e) {
            Response::sendMsg($e->getMessage());
        }
    }
}