<?php

require_once(dirname(dirname(__FILE__)) ."/repositories/UserRepository.php");

class CreateCharacter{

    public function __construct(){
        
        try {

            //Recupera os dados
            $data = $this->getData();

            //Valida os dados
            $data = $this->validaData($data);
            
            //Recupera a account
            if (!isset($_SESSION))
                session_start();

	    $resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeJbcsUAAAAAFnP1gQJTJi0aaDy2eT8JvvxIMTL&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);

            $resposta = json_decode($resposta);
            $converted_resposta = $resposta->success ? 'true' : 'false';

            if (empty($_POST['g-recaptcha-response']) or $_POST['g-recaptcha-response'] == '' or $converted_resposta == 'false')
                throw new Exception("Captcha inválido!");

    
            $userRepository = new UserRepository();
            $user = $userRepository->getAccountById($_SESSION["id_user"]);

            $data->account = $user->accno;

            //Verifica se o player name já não existe
            $character = $userRepository->getCharByName($data->name);

            if (!empty($character))
                throw new Exception("O nome escolhido já é utilizado por outro character!");

            //Salva o novo player e seus respectivos registros
            $userRepository->save($data);

            header("Location: ../../success_account_message.php?msg=Character criado com sucesso!");

        } catch (Exception $e){
            header("Location: ../../create_char.php?msgError=".$e->getMessage());
        }
        
    }

    private function validaData($data){
        
        if (empty($data->name))
            throw new Exception("Nome do character inválido!");

        if (empty($data->vocation))
            throw new Exception("Vocação inválida!");

        if ($data->vocation != "1" 
            && $data->vocation != "2" 
            && $data->vocation != "3" 
            && $data->vocation != "4")
            throw new Exception("Vocação inválida!");

        if ($data->sex != "F" 
            && $data->sex != "M")
            throw new Exception("Sexo inválido!");
        
        $data->sex = $data->sex === "M" ? "1" : "0";

        $temp = strspn("$data->name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM -");

        if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $data->name))
            throw new Exception("O nome do character encontra-se inválido!");

        if (preg_match("/^gm/i", $data->name))
            throw new Exception("A sigla GM não pode ser utilizada no nome do character!");

        if (preg_match("/^gamemaster/i", $data->name))
            throw new Exception("O nome gamemaster não pode ser utilizado no nome do character!");

        if (preg_match("/^god/i", $data->name))
            throw new Exception("O nome GOD não pode ser utilizado no nome do character!");

        
        if ($temp != strlen($data->name))
            throw new Exception("O nome do character contém caracteres inválidos!");

        if (strlen($data->name) < 2 || strlen($data->name) > 20)
            throw new Exception("O nome do character deve conter entre 2 e 20 caracteres!");

        return $data;

    }

    private function getData(){

        $data = new stdClass();

        if (!empty($_POST["txtNome"])){
            $data->name = trim(strip_tags($_POST["txtNome"]));
        } else {
            $data->name = null;
        }

        if (!empty($_POST["cmdVocacao"])){
            $data->vocation = trim(strip_tags($_POST["cmdVocacao"]));
        } else {
            $data->vocation = null;
        }

        if (!empty($_POST["cmdSexo"])){
            $data->sex = trim(strip_tags($_POST["cmdSexo"]));
        } else {
            $data->sex = null;
        }

        return $data;

    }
}

$class = new CreateCharacter();