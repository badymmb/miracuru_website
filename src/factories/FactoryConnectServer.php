<?php

class FactoryConnectServer{

    private $host = "127.0.0.1";
    private $port = "7171";
    public static $socket;

    public function connectServer(){
        
        self::$socket = @fsockopen($this->host,$this->port, $errno, $errstr, 1);

        if ($errno)
            throw new Exception("Ocorreu um erro ao conectar no servidor!");

    }

    public function desconectServer(){
        
        self::$socket = null;
        
    }


}