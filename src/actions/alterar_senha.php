<?php

require_once(dirname(dirname(__FILE__)) ."/repositories/UserRepository.php");


class AlterarSenha{

    public function __construct(){

        try {

            //Recupera os dados
            $data = $this->getData();
    
            //Valida os dados
            $this->validateData($data);
    
            //Recupera a account
            if (!isset($_SESSION))
            session_start();
    
            $userRepository = new UserRepository();
            $user = $userRepository->getAccountById($_SESSION["id_user"]);
            $user = $userRepository->getAccountByLoginPassword($user->accno, $data->senha);
    
            if (empty($user))
                throw new Exception("A senha atual digitada encontra-se inválida!");
    
            $userRepository->changePassword($user->accno, $data->novaSenha);
    
            header("Location: ../../success_account_message.php?msg=Senha alterada com sucesso!");

        } catch (Exception $e){
            header("Location: ../../change_password.php?msgError=".$e->getMessage());
        }


    }

    private function validateData($data){

        if (empty($data->novaSenha))
            throw new Exception("O campo nova senha encontra-se inválido!");

        if (strlen($data->novaSenha) < 6)
            throw new Exception("O campo de nova senha deve conter no mínimo 6 caracteres!");

        if (strspn($data->novaSenha, "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890 ") != strlen($data->novaSenha))
            throw new Exception("Sua nova senha deve consistir de letras maiúsculas e minúsculas, números e espaços!");

        if (empty($data->confSenha))
            throw new Exception("O campo de confirmação de senha encontra-se inválido!");

        if (strlen($data->confSenha) < 6)
            throw new Exception("O campo de confirmação de senha deve conter no mínimo 6 caracteres!");

        if ($data->novaSenha !== $data->confSenha)
            throw new Exception("O campo de confirmação de senha deve ser igual ao campo senha!");

    }

    private function getData(){

        $data = new stdClass();

        if (!empty($_POST["txtSenhaAntiga"])){
            $data->senha = trim(strip_tags($_POST["txtSenhaAntiga"]));
        } else {
            $data->senha = null;
        }
        
        if (!empty($_POST["txtNovaSenha"])){
            $data->novaSenha = trim(strip_tags($_POST["txtNovaSenha"]));
        } else {
            $data->novaSenha = null;
        }
        
        if (!empty($_POST["txtConfNovaSenha"])){
            $data->confSenha = trim(strip_tags($_POST["txtConfNovaSenha"]));
        } else {
            $data->confSenha = null;
        }

        return $data;

    }

}

$class = new AlterarSenha();