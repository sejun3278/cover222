<?php
$data = $_POST['data'];
$posi = $_POST['position'];

require_once("./config/config.php");
    $result = mysqli_query($mysql, "SELECT * FROM user WHERE $posi = '" . $data . "'");

        if($result === false) {
          echo mysqli_error('error : ' + $mysql);
          exit;
        }
        
        while($row = mysqli_fetch_array($result)) {
          $id = $row['id'];
          echo $id;
        }

      mysqli_close($mysql);
?>