<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall - Cart </title>
    <link rel = "stylesheet" href = "style.css?after" type = "text/css">
    <meta charset="utf-8">

  </head>

  <body>
    <div id='index_tool'>    <!-- 1 -->
    <?php
        session_start();

        require_once("./config/config.php");
        require_once("./page/check_login.php");
        require_once("./page/title.php");
        require_once("./page/category.php");
        require_once("./page/cart_top.php");        
    ?>

    <div id='cart_list_tools_div'>    <!-- 2 -->
      <div> </div>
      <div class='center_rayout'> 
        <div class='title_div'>
          <a class='color_black' href='cart.php'> 
            <img class='title_img' src='./source/cart_background.png'/>
            <b class='titles'> 장바구니 </b>
          </a>
        </div>

        <div id='cart_tool'>
        <?php
            session_start();
            $user_id = $_SESSION['login'];

            $result = mysqli_query($mysql, "SELECT cart.*, topic.* FROM cart INNER JOIN topic ON cart.topic_id = topic.id AND cart.user_id = $user_id ORDER BY seller_id DESC");
            // $result = mysqli_query($mysql, "SELECT * FROM `cart` where user_id = $user_id");
                $result_length = mysqli_num_rows($result);

                echo "<hr />";

                if($result_length === 0) {
                    echo "<div class='empty_div'>";
                    echo "<img class='empty_img' src='./source/empty_cart.png'/>";
                    echo "<div id='null_cart_list'> <h3> 장바구니가 비어있습니다. </h3> </div>";
                    echo "</div>";
                    echo "<hr />";
                    exit;
                }

                echo "<div class='other_div'>";
                    echo "<div> </div>";
                    echo "<div class='choice_result_num $result_length'> <input type='checkbox' class='all_choice on' checked='checked' id='all_total_choice' />";
                    echo "<label class='point' for='all_total_choice'> 전체 선택 ( <u class='choice_select_lists'> $result_length </u> / <u class='all_total_num $result_length'> $result_length </u> ) </label> </div>";
                    echo "<div> <a class='list_all_remove color_black point cart'> 선택 삭제 </a> </div>";
                echo "</div>";

                echo "<div class='cart_lists_div'>";
                $num = 0;
                $total_cart_price = 0;

                while($rows = mysqli_fetch_array($result)) {
                    $topic_id = $rows['topic_id'];

                    $select = mysqli_query($mysql, "SELECT * FROM `topic` where id = $topic_id ");
                    $select_length = mysqli_num_rows($result);

                    while($row = mysqli_fetch_array($select)) {
                        $title = $row['title'];
                        $img = $row['file'];
                        $price = $row['price'];
                        $price_c = number_format($price);
                        $seller = $row['seller_id'];

                        $select = mysqli_query($mysql, "SELECT * FROM `user` where user_id = $seller ");
                        $user_row = mysqli_fetch_array($select);
                        $company = $user_row['company'];

                        $item_num = $rows['num'];
                        $num = $num + 1;
                        
                        echo "<div class='cart_checkbox $topic_id'>";
                            echo "<input id='cart_$topic_id' class='check_list $topic_id on' checked='checked' name='lists_check_$topic_id' type='checkbox' />";
                            echo "<label for='cart_$topic_id' class='point'> 선택 </label>";
                            echo "<div> <a class='cart_item_nums'> 상품 번호 : $topic_id </a> </div>";
                            echo "<div> <a class='each_remove_button $topic_id cart_each_remove cart'> 개별 삭제 </a> </div>";
                        echo "</div>";

                        echo "<div class='cart_lists'>";
                        echo "<div> <a href='topic.php?id=$topic_id'> <img class='cart_img_width' src='./source/topic_files/$img'/> </a> </div>";

                        echo "<div>";
                        echo "<div class='cart_company'> $company </div>";
                        echo "<div> <h4> $title </h4> </div>";
                        echo "<div class='cart_price_notice'> (1개 가) $price_c 원 </div>";

                          echo "<div class='cart_q_div'>";
                          echo "<div class='cart_button_left cart_button point $topic_id'> <img class='cart_oder_margin' src='./source/item_add.png' /> </div>";
                          echo "<div> <input class='cart_item_input $topic_id' id='cart_item_input_$topic_id' type='text' value='$item_num' maxLength='4' /> </div>";
                          echo "<div class='cart_button_right cart_button point $topic_id'>  <img class='cart_oder_margin' src='./source/item_remove.png' /> </div>";
                          echo "</div>";
                        
                        echo "</div>";

                        // echo "<hr />";
                        echo "</div>";
                        $total_price = $price * $item_num;
                        $total_cart_price = $total_cart_price + $total_price;

                        $c_total_price = number_format($total_price);
                        $c_total_cart_price = number_format($total_cart_price);

                        echo "<div class='cart_total_price'> <h3 class='cart_h3 cart_total_price_$topic_id'> $c_total_price 원 </h3> </div>";
                        
                        if($select_length !== $num) {
                        echo "<hr />";
                        }
                        echo "<a class='cart_value_$topic_id $topic_id $price p_$item_num'> </a>";
                    }
                }

                echo "</div>";

                echo "<h3 id='cart_total_price'> 총 금액 : <u class='cart_total_html'>$c_total_cart_pric</u> 원 </h3>";
                echo "<div id='cart_order_div'>";
                  echo "<div> </div>";
                  echo "<div class='order_selector select_order point'> 선택 주문 </div>";
                  echo "<div class='order_selector all_order point'> 전체 주문 </div>";
                echo "</div>";
                echo "<br /> <br />";
        ?>
        </div>

      </div>
      <div id='cart_total_price_top'>  
        <h4> 총 금액 </h4>
        <u class='cart_total_html'> </u> 원
        <br /> <br> <br />
        <div> <b> <a class='cart_order'> 주문하기 </a> </b> </div>
      </div>
    </div>
    </div>

  <script src = "script.js" type="text/javascript"> </script>
  </body>

</html>