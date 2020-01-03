<?php include_once("./template/includes/header.php"); ?>

<?php

    if (!isset($_SESSION))
        session_start();

    if (empty($_SESSION["id_user"]))
        header("Location: index.php");

    require_once(dirname(__FILE__) ."/src/repositories/UserRepository.php");

    $messageError = "";
    $login = "";

    if (!empty($_GET["login"]))
        $login = $_GET["login"];

    if (!empty($_GET["message_login_error"]))
        $messageError = $_GET["message_login_error"];

    if (!empty($_SESSION["id_user"])){
        
        try {

            $userRepository = new UserRepository();
            $user = $userRepository->getAccountById($_SESSION["id_user"]);
            $characters = $userRepository->getCharacters($user->accno);
            $totalPlayerGod = $userRepository->getNumPlayerGOD();

        } catch (Exception $e){

            $messageError = $e->getMessage();

        }

    }
?>

<section class="session-block mt-3 pt-3 pb-3 text-white">
    <div class="row">
        <div class="col-12 pl-5 pr-5 mt-2">
            <h2 class="font-weight-bold">Minha Account</h2>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 pl-5 pr-5">
            <p class="font-weight-bold">Olá, você está logado com <strong><?php echo $user->accno; ?></strong>!</p>
            </br>
            <p class="font-weight-bold">Está account possui <strong class="text-danger"><?php echo ($user->points ? $user->points : 0); ?></strong> pontos premium!</p>
            </br>
            <p class="font-weight-bold"><img class="img-skill mr-2" src="public/images/add-user.png" />Para criar um novo character, <strong><a class="text-danger no-decoration" href="create_char.php">clique aqui</a></strong>!</p>
            <p class="font-weight-bold"><img class="img-skill mr-2" src="public/images/lock.png" />Se você deseja trocar sua senha, <strong><a class="text-danger no-decoration" href="change_password.php">clique aqui</a></strong>!</p>
            <?php
                if ($totalPlayerGod > 0){
                    ?>
                        <p class="font-weight-bold"><img class="img-skill mr-2" src="public/images/money.png" />Caso deseje adicionar pontos a um player, <strong><a class="text-danger no-decoration" href="premium_points.php">clique aqui</a></strong>!</p>
                    <?php
                }
            ?>
            <p class="font-weight-bold"><img class="img-skill mr-2" src="public/images/logout.png" />Caso deseja realizar o logoff, <strong><a class="text-danger no-decoration" href="src/actions/logoff.php">clique aqui</a></strong>!</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 pl-5 pr-5 mt-5 mb-3">
            <h2 class="font-weight-bold">Meus Characters</h2>
        </div>
    </div>

    <?php 

        if (count($characters) <= 0){
            ?>
                <div class="row mt-2">
                    <div class="col-12 pl-5 pr-5">
                        <p class="text-white">Nenhum char encontrado para está conta!</a>
                    </div>
                </div>
            <?php
        } else {
            foreach($characters AS $char){
                ?>
                    <div class="row mt-2">
                        <div class="col-12 pl-5 pr-5">
                            <a href="character.php?name=<?php echo $char->name; ?>"><h5><?php echo $char->name; ?></h5></a>
                        </div>
                        <div class="col-12 pl-5 pr-5">
                            <strong>Level: </strong><?php echo $char->skillLevel; ?>
                        </div>
                        <div class="col-12 pl-5 pr-5">
                            <strong>Vocação: </strong><?php echo $char->vocation; ?>
                        </div>
                        <div class="col-12 pl-5 pr-5">
                            <strong>Sexo: </strong><?php echo $char->sex; ?>
                        </div>
                        <div class="col-12 pl-5 pr-5">
    
                            <a href="delete_char.php?id_char=<?php echo $char->id; ?>" class="btn btn-danger btn-sm mt-1 mb-1">Excluir Char </a>
                            <div class="divider-bottom">
    
                            </div>
                        </div>
                        
                    </div>
                <?php
            }

        }
    ?>

</section>

<?php include_once("./template/includes/footer.php"); ?>
