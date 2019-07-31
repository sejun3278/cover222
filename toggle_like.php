<?php
    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    
      } else {
        $array = array();

        $user_id = $_POST['user_id'];
        $topic_id = $_POST['topic_id'];

        $result = mysqli_query($mysql, "SELECT * FROM `like` where user_id = $user_id and topic_id = $topic_id");
        $result_length = mysqli_num_rows($result);
    
        if($result_length === 0) { // unlike -> like
            $insert = mysqli_query($mysql, "INSERT INTO `like`(user_id, topic_id) VALUES('$user_id', '$topic_id')");
            echo "true";
            exit;

        } else { // like -> unlike
            $delete = mysqli_query($mysql, "DELETE FROM `like` WHERE user_id = $user_id and topic_id = $topic_id");
            echo "false";
        }

        if($result === false){
            echo mysqli_error('error : ' + $mysql);
        }
    }
?>