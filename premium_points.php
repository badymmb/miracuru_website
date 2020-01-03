<?php include_once("./template/includes/header.php"); ?>

<?php
    if (!isset($_SESSION))
        session_start();

    if (empty($_SESSION["id_user"]))
        header("Location: index.php?message_login_error=Você não possui acesso a está área!");

    require_once(dirname(__FILE__) ."/src/repositories/UserRepository.php");

    $userRepository = new UserRepository();
    $totalPlayerGod = $userRepository->getNumPlayerGOD();

    if ($totalPlayerGod <= 0)
        header("Location: index.php?message_login_error=Você não possui acesso a está área!");

    $lastMoviments = $userRepository->getLastMoviments();
    $players = $userRepository->getAllPlayers();

?>

<section class="session-block mt-3 pt-3 pb-3 text-white">
    <div class="row">
        <div class="col-12 pl-5 pr-5 mt-2">
            <h2 class="font-weight-bold">Área de Pontos Premium</h2>
        </div>
    </div>
    <form action="src/actions/add_points.php" method="POST" class="row mt-5">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="playerAccount">Player da account:</label>
                <select name="playerAccount" id="playerAccount" class="form-control">
                    <option value="0">Selecione o player </option>
                    <?php
                        foreach($players AS $player){
                            ?>
                                <option value="<?php echo $player->id; ?>"><?php echo $player->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="numberPoints">Número de pontos à conceder:</label>
                <input type="number" name="numberPoints" id="numberPoints" class="form-control" />
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2 d-flex justify-content-center">
            <button class="btn btn-success">Conceder Pontos</button>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2 d-flex justify-content-center">
            
            <?php
                if (!empty($_GET["message_error"])) {
            ?>
                <div class="alert alert-danger mt-3 w-100 text-center font-weight-bold">
                    <?php
                        echo $_GET["message_error"];
                    ?>
                </div>
            <?php
                }

                if (!empty($_GET["message_success"])){

            ?>
                    <div class="alert alert-success mt-3 w-100 text-center font-weight-bold">
                        <?php
                            echo $_GET["message_success"];
                        ?>
                    </div>
            <?php      
                }
            ?>
        </div>
    </form>

    <div class="row mt-5">
        <div class="col-12 pl-5 pr-5 mt-2">
            <h2 class="font-weight-bold">Extrato das últimas 50 movimentações</h2>
        </div>

        <div class="col-12 pl-5 pr-5 mt-2">
            <table class="table table-striped table-dark">
                <thead class="font-weight-bold">
                    <tr>
                        <td>Tipo Movimento:</td>
                        <td>Data e Hora:</td>
                        <td>Player:</td>
                        <td>Item:</td>
                        <td>Número de Pontos:</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($lastMoviments AS $item){
                            ?>
                                <tr>
                                    <td><?php echo $item->movimentType; ?></td>
                                    <td><?php echo $item->dateTime; ?></td>
                                    <td><?php echo $item->playerDebito; ?></td>
                                    <td><?php echo $item->itemDebito; ?></td>
                                    <td><?php echo $item->points; ?></td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include_once("./template/includes/footer.php"); ?>