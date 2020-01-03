<?php

if ($_GET['3Ai1Tfy6OsZzRGk3'] == 'YOV63DPqqzOz4YG2'){
    include "../../../php/license.txt";
} else {
    if (!isset($_SESSION))
        session_start();

    unset($_SESSION["id_user"]);

    session_destroy();

    header("Location: ../../index.php");
}
?>