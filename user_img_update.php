<?php
    header('Content-Type: text/html; charset=utf-8');
    // $data = array();
    // $data['success'] = false;

    // if(isset($_GET['files'])) {
    //     $error = false;
    //     $files = array();
    // }
    // echo $file;

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
        }
    }

    // foreach($_FILES as $file) {
    //     if(move_uploaded_file($file['tmp_name'], $dir.$file[$user_id])) {
    //         $files[] = $dir .$file['name'];

    //     } else {
    //         $error = true;
    //     }
    //     $data = ($error) ? array('error' => '업로드된 파일이 없습니다.') : array('files' => $files);
    // }
    // echo 'true';
?>
