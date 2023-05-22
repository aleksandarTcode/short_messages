<?php

class Database {

    private static $instance;
    private $conn;

    private function __construct()
    {
        $host = DB_HOST;
        $user = DB_USER;
        $password = DB_PASS;
        $base = DB_NAME;
        try{
        $this->conn = new PDO("mysql:host=$host;dbname=$base",$user,$password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        echo "Connected successfully";
        } catch (PDOException $ex){
            echo "Connection failed: " . $ex->getMessage();
        }
    }

    public static function getInstance(){
        if (!self::$instance){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->conn;
    }

}

$database = Database::getInstance()->getConnection();



?>