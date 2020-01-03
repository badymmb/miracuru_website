<?php

    if (!isset($_SESSION))
        session_start();

    require_once(dirname(dirname(dirname(__FILE__))) ."/src/repositories/UserRepository.php");

    $messageError = "";
    $login = "";

    if (!empty($_GET["login"]))
        $login = $_GET["login"];

    if (!empty($_GET["message_login_error"]))
        $messageError = $_GET["message_login_error"];

    if (!empty($_SESSION["id_user"])){
        
        $userRepository = new UserRepository();
        $user = $userRepository->getAccountById($_SESSION["id_user"]);

    }
?>
<section class="session-block session_login mt-3">
    <div class="d-flex align-items-center">
        <img src="public/images/account.gif" />
        <h3 class="ml-2">Account</h3>
    </div>
    <?php

        if(!empty($_SESSION["id_user"])) {
            ?>
                <h4 class="mt-3 text-white">Olá,</h4>
                <p class="text-white">Você está logado com: <strong><?php echo $user->accno; ?></strong>!</p>
                <p class="text-white">Para acessar sua conta <strong><a class="text-danger no-decoration" href="account.php">clique aqui</a></strong></p>
                <p class="text-white">Para sair <strong><a class="text-danger no-decoration" href="src/actions/logoff.php">clique aqui</a></strong>!</p>
            <?php
        } else {

    ?>
        <form action="src/actions/login.php" method="POST" class="mt-4 form-cadastro">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputSearchPerson"><i class="fas fa-user"></i></span>
                </div>
                <input 
                    type="text" 
                    class="form-control" 
                    id="txtUser"
                    name="txtUser"
                    placeholder="Entre com seu login" 
                    aria-label="Entre com seu login" 
                    aria-describedby="basic-addon1"
                    value="<?php echo $login; ?>" />
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputSearchPerson"><i class="fas fa-key"></i></span>
                </div>
                <input 
                    type="password" 
                    class="form-control" 
                    id="txtPassword"
                    name="txtPassword"
                    placeholder="Entre com sua senha" 
                    aria-label="Entre com sua senha" 
                    aria-describedby="basic-addon1" />
            </div>

            <div class="w-100 d-flex justify-content-end">
                <span class="link-cadastro text-white">Não possui conta, <a class="text-danger" href="cadastro.php">clique aqui </a>e cadastre-se!</span>
            </div>

            <div class="w-100 d-flex justify-content-center mt-3">
                <button class="btn btn-success d-flex align-items-center">
                    Acessar 
                    <i class="fas fa-arrow-circle-right ml-2"> </i>
                </button>
            </div>

        </form>
    <?php
        }
    ?>

    <?php
        if (!empty($messageError)){
    ?>
        <div class="alert alert-danger w-100 mt-3 text-center">
            <?php echo $messageError; ?>
        </div>
    <?php
        }
    ?>
</section>