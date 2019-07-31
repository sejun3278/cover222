<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        echo 'false';
        
    } else {
        echo 'true';
    }

?>