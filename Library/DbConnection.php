<?php

class DbConnection
{
    private static $instance;
    private $pdo;

    private function __clone() {}
    private function __wakeup() {}

    private function __construct($host, $user, $pass, $db)
    {
        $dsn = "mysql:host={$host}; dbname={$db}";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->pdo->exec('set names utf8');
        $this->pdo->exec('SET CHARACTER SET utf8');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new DbConnection(DB_URL, DB_USER, DB_PWD, DB_NAME);
        }

        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }



}