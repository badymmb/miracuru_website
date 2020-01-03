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
<section class="session-block mt-3 pt-3 pb-3 text-white">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <h2 class="font-weight-bold">Alterar Senha</h2>
        </div>
    </div>
    <form action="src/actions/alterar_senha.php" method="POST" class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-4">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtSenhaAntiga">Senha Antiga:</label>
                <input type="password" class="form-control" name="txtSenhaAntiga" id="txtSenhaAntiga" placeholder="Entre com a senha antiga..." />
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtNovaSenha">Nova senha:</label>
                <input type="password" class="form-control" name="txtNovaSenha" id="txtNovaSenha" placeholder="Entre com a nova senha..." />
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2">
            <div class="form-group">
                <label class="p-0 m-0 text-white font-weight-bold" for="txtConfNovaSenha">Confirmar nova senha:</label>
                <input type="password" class="form-control" name="txtConfNovaSenha" id="txtConfNovaSenha" placeholder="Confirme a nova senha..." />
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2 d-flex justify-content-center">
            <button class="btn btn-success">Salvar</button>
            <a class="btn btn-danger ml-2" href="account.php">Voltar</a>
        </div>
        

        <?php

            if (!empty($msgError)){
                ?>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 mt-2 d-flex justify-content-center">
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