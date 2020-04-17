<?php

namespace core;

class DbHelper
{
    private static $_helper = null;
    private static $_dbName = null;
    private $_db = null;
    private function __construct()
    {
        $dbArr = Application::$app->config[self::$_dbName];
        $dsn = "mysql:host={$dbArr[host]};port={$dbArr[port]};dbname={$dbArr[dbname]}";
        $this->_db = new \PDO($dsn, $dbArr['user'], $dbArr['pass']);
    }
    
    private function __clone() {}
    
    private function __wakeup() {}
    
    public static function init(string $dbName)
    {
        if (self::$_helper === null) {
            self::$_dbName = $dbName;
            self::$_helper = new self();
        }
        return self::$_helper;
    }
    
    public function getDb()
    {
        if ($this->_db === null) {
            self::init(self::$_dbName);
        }
        return $this->_db;
    }
    
    public function closeDb()
    {
        $this->_db = null;
    }
}