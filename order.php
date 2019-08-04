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
          <div class='title_div'>
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

                $seller_arr = array();
                $topic_arr = array();

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

            $result = mysqli_query($mysql, "SELECT cart.*, topic.* FROM cart INNER JOIN topic ON cart.topic_id = topic.id AND cart.user_id = $user_id ORDER BY seller_id DESC");

              echo "<br />";
              echo "<div class='order_list_div'>";
              echo "<h4> 구매 정보 </h4>";
              echo "<div id='order_list_border'>";

              $array = array();
              $limit = 1;
              $all_limit = mysqli_num_rows($result);

                while($row = mysqli_fetch_array($result)) { // 4
                  $seller = $row['seller_id'];
                  $topic_id = $row['topic_id'];
                  array_push($topic_arr, $topic_id);
                  array_push($seller_arr, $seller);

                  if($array[$seller] === null) {
                    $array[$seller] = array($topic_id);

                  } else {
                    array_push($array[$seller], $topic_id);
                  }
                }
                
                $final_add_price = 0;
                $total_delivery = 0;
                $final_price = 0;
                foreach($array as $key => $value) { // 2
                  echo "<div class='order_lists'>";

                  $limit = $limit + 1;
                  $company_result = mysqli_query($mysql, "SELECT * FROM user where user_id = $key");
                  $company_row = mysqli_fetch_array($company_result);
                  $company = $company_row['company'];

                  echo "<div class='order_company_list'>";
                  echo "<u class='order_company_title'> $company </u>"; 
                  echo "</div>";

                  echo "<div class='order_item_list'>";

                  $list_total_price = 0;
                  foreach($array[$key] as $two) {
                    $index = $index + 1;
                    $topic_result = mysqli_query($mysql, "SELECT * FROM topic where id = $two");
                    $topic_row = mysqli_fetch_array($topic_result);
                    
                    $title = $topic_row['title'];
                    $img = $topic_row['file'];
                    $price = $topic_row['price'];

                    $cover = mysqli_query($mysql, "SELECT cart.*, topic.* FROM cart INNER JOIN topic ON cart.topic_id = topic.id AND topic.id = $two AND cart.user_id = $user_id ORDER BY seller_id DESC");
                    $cover_row = mysqli_fetch_array($cover);
                    $num = $cover_row['num'];
                    $price = $cover_row['price'];

                    $total = $num * $price;
                    $c_total = number_format($total);

                    $list_total_price = $list_total_price + $total;
                    $cover_list_price = $list_total_price;

                    // echo $list_total_price;
                    $delivery = 2500;
                    
                    if($list_total_price > 30000) {
                      $delivery = 0;
                    }
                    
                    $c_delivery = number_format($delivery);
                    $total_delivery = $total_delivery + $delivery;

                    $cover_list_total_price = $list_total_price;
                    $list_total_price = $list_total_price + $delivery;

                    $c_cover_list_price = number_format($cover_list_price);
                    $c_list_total_price = number_format($list_total_price);

                    $c_price = number_format($price);

                    echo "<div> <img class='order_list_img' src='./source/topic_files/$img' /> </div>";
                    echo "<div>";
                      echo "<u class='order_list_number'> 주문 번호 : $two </u>";
                      echo "<h4 class='order_list_title'> $title </h4>";
                      echo "<div class='order_list_num_price'>";
                        echo "수량 : $num <br />";
                        echo "개당 / $c_price 원 <br />";
                      echo "</div>";
                      echo "<div class='order_list_total'> <b> 결제 금액 : $c_total </b> 원 </div>";
                    echo "</div>";
                  }

                  echo "</div>";
                  echo "</div>";
                  
                  echo "<div class='order_list_total_div'>";
                  if($delivery > 0) {
                    echo "<u class='notice_devlivery'> 3만원 이상 결제 시, 배송비 무료 </u>";
                  }
                  echo "<b> 결제 금액 : $c_list_total_price 원 </b> ( 최종 금액 : $c_cover_list_price 원 + 배송비 : $c_delivery 원 )";
                  echo "</div>";
                  
                  $final_add_price = $final_add_price + $cover_list_price;
                  $c_final_add_price = number_format($final_add_price);

                  $c_total_delivery = number_format($total_delivery);

                  $final_price = $final_price + $list_total_price;
                  $c_final_price = number_format($final_price);

                  if($limit + 1 === $all_limit) {
                    echo "<hr />";
                  }
                }
                echo "</div>";
              echo "</div>";

              echo "<br />";
              echo "<div class='order_list_div'>";
              echo "<h4> 결제 정보 </h4>";
              echo "<div id='order_payment_div'>";
                echo "<div id='order_payment_type'>";
                  echo "<select id='order_payment_select' name='payment'>";
                  echo "<option> 카드 결제 </option>";
                  echo "<option> 계좌이체 </option>";
                  echo "<option> 무통장 입금 </option>";
                  echo "<option> 기타 결제 </option>";
                  echo "</select>";

                  // echo "<div> <label for='credit'> 카드 결제 </label> <input type='checkbox' class='payment' id='credit' name='payment'/> </div>";
                  // echo "<div> <label for='account'> 계좌이체 </label> <input type='checkbox' class='payment' id='account' name='payment'/> </div>";
                  // echo "<div> <label for='untouched'> 무통장 입금 </label> <input type='checkbox' class='payment' id='untouched' name='payment'/> </div>";
                  // echo "<div> <label for='other'> 기타 결제 </label> <input type='checkbox' class='payment' id='other' name='payment'/> </div>";
                echo "</div>";

              echo "</div>";
              echo "</div>";

              echo "<br /> <br />";
              echo "<div class='order_final_price'>";
              echo "<h4 class='final_total_price'> 결제 금액 : $c_final_add_price 원 </h4>";
              echo "<h4 class='final_total_price'> 배송비 : $c_total_delivery 원 </h4>";
              echo "<hr id='total_line' />";
              echo "<h4 class='final_total_price'> 최종 결제 금액 : $c_final_price 원 </h4>";
              echo "</div>";

              echo "<br /> <br />";

              // $test = array();
              // $test[] = '222';
              $topic_arr = json_encode(array_map('utf8_encode', $topic_arr));
              $seller_arr = json_encode(array_map('utf8_encode', $seller_arr));


              echo "<a class='order_complate' href='javascript:order_complate($final_price, $topic_arr, $seller_arr)'> 결제하기 </a>";
              echo "<br /> <br /> <br /> <br />";
            ?>
          </div> <!-- 4 -->
        </div> <!-- 3 -->
      </div>
    </div>

  <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>
