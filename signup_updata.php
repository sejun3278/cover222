<?php
  header('Content-Type: text/html; charset=utf-8');

  $id = $_POST['id'];
  $nickname = $_POST['nickname'];
  $password = $_POST['password'];
  $type = $_POST['type'];

  $hash = password_hash($password, PASSWORD_DEFAULT);

  date_default_timezone_set("Asia/Seoul");
  $date = date("Y-m-d H:i:s");

  $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');

  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();

  } else {
    $result = mysqli_query($mysql, "INSERT INTO user(user_id, nickname, password, date, type) VALUES('$id', '$nickname', '$hash', '$date', '$type')");
    
    if($result === false){
        echo mysqli_error('error : ' + $mysql);
    }
    
    echo 'true';
};
mysqli_close($mysql);
?>