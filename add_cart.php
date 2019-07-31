<?php
    $type = $_POST['type'];

    $topic_id = $_POST['topic_id'];
    $topic_num = $_POST['num'];

    session_start();
    $user_id = $_SESSION['login'];

    date_default_timezone_set("Asia/Seoul");
    $date = date("Y-m-d H:i:s");

    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    
      } else {

      $search = mysqli_query($mysql, "SELECT * FROM cart WHERE user_id = $user_id and topic_id = $topic_id");
      $row = mysqli_fetch_array($search);
      $id = $row['id'];

      if($type === 'add') {
        $search_length = mysqli_num_rows($search);

        if($search_length > 0) {
          echo "false";
          exit;
        }

        $result = mysqli_query($mysql, "INSERT INTO cart(user_id, topic_id, num, date) VALUES('$user_id', '$topic_id', '$topic_num', '$date')");
        echo "true";
        exit;

      } else if($type === 'change') {
        $update = mysqli_query($mysql, "UPDATE cart SET num = $topic_num WHERE id = $id");
        echo "change";
      }
    }
?>