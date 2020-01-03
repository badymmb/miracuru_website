<?php include_once("./template/includes/header.php"); ?>

<?php

    $msgError = "";

    try {

        if (empty($_GET["type"]))
            throw new Exception("Defina o tipo de ranking que será acessado!");
        
        switch($_GET["type"]){
            case 'level':
                $idSkill = null;
                $skillName = "Level";
            break;
            case 'magic-level':
                $idSkill = null;
                $skillName = "Magic Level";
            break;
            case 'club':
                $idSkill = 1;
                $skillName = "Club";
            break;
            case 'axe':
                $idSkill = 3;
                $skillName = "Axe";
            break;
            case 'sword':
                $idSkill = 2;
                $skillName = "Sword";
            break;
            case 'distance':
                $idSkill = 4;
                $skillName = "Distance";
            break;
            case 'fist':
                $idSkill = 0;
                $skillName = "First";
            break;
            case 'fish':
                $idSkill = 6;
                $skillName = "Fish";
            break;
            case 'shield':
                $idSkill = 5;
                $skillName = "Shield";
            break;
            default:
                throw new Exception("O tipo de ranking informado é inválido!");
            break;
        }

        require_once(dirname(__FILE__)."/src/repositories/UserRepository.php");
        $userRepository = new UserRepository();
        $listaRanking = $userRepository->getRaking($_GET["type"], $idSkill);
        

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
                <div class="col-12">
                    <h2 class="font-weight-bold">Ranking</h2>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "level" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=level">
                                <img src="public/images/skill-level.png" alt="Level" />
                                Level
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "magic-level" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=magic-level">
                                <img src="public/images/skill-ml.png" alt="Magic Level" />
                                Magic Level
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "club" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=club">
                                <img src="public/images/skill-club.png" alt="Club" />
                                Club
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "axe" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=axe">
                                <img src="public/images/skill-axe.png" alt="Axe" />
                                Axe
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "sword" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=sword">
                                <img src="public/images/skill-sword.png" alt="Sword" />
                                Sword
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "distance" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=distance">
                                <img src="public/images/skill-dist.png" alt="Distance" />
                                Distance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "fist" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=fist">
                                <img src="public/images/skill-fist.png" alt="Fist" />
                                Fist
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "fish" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=fish">
                                <img src="public/images/skill-fish.gif" alt="Fish" />
                                Fish
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-0 text-white <?php echo ($_GET["type"] === "shield" ? "font-weight-bold" : ""); ?>" href="ranking.php?type=shield">
                                <img src="public/images/skill-shield.gif" alt="Shield" />
                                Shield
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 col-lg-8 col-xl-8 d-none d-sm-none d-md-block d-lg-block d-xl-block">
                    <table class="table table-striped table-dark">
                        <thead class="font-weight-bold">
                            <tr>
                                <td></td>
                                <td>Name</td>
                                <td><?php echo $skillName; ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($listaRanking AS $key => $ranking){
                                    ?>
                                        <tr>
                                            <td>#<?php echo ($key+1); ?></td>
                                            <td><a class="text-danger" href="character.php?name=<?php echo $ranking->name; ?>"><?php echo $ranking->name; ?></a></td>
                                            <td><?php echo $ranking->skill; ?></td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 d-block mt-3 d-sm-block d-md-none d-lg-none d-xl-none">
                    <?php
                        foreach($listaRanking AS $key => $ranking){
                            ?>
                                <div class="row mb-3 border-bottom-table">
                                    <div class="col-12">
                                        #<?php echo ($key+1); ?>
                                    </div>
                                    <div class="col-12 mt-1">
                                        <strong>Nome: </strong><a class="text-danger" href="character.php?name=<?php echo $ranking->name; ?>"><?php echo $ranking->name; ?></a>
                                    </div>
                                    <div class="col-12 mt-1">
                                        <strong><?php echo $skillName; ?>: </strong><?php echo $ranking->skill; ?>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </section>
<?php } ?>
<?php include_once("./template/includes/footer.php"); ?>