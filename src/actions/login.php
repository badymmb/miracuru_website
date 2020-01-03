<?php

    require_once(dirname(dirname(__FILE__)) ."/repositories/UserRepository.php");

    class Login{


        public function __construct(){
            
            try {

                $data = $this->getData();
                $this->validaData($data);
                $this->login($data);

            } catch (Exception $e){

                Header("Location: ../../index.php?message_login_error=".$e->getMessage()."&login=".$data->login);
            }

        }

        private function login($data){

            $userRepository = new UserRepository();
            $user = $userRepository->getAccountByLoginPassword($data->login, $data->password);
        
            if (empty($user))
                throw new Exception("Usuário e/ou senha inválidos!");
        
            if (!isset($_SESSION))
                session_start();
        
            $_SESSION["id_user"] = $user->id;
        
            header("Location: ../../index.php");

        }

        private function validaData($data){
            
            if (empty($data->login))
                throw new Exception("O campo de login encontra-se inválido!");

            if (empty($data->password))
                throw new Exception("O campo de senha encontra-se inválido!");

        }

        private function getData(){

            $stdClass = new stdClass();

            if (!empty($_POST["txtUser"])){
                $stdClass->login = trim($_POST["txtUser"]);
            } else {
                $stdClass->login = null;
            }

            if (!empty($_POST["txtPassword"])){
                $stdClass->password = trim($_POST["txtPassword"]);
            } else {
                $stdClass->password = null;
            }

            return $stdClass;

        }

    }

    $class = new Login();

?>