<?php

require_once(dirname(dirname(__FILE__)) ."/factories/FactoryConnectServer.php");

class ServerRepository{

    private $factoryServerConnect;

    public function __construct(){
        $this->factoryServerConnect = new FactoryConnectServer();    
    }

    public function getServerStatus(){

        //Cria estrutura de retorno
        $retorno = new stdClass();
        $retorno->isErro             = false;
        $retorno->totalPlayersOnline = 0;
        $retorno->maxPlayersOnline   = 0;
        $retorno->upTime = "";

        // Manda conectar na database
        try {

            $this->factoryServerConnect->connectServer();

            if ($this->factoryServerConnect::$socket){

                //Cria estrutura de characters para consulta
                $info = chr(6).chr(0).chr(255).chr(255).'info';

                //Escreve a estrutura no socket
                fwrite($this->factoryServerConnect::$socket, $info);

                //Instancia a variavel de dados
                $data='';
                
                //Percorre a variavel de dados e appenda na estrutura
                while (!feof($this->factoryServerConnect::$socket))
                    $data .= fgets($this->factoryServerConnect::$socket, 4096);
                
                //Fecha a escrita dos arquivos
                fclose($this->factoryServerConnect::$socket);
                
                //Busca o número de players e o total de players
                preg_match('/players online="(\d+)" max="(\d+)"/', $data, $matches);

                //Cria a estrutura de retorno
                $retorno->totalPlayersOnline = (int)$matches[1];
                $retorno->maxPlayersOnline   = (int)$matches[2];

                //Calcula o uptime
                preg_match('/uptime="(\d+)"/', $data, $matches);
                $h = floor($matches[1] / 3600);
                $m = floor(($matches[1] - $h*3600) / 60);
                $retorno->upTime = $h."h e ".$m."m";
                
            } else {

                $retorno->isErro = true;

            }

        } catch (Exception $e){
            $retorno->isErro = true;
        }

        return $retorno;

    }
}