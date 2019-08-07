<?php

  $id = $_POST['id'];
  $nickname = $_POST['nickname'];
  $password = $_POST['password'];
  $host_first = $_POST['host_first'];
  $host_second = $_POST['host_second'];
  $phone = $_POST['phone'];
  $file = $_POST['file'];
  $type = $_POST['type'];
  $company = $_POST['company'];

  $hash = hash("sha256", $password);

  date_default_timezone_set("Asia/Seoul");
  $date = date("Y-m-d H:i:s");

  require_once("./config/config.php");
  $result = mysqli_query($mysql, "INSERT INTO user(user_id, nickname, password, date, type, img, first_host, second_host, phone_number, company) VALUES('$id', '$nickname', '$hash', '$date', '$type', '$file', '$host_first', '$host_second', '$phone', '$company')");
    
  if($result === false) {
    echo mysqli_error('error : ' + $mysql);
  }
    
  echo 'true';
mysqli_close($mysql);
?>