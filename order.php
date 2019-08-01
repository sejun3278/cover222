<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall - Order </title>
    <link rel = "stylesheet" href = "style.css?after" type = "text/css">
    <meta charset="utf-8">

  </head>

  <body>
    <div id='index_tool'>    <!-- 1 -->
    <?php
        session_start();
        if(!preg_match("/".$_SERVER['HTTP_HOST']."/i",$_SERVER['HTTP_REFERER'])) {
            echo "<script> alert(\"허용되지 않는 접근입니다.\"); </script>"; 
            echo "<script> window.history.back(); </script>";
            exit;
        }

        require_once("./page/check_login.php");
        require_once("./page/title.php");
    ?>

      <div id='order_list_tools_div'>    <!-- 2 -->
        <div> </div>
        <div class='center_rayout'> <!-- 3 -->
          <div id='order_title_div'>
            <a class='color_black'> 
              <img class='title_img' src='./source/cart_background.png'/>
              <b class='titles'> 주문 </b>
            </a>
          </div>

          <div id='order_tool'> <!-- 4 -->
            <?php
                $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
                session_start();
                $user_id = $_SESSION['login'];

                if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                
                  } else {
                  $result = mysqli_query($mysql, "SELECT * FROM `user` where id = $user_id");

                  echo "<div class='order_user_info_div'>";
                  echo "<h4> 고객 정보 </h4>";
                  echo "</div>";
                }
            ?>
          </div> <!-- 4 -->
        </div> <!-- 3 -->
      </div>
    </div>

  <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>
