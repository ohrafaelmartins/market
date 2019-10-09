<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
class DB
{
    private static $instance;
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                self::$instance->setAttribute(PDO::ATTR_TIMEOUT, 15);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
        return self::$instance;
    }
    public static function prepare($sql)
    {
        return self::getInstance()->prepare($sql);
    }
    public static function getLastId()
    {
        return self::getInstance()->lastInsertId();
    }
}
