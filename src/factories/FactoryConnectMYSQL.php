<?php


class FactoryConnectMYSQL{
    public static $conn;
    private $HOST_DB = "localhost";
    private $USERNAME_DB = "miracuruserver";
    private $PASSWORD_DB = "ADFAS@!#!@AFD";
    private $SCHEMA_DB = "miracuru";

    public function __construct(){
        $this->connect();
    }

    public function connect(){
        try {

            self::$conn = new PDO("mysql:host=".$this->HOST_DB.";dbname=".$this->SCHEMA_DB, $this->USERNAME_DB, $this->PASSWORD_DB);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->exec("set names utf8");

        } catch (PDOException $e){
            throw new Exception("Ocorreu um erro ao conectar no banco de dados!");
        }
    }

    public function desconnect(){
        self::$conn = null;
    }
}