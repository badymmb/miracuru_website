<?php include_once("./template/includes/header.php"); ?>
<?php

    if (!isset($_SESSION))
        session_start();

    if (empty($_SESSION["id_user"]))
        header("Location: index.php");

    $msgError = "";

    if (!empty($_GET["msgError"]))
        $msgError = $_GET["msgError"];

?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
  var onloadCallback = function() {
  };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>

<section class="session-block mt-3 pt-3 pb-3 text-white">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <h2 class="font-weight-bold">Criar Character</h2>
        </div>
    </div>
    <form action="src/actions/create_character.php" method="POST" class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtNome">Nome:</label>
                <input type="text" class="form-control" name="txtNome" id="txtNome" placeholder="Entre com o nome do player..." />
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="cmdVocacao">Vocação:</label>
                <select class="form-control" name="cmdVocacao" id="cmdVocacao">
                    <option value="1">Sorcerer</option>
                    <option value="2">Druid</option>
                    <option value="3">Paladin</option>
                    <option value="4">Knight</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="cmdSexo">Sexo:</label>
                <select class="form-control" name="cmdSexo" id="cmdSexo">
                    <option value="F">Feminino</option>
                    <option value="M">Masculino</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group" style="text-align: center">
                <center><div class="g-recaptcha" data-sitekey="6LeJbcsUAAAAAAWzMxxXTakpEQQxLJTXFB9I2Dzs" style="clear: both"></div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2 d-flex justify-content-center">
            <button class="btn btn-success">Salvar</button>
            <a class="btn btn-danger ml-3" href="account.php">Voltar</a>
        </div>

        <?php
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