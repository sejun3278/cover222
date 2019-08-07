<?php
  session_start();
  require_once("./page/url_exit.php");

  if(isset($_SESSION['login'])) {
    unset( $_SESSION['login'] );
    echo "<script> alert(\"성공적으로 로그아웃 되었습니다.\"); </script>"; 
    echo "<script> window.location.replace('index.php'); </script>";
  } 
?>