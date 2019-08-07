<?php
    session_start();

    require_once("./config/config.php");
    // require_once("./page/check_login.php");
    // require_once("./page/title.php");
    // require_once("./page/category.php");
    
    $id = $_SESSION['login'];
    $host_id = $_GET['host_id'];
    echo $host_id;
?>