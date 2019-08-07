<?php

require_once("./config/config.php");
$id = $_POST['id'];
$id = '"' . $id . '"';

$result = mysqli_query($mysql, "SELECT * FROM user WHERE `user_id` = $id");

  if($result === false) {
    echo mysqli_error('error : ' + $mysql);
  }

  $num = mysqli_num_rows($result);
  if($num === 0) { // 아이디가 없는 경우
    echo $num;

  } else {
    $password = $_POST['password'];
    
    while($row = mysqli_fetch_array($result)) {
      $id = $row['id'];
      
      $hash = hash("sha256", $password);
      $default = $row['password'];

      if($hash === $default) {
        session_start();
        $_SESSION['login'] = $id;

        echo 'true';
        exit;

      } else {
        echo '0';
        exit;
      }
    }
  }
      mysqli_close($mysql);
?>