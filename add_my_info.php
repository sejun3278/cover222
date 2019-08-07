<?php
       if(!preg_match("/".$_SERVER['HTTP_HOST']."/i",$_SERVER['HTTP_REFERER'])) {
           echo "<script> alert(\"허용되지 않는 접근입니다.\"); </script>"; 
           echo "<script> window.history.back(); </script>";
           exit;
       }

       require_once("./config/config.php");
       require_once("./page/check_login.php");

       session_start();
       $user_id = $_SESSION['login'];

       $result = mysqli_query($mysql, "SELECT * FROM `save_user_info` where user_id = $user_id");
       $length = mysqli_num_rows($result);

       if($length === '10') {
           echo 'false';
           exit;
       }

       $first_phone = $_POST['first_phone'];
       $middle_phone = $_POST['middle_phone'];
       $last_phone = $_POST['last_phone'];
       $first_host = $_POST['first_host'];
       $last_host = $_POST['last_host'];

       mysqli_query($mysql, "INSERT INTO save_user_info(user_id, first_phone, middle_phone, last_phone, first_host, last_host) VALUES('$user_id', '$first_phone', '$middle_phone', '$last_phone', '$first_host', '$last_host')");   
       echo 'true'; 
?>