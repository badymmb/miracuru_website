<?php

require_once(dirname(dirname(__FILE__)) ."/repositories/UserRepository.php");

class AddPoints{

    public function __construct(){
        
        try {

            $data = $this->getDate();
            $this->validateDate($data);

            $userRepository = new UserRepository();
            $account = $userRepository->getAccountByPlayerId($data->playerAccount);
            $player = $userRepository->getPlayerById($data->playerAccount);

            if (empty($account))
                throw new Exception("Account do player inválida!");

            $userRepository->concederPontos($account->id, $data->numberPoints, $player->name);

            header("Location: ../../premium_points.php?message_success=Pontos concedidos com sucesso!");

        } catch (Exception $e){
            header("Location: ../../premium_points.php?message_error=".$e->getMessage());
        }

    }

    private function validateDate($data){

        if (empty($data->playerAccount))
            throw new Exception("Selecione um player válido!");

        if (empty($data->numberPoints))
            throw new Exception("Digite um número de pontos válido!");

        if (!is_numeric($data->numberPoints))
            throw new Exception("O número de pontos deve ser númerico!");

        if ($data->numberPoints <= 0)
            throw new Exception("O número de pontos deve ser positivo!");

    }

    private function getDate(){
        
        $data = new stdClass();

        if (!empty($_POST["playerAccount"])){
            $data->playerAccount = trim(strip_tags($_POST["playerAccount"]));
        } else {
            $data->playerAccount = null;
        }

        if (!empty($_POST["numberPoints"])){
            $data->numberPoints = trim(strip_tags($_POST["numberPoints"]));
        } else {
            $data->numberPoints = null;
        }

        return $data;

    }
}

$addPoints = new AddPoints();