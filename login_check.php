<?php
header('Content-Type: text/html; charset=utf-8');
$id = $_POST['id'];
$password = $_POST['password'];

    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
    mysqli_set_charset($mysql, "utf8");

      if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();

      } else {
        $result = mysqli_query($mysql, "SELECT * FROM user WHERE `user_id` = $id");

        if($result === false) {
          echo mysqli_error('error : ' + $mysql);
        }

        $num = 0;
        while($row = mysqli_fetch_array($result)) {
          $hash = hash("sha256", $password);
          $default = $row['password'];

          $num = $num + 1;
          
          if($hash === $default) {
            session_start();
            $_SESSION['login'] = $id;
  
            echo 'true';
            exit;
          }
        }

        if($num === 0) {
          echo 'not_define_user';
          exit;
        }
      
        echo 'false';
      }
      
      mysqli_close($mysql);
?>