<?php include_once("./template/includes/header.php"); ?>

<?php

    date_default_timezone_set("America/Sao_Paulo");

    require_once(dirname(__FILE__)."/src/repositories/UserRepository.php");

    $userRepository = new UserRepository();
    $msgError = "";

    try {

        if (empty($_GET["name"]))
            throw new Exception("Informe o nome do player que deseja buscar!");

        $character = $userRepository->getPlayerByName($_GET["name"]);

    } catch (Exception $e){
        $msgError = $e->getMessage();
    }

    if (!empty($msgError)){
        ?>
            <section class="session-block mt-3 pt-3 pb-3 text-white">
                <div class="row">
                    <div class="col-12 pl-5 pr-5 mt-2">
                        <div class="alert alert-danger text-center font-weight-bold">
                            <?php echo $msgError; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
    } else {
?>
    <section class="session-block mt-3 pt-3 pb-3 text-white">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <h2 class="font-weight-bold"><?php echo $character->name; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <strong>Vocação: </strong><?php echo $character->vocation; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <strong>Sexo: </strong><?php echo $character->sex; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <strong>Experiência: </strong><?php echo $character->experience; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                <img src="public/images/skill-level.png" class="img-skill" />
                <strong class="ml-2">Level: </strong><?php echo $character->skillLevel; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <img src="public/images/skill-ml.png" class="img-skill" />
                <strong class="ml-2">Magic Level: </strong><?php echo $character->skillMaglevel; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <img src="public/images/skill-fist.png" class="img-skill" />
                <strong class="ml-2">Fist: </strong><?php echo $character->skillFist; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <img src="public/images/skill-axe.png" class="img-skill" />
                <strong class="ml-2">Axe: </strong><?php echo $character->skillAxe; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <img src="public/images/skill-sword.png" class="img-skill" />
                <strong class="ml-2">Sword: </strong><?php echo $character->skillSword; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <img src="public/images/skill-club.png" class="img-skill" />
                <strong class="ml-2">Club: </strong><?php echo $character->skillClub; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <img src="public/images/skill-dist.png" class="img-skill" />
                <strong class="ml-2">Distance: </strong><?php echo $character->skillDistance; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">
                <img src="public/images/skill-fish.gif" class="img-skill" />
                <strong class="ml-2">Fishing: </strong><?php echo $character->skillFish; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4">
                <div class="w-100">
                    <strong><strong><?php echo count($character->deaths); ?></strong> Morte(s)</strong>
                    <div class="divider-bottom mb-3"></div>
                </div>
                <?php
                    foreach ($character->deaths AS $death){

                        if (!empty($death->playerId)){
                            $nameKiller = "<a class='text-danger font-weight-bold' href=\"character.php?name=" .$death->killer. "\">" .$death->killer. "</a>";
                        } else {
                            $nameKiller = $death->killer;
                        }

                        echo "Morto level " .$death->level. " por ".$nameKiller." (" .date('d/m/Y H:i:s A',$death->date). ").<br>";
                    }
                ?>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4">
                <div class="w-100">
                    <strong><strong><?php echo count($character->kills); ?></strong> Assassinato(s)</strong>
                    <div class="divider-bottom mb-3"></div>
                </div>
                <?php
                    foreach ($character->kills AS $kill){

                        $nameKiller = "<a class='text-danger font-weight-bold' href=\"character.php?name=" .$kill->name. "\">" .$kill->name. "</a>";
                        
                        echo "Matou o ".$nameKiller." no level ".$kill->level." (" .date('d/m/Y H:i:s A',$kill->date). ").<br>";

                    }
                ?>
            </div>
        </div>
    </section>
<?php } ?>
<?php include_once("./template/includes/footer.php"); ?>