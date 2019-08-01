<?php
    if(!preg_match("/".$_SERVER['HTTP_HOST']."/i",$_SERVER['HTTP_REFERER'])) {
        echo "<script> alert(\"허용되지 않는 접근입니다.\"); </script>"; 
        echo "<script> window.history.back(); </script>";
        exit;
    }
?>