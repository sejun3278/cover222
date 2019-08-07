<?php
header('Content-Type: text/html; charset=utf-8');

    const db_host = 'sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com';
    const db_user = 'sejun';
    const db_password = 'q1w2e3r4t5';
    const db_use_db = 'mall';

    $mysql = mysqli_connect(db_host, db_user, db_password, db_use_db);
    mysqli_set_charset($mysql, "utf8");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }
?>