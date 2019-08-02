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
                  $result = mysqli_query($mysql, "SELECT * FROM `user` where user_id = $user_id");
                  $row = mysqli_fetch_array($result);

                  $nickname = $row['nickname'];
                  $id = $row['id'];
                  $phone = $row['phone_number'];

                  $phone_first = substr($phone, 0, 3);
                  $phone_middle = substr($phone, 4, 4);
                  $phone_last = substr($phone, 9, 10);

                  $host_first = $row['first_host'];
                  $host_second = $row['second_host'];

                  echo "<div class='order_user_info_div'>"; // 5
                  echo "<h4> 고객 정보 </h4>";
                    echo "<div id='user_info_border'>";
                    echo "<u> 고객 번호 : $id </u>";
                    echo "<b id='user_info_nickname'> 닉네임 : $nickname </b> <br />";
                      echo "전화 번호 : ";
                      echo "<select class=$phone_first id='user_info_phone_first'> <option> 010 </option> <option> 011 </option> <option> 013 </option> </select> - ";
                      echo "<input type='text' maxLength='4' class='phone_input' value='$phone_middle'/> - ";
                      echo "<input type='text' maxLength='4' class='phone_input' value='$phone_last'/>";
                    
                    echo "<br />";
                      echo "<div id='user_info_host_div'>";
                      echo "<b id='user_info_host_title'> * 주소 </b> <br />";
                      echo "도/시/군 <input class='host_input' id='aa' type='text' maxLength='20' value='$host_first' /> <br />";
                      echo "상세 주소 <input class='host_input' type='text' maxLength='30' value='$host_second' />";
                      echo "</div>";
                    
                    // echo "<br />";
                    echo "배송 시 유의 사항 <br />";
                    echo "<input id='order_alert_notice_input' type='text' maxLength='30' />";
                    echo "</div>";
                  echo "</div>"; // 5
                }
            ?>

            <?php
            $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
            session_start();
            $user_id = $_SESSION['login'];

            $result = mysqli_query($mysql, "SELECT cart.*, topic.* FROM cart INNER JOIN topic ON cart.topic_id = topic.id AND cart.user_id = $user_id");

              echo "<br />";
              echo "<div class='order_list_div'>";
              echo "<h4> 구매 정보 </h4>";
                echo "<div id='order_list_border'>";
                while($row = mysqli_fetch_array($result)) {
                  $seller = $row['seller_id'];

                  // 같은 판매자에 해당되는 목록들을 묶어준다.
                  $seller_result = mysqli_query($mysql, "SELECT * FROM topic WHERE seller_id = $seller");
                  while($row = mysqli_fetch_array($seller_result)) {
                    $title = $row['title'];
                  }

                  echo "<div>";
                  echo "</div>";
                }
                echo "</div>";
              echo "</div>"
            ?>
          </div> <!-- 4 -->
        </div> <!-- 3 -->
      </div>
    </div>

  <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>
