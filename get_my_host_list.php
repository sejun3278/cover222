<?php
    session_start();

    require_once("./config/config.php");
    // require_once("./page/check_login.php");
    // require_once("./page/title.php");
    // require_once("./page/category.php");
    
    $id = $_SESSION['login'];
    $host_id = $_GET['host_id'];

    $arr = array();
    $result = mysqli_query($mysql, "SELECT * FROM save_user_info WHERE `user_id` = $id AND id = $host_id");
    while($rows = mysqli_fetch_array($result)) {
        $first_phone = $rows['first_phone'];
        $middle_phone = $rows['middle_phone'];
        $last_phone = $rows['last_phone'];

        $first_host = $rows['first_host'];
        $last_host = $rows['last_host'];

        // echo $rows[1];
        for($i = 2; $i < 7; $i++) {
            echo $rows[$i] . '　';
        }
    }

?>