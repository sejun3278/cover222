<?php
if(!isset($_SESSION['login'])) {
    echo "<script> alert(\"로그인이 필요합니다.\"); </script>"; 
    echo "<script> window.location.replace('login.php'); </script>";
    exit;
}
?>
