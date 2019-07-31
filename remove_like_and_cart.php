<?php
    $topic_id = $_POST['topic_id'];
    $type = $_POST['type'];

    session_start();
    $user_id = $_SESSION['login'];

    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    
      } else {

        if($type === 'like_list') {
          $result = mysqli_query($mysql, "DELETE FROM `like` where user_id = $user_id and topic_id = $topic_id");
          echo "like_list";
        
        } else {
          $result = mysqli_query($mysql, "DELETE FROM `cart` where user_id = $user_id and topic_id = $topic_id");          
          echo "cart";
        }
    }
?>