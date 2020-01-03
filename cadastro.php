<?php include_once("./template/includes/header.php"); ?>

<?php

    $login = "";

    if (!empty($_GET["txtUser"]))
        $login = $_GET["txtUser"];

?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
  var onloadCallback = function() {
  };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
<form action="src/actions/efetuar_cadastro.php" method="POST" class="session-block mt-3 pt-3 pb-3">

    <div class="row">

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <h3>Cadastro de Usuário</h3>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtUser">Login:</label>
                <input type="text" class="form-control" name="txtUser" id="txtUser" placeholder="Entre com o login desejado..." value="<?php echo $login; ?>" />
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtPassword">Senha:</label>
                <input type="password" class="form-control" name="txtPassword" id="txtPassword" placeholder="Entre com a senha desejada..." />
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtConfPassword">Confirmar senha:</label>
                <input type="password" class="form-control" name="txtConfPassword" id="txtConfPassword" placeholder="Confirme sua senha..." />
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group" style="text-align: center">
                <center><div class="g-recaptcha" data-sitekey="6LeJbcsUAAAAAAWzMxxXTakpEQQxLJTXFB9I2Dzs" style="clear: both"></div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2 d-flex justify-content-center">
            <button class="btn btn-success">Cadastrar</button>
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
            ?>
        </div>

        
    </div>

</form>

<?php include_once("./template/includes/footer.php"); ?>