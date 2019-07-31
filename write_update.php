<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    $user_id = $_SESSION['login'];
    $title = $_POST['title'];
    $contents = $_POST['contents'];
    $category = $_POST['category'];
    $child = $_POST['child'];
    $price = $_POST['price'];

    date_default_timezone_set("Asia/Seoul");
    $date = date("Y-m-d H:i:s");
    $fileName = $_POST['fileName'];

    $dir = 'source/topic_files/';
    if(!is_dir($dir)) { mkdir($dir); }

    foreach($_FILES as $file) {
      if($file !== 'null') {
        $cover_date = substr($date, 0, 10);
        $cover_time = substr($date, 11, -6) . substr($date, 14, -3) . substr($date, 17, 2);
        $cover_date = $cover_date . $cover_time;

        $fileName = '[' . $user_id . ']' . $cover_date . '-' . $file['name'];
      }

      if(move_uploaded_file($file['tmp_name'], $dir.$fileName)) { }
    }

    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');

  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();

  } else {
    $result = mysqli_query($mysql, "INSERT INTO topic(user_id, title, contents, category, child, date, file, price) VALUES('$user_id', '$title', '$contents', '$category', '$child', '$date', '$fileName', '$price')");

    if($result === false){
        echo mysqli_error('error : ' + $mysql);
    }
    
    echo 'true';
    };

?>