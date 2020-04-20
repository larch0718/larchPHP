<?php
namespace core;

trait UtilsTrail
{
    /**
     * 判断value的值是否为空
     * @param mixed $value
     * @return bool
     */
    public static function isEmpty($value) : bool
    {
        return $value === null || $value === '' || $value === [] || is_string($value) && trim($value) === '';
    }
}