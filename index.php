<?php include_once("template/includes/header.php"); ?>

<div class="row pb-2">
    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 panel-left order-2 order-sm-2 order-md-1 order-lg-1 order-xl-1">

        <?php include_once("./template/includes/section_login_account.php"); ?>

        <?php include_once("./template/includes/section_server_status.php"); ?>

        <?php include_once("./template/includes/section_downloads.php"); ?>

    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 panel-right order-1 order-sm-1 order-md-2 order-lg-2 order-xl-2">
        <?php include_once("./template/includes/section_noticias.php") ?>
    </div>
</div>

<?php include_once("template/includes/footer.php"); ?>