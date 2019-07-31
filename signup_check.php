<?php
header('Content-Type: text/html; charset=utf-8');
$data = $_POST['data'];
$posi = $_POST['position'];

    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');

      if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();

      } else {

        $result = mysqli_query($mysql, "SELECT * FROM user WHERE $posi = $data");
        
        if($result === false){
          echo mysqli_error('error : ' + $mysql);
        }
        
        $num = 0;
        while($row = mysqli_fetch_array($result)) {
          $num = $num + 1;
        }
      }
      echo $num;
      mysqli_close($mysql);
?>