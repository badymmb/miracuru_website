<?php include_once("./template/includes/header.php"); ?>
<?php

    if (!isset($_SESSION))
        session_start();

    if (empty($_SESSION["id_user"]))
        header("Location: index.php");
        
    $msg = "A operação foi realizada com sucesso!";

    if (!empty($_GET["msg"]))
        $msg = $_GET["msg"];
?>

<section class="session-block mt-3 pt-3 pb-3 text-white">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <p class="alert alert-success text-center"><?php echo $msg; ?></p>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4 text-center">
            <a href="account.php" class="btn btn-danger">Voltar</a>
        </div>
    </div>
</section>

<?php include_once("./template/includes/footer.php"); ?>