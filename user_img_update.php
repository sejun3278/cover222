<?php
    header('Content-Type: text/html; charset=utf-8');
    $dir = 'source/user_profile_example/';
    if(!is_dir($dir)) {
        mkdir($dir);
    }

    $file = $_GET['files'];
    $user_id = $_POST['user_id'];
    $boo = $_POST['boo'];

    $file_name = $user_id . '.png';

    if(file_exists($dir . $file_name)) {
      unlink($dir . $file_name);
    }

    if($boo === 'remove') {
        echo "false";
        exit;
    }
    
    foreach($_FILES as $file) {
        if($boo === 'example') {
            move_uploaded_file($file['tmp_name'], $dir.$file_name);
            echo "true";
            exit;

        } else if($boo === 'add') {
            $dir = 'source/user_profile/';

            if(!is_dir($dir)) {
                mkdir($dir);
            }

            move_uploaded_file($file['tmp_name'], $dir.$file_name);
            echo "true";
            exit;
        }
    }
?>
