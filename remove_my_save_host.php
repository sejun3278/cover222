<?php
    session_start();

    require_once("./config/config.php");
    require_once("./page/check_login.php");
    require_once("./page/title.php");
    require_once("./page/category.php");
    
    $id = $_SESSION['login'];
    $host_id = $_POST['host_id'];

    $result = mysqli_query($mysql, "DELETE FROM `save_user_info` where user_id = $id AND id = $host_id");
    echo "true";
?>