<?php

    require_once(dirname(dirname(__FILE__)) ."/repositories/UserRepository.php");

    class DeleteCharacter{
        
        public function __construct(){

            try {

                if (!isset($_SESSION))
                    session_start();

                //Recupera os dados
                $data = $this->getData();
    
                //Valida os dados
                $this->validateData($data);

                $userRepository = new UserRepository();
                $user = $userRepository->getAccountById($_SESSION["id_user"]);

                $user = $userRepository->getAccountByLoginPassword($user->accno, $data->senha);

                if (empty($user))
                    throw new Exception("A senha digitada encontra-se inválida!");
                
                $userRepository->delete($data->idPlayer);

                header("Location: ../../success_account_message.php?msg=Character excluído com sucesso!");

            } catch (Exception $e){

                header("Location: ../../delete_char.php?id_char=".$data->idPlayer."&msgError=".$e->getMessage());

            }
            
        }

        private function validateData($data){

            if (empty($data->idPlayer))
                throw new Exception("O id do character é obrigatório!");

            if (empty($data->senha))
                throw new Exception("A senha da account é obrigatória!");

        }

        private function getData(){

            $data = new stdClass();

            if (!empty($_POST["txtId"])){
                $data->idPlayer = trim(strip_tags($_POST["txtId"]));
            } else {
                $data->idPlayer = null;
            }
    
            if (!empty($_POST["txtSenha"])){
                $data->senha = trim(strip_tags($_POST["txtSenha"]));
            } else {
                $data->senha = null;
            }

            return $data;

        }

    }

    $class = new DeleteCharacter();

?>