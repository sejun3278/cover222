<?php
    header('Content-Type: text/html; charset=utf-8');
    $data = array();
    $data['success'] = false;

    if(isset($_GET['files'])) {
        $error = false;
        $files = array();
    }
    // echo $file;

    $dir = 'source/topic_files/';
    if(!is_dir($dir)) {
        mkdir($dir);
    }

    $type = $_GET['files'];
    print($type);
    echo $type;

    foreach($_FILES as $file) {
        if(move_uploaded_file($file['tmp_name'], $dir.$file['name'])) {
            $files[] = $dir .$file['name'];

        } else {
            $error = true;
        }
        $data = ($error) ? array('error' => '업로드된 파일이 없습니다.') : array('files' => $files);
    }
    echo 'true';
?>
