<?php

require_once(dirname(dirname(__FILE__)) ."/repositories/UserRepository.php");

class EfetuarCadastro{

    public function __construct(){
        
        $data = $this->getData();

        try {

            $this->validateData($data);
            $userRepository = new UserRepository();
            $user = $userRepository->getAccountByUserName($data->login);

            if (!empty($user))
                throw new Exception("Login já existente!");

	    $resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeJbcsUAAAAAFnP1gQJTJi0aaDy2eT8JvvxIMTL&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);

            $resposta = json_decode($resposta);
            $converted_resposta = $resposta->success ? 'true' : 'false';

            if (empty($_POST['g-recaptcha-response']) or $_POST['g-recaptcha-response'] == '' or $converted_resposta == 'false')
                throw new Exception("Captcha inválido!");

            $userRepository->createAccount($data->login, $data->password);

            header("Location: ../../account.php");

        } catch (Exception $e){
            header("Location: ../../cadastro.php?message_error=".$e->getMessage()."&txtUser=".$data->login);
        }

    }
    
    private function validateData($data){

        if (empty($data->login))
            throw new Exception("O campo de login encontra-se inválido!");

        if (!is_numeric($data->login))
            throw new Exception("O campo de login deve conter apenas números, sendo de 6 a 8 caracteres!");

        if (strlen($data->login) < 6 || strlen($data->login) > 8)
            throw new Exception("O campo de login deve conter de 6 a 8 caracteres númericos!");

        if ($data->login == "111111" || $data->login == "1111111" || $data->login == "11111111"
            || $data->login == "222222" || $data->login == "2222222" || $data->login == "22222222"
            || $data->login == "333333" || $data->login == "3333333" || $data->login == "33333333"
            || $data->login == "444444" || $data->login == "4444444" || $data->login == "44444444"
            || $data->login == "555555" || $data->login == "5555555" || $data->login == "55555555"
            || $data->login == "666666" || $data->login == "6666666" || $data->login == "66666666"
            || $data->login == "777777" || $data->login == "7777777" || $data->login == "77777777"
            || $data->login == "888888" || $data->login == "8888888" || $data->login == "88888888"
            || $data->login == "999999" || $data->login == "9999999" || $data->login == "99999999")
            throw new Exception("Sua senha deve ser segura, não utilize números sequênciais!");

        if (empty($data->password))
            throw new Exception("O campo senha encontra-se inválido!");

        if (strlen($data->password) < 6)
            throw new Exception("O campo de senha deve conter no mínimo 6 caracteres!");

        if (strspn($data->password, "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890 ") != strlen($data->password))
            throw new Exception("Sua senha deve consistir de letras maiúsculas e minúsculas, números e espaços!");

        if (empty($data->confPassword))
            throw new Exception("O campo de confirmação de senha encontra-se inválido!");

        if (strlen($data->confPassword) < 6)
            throw new Exception("O campo de confirmação de senha deve conter no mínimo 6 caracteres!");

        if ($data->password !== $data->confPassword)
            throw new Exception("O campo de confirmação de senha deve ser igual ao campo senha!");
   
    }

    private function getData(){

        $data = new stdClass();

        if (!empty($_POST["txtUser"])){
            $data->login = trim(strip_tags($_POST["txtUser"]));
        } else {
            $data->login = null;
        }
    
        if (!empty($_POST["txtPassword"])){
            $data->password = trim(strip_tags($_POST["txtPassword"]));
        } else {
            $data->password = null;
        }
    
    
        if (!empty($_POST["txtConfPassword"])){
            $data->confPassword = trim(strip_tags($_POST["txtConfPassword"]));
        } else {
            $data->confPassword = null;
        }

        return $data;

    }
}

$efetuarCadastro = new EfetuarCadastro();   