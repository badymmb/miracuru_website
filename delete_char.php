﻿<?php include_once("./template/includes/header.php"); ?>
<?php
    require_once(dirname(__FILE__) ."/src/repositories/UserRepository.php");

    if (!isset($_SESSION))
        session_start();

    if (empty($_SESSION["id_user"]))
        header("Location: index.php");

    $idCharacter = null;
    $msgError = "";

    if (!empty($_GET["msgError"]))
        $msgError = $_GET["msgError"];

    if (!empty($_GET["id_char"]))
    {
        $idCharacter = $_GET["id_char"];
        $userRepository = new UserRepository();
        $player = $userRepository->getPlayerById($idCharacter);
        $user = $userRepository->getAccountById($_SESSION["id_user"]);

        if($player->accid != $user->id)
	    header("Location: ../../delete_char.php?msgError=Você não tem autorização para deletar esse char");
    }

    $namePlayer = "";

    if (!empty($player))
        $namePlayer = $player->name;
        
?>

<section class="session-block mt-3 pt-3 pb-3 text-white">
    <?php if (empty($msgError) || $msgError != 'Você não tem autorização para deletar esse char') {
    ?>
	<form action="src/actions/delete_character.php" method="POST" class="row text-center">
        <input type="hidden" name="txtId" id="txtId" value="<?php echo $idCharacter; ?>"/>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <h5>Você realmente deseja excluir o char <?php echo $namePlayer; ?>?</h5>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <div class="form-group text-left">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtSenha">Se sim, preencha sua senha para confirmar:</label>
                <input type="password" class="form-control" name="txtSenha" id="txtSenha" placeholder="Entre com sua senha..." />
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <button class="btn btn-success">Sim</button>
            <a href="account.php" class="btn btn-danger ml-2">Não</a>
        </div>

        <?php
   }
            if (!empty($msgError)){
        ?>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
                    <div class="alert alert-danger text-center">
                        <?php echo $msgError; ?>
                    </div>
                </div>

        <?php
            }
        ?>
    </form>
</section>
<?php include_once("./template/includes/footer.php"); ?>