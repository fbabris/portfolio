<?php

abstract class Dbh{
    private $user;
    private $pwd;
    private $dbName;
    private $host;
    private $charset;

    protected function connect(){
        $this->user = "root";
        $this->pwd = "";
        $this->dbName = "portfolio";
        $this->host = "localhost";
        $this->charset = "utf8mb4";
        $pdo;
        try {
            $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName."; charset=".$this->charset;
            $pdo = new \PDO($dsn, $this->user, $this->pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOexception $e) {
            echo "Connection failed: ".$e->getMessage();
            die();
        }
    }
}

