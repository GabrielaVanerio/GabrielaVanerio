<?php


    @session_start();
    unset($_SESSION['documento']);
    @session_destroy();
	echo("se cerro la sesion");
    header('Location: index2.php');


?>