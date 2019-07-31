<?php
  session_start();
  if(isset($_SESSION['login'])) {
    unset( $_SESSION['login'] );
    echo "<script> alert(\"성공적으로 로그아웃 되었습니다.\"); </script>"; 
    echo "<script> window.history.back(); </script>";
  } 
?>