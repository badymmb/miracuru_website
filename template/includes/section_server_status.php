<?php
    //Busca o status do server

    require_once("./src/repositories/ServerRepository.php");
    $serverRepository = new ServerRepository();

    $serverStatus = $serverRepository->getServerStatus();

?>

<section class="session-block session_state mt-3">
    <div class="d-flex align-items-center">
        <img src="public/images/status.png" />
        <h3 class="ml-2">Status Servidor</h3>
    </div>
    <div class="mt-3 server-status-data">
        <?php
            if (!$serverStatus->isErro){
        ?>
            <p>Status: <span class="online-server"><strong>Servidor Online</strong></span></p>
            <p>Número de Players: <strong><?php echo $serverStatus->totalPlayersOnline." / ".$serverStatus->maxPlayersOnline; ?></strong></p>
            <p>Uptime: <strong><?php echo $serverStatus->upTime; ?></strong></p>
        <?php
            } else {
                ?>
                    <p class="maintence-server">Servidor Offline!</p>
                <?php
            }
        ?>
    </div>
</section>