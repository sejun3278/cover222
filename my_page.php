<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall - My Page </title>
    <link rel = "stylesheet" href = "style.css?after" type = "text/css">
    <meta charset="utf-8">

  </head>

  <body>
    <div id='index_tool'>    <!-- 1 -->
        <?php
            session_start();

            require_once("./page/check_login.php");
            require_once("./page/title.php");
            require_once("./page/category.php");
        ?>
        <div id='my_page_div'>
            <div> </div>
            <div class='center_rayout'>     <!-- 2 --> 
              <div class='title_div' id='my_page_title_div'>
                <a class='color_black' href='my_page.php'>
                  <b class='titles'> 마이 페이지 </b>
                </a>
              </div>
            <hr />
            <div class='my_status_mini_div'>
                <?php
                    session_start();
                    $user_id = $_SESSION['login'];

                    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
                    $result = mysqli_query($mysql, "SELECT * FROM `user` where user_id = $user_id");
                    $row = mysqli_fetch_array($result);

                    $type = $row['type'];
                    $img = $row['img'];
                    $nickname = $row['nickname'];
                    $date = $row['date'];
                    echo "<div> </div>";
                    echo "<div class='my_status_mini_img_div'>";

                    if($img !== 'null') {
                        echo "<img id='status_img_width' src='./source/user_profile/$img' />";

                    } else {
                        echo "<img id='status_img_width' src='./source/user_profile.png' />";
                    }
                    echo "</div>";
                    echo "<div> </div>";

                    echo "<div>";
                        echo "<div class='mini_div_styling'> <b> 아이디 </b> / 닉네임 </div>";
                        echo "<u id='mini_id_and_nick'> <b> $user_id </b> / $nickname </u>";
                    echo "</div>";

                    echo "<div>";
                        echo "<div class='mini_div_styling'> <b> 회원 타입 </b> </div>";
                        if($type === 'buyer') {
                            echo "<u> 구매자 </u>";

                        } else {
                            echo "<u> 구매 + 판매자 </u>";
                        }
                    echo "</div>";

                    echo "<div>";
                        echo "<div class='mini_div_styling'> 가입일 </div>";
                        echo substr($date, 0, 10);
                    echo "</div>";
                ?>
            </div>

            <br /> <br />
            <div>
                <div class='my_list_grid_div'>
                    <div> </div>
                    <div class='my_lists_border'> 회원 정보 수정 <hr /> <img class='my_lists_img' src='./source/set_user.png'/> </div>
                    <div class='my_lists_border'> <a href='like_list.php'> 찜 리스트 <hr /> <img class='my_lists_img' src='./source/like_list_title.png'/> </a> </div>
                    <div class='my_lists_border'> <a href='cart.php'> 장바구니 <hr /> <img class='my_lists_img' src='./source/cart_background.png'/> </a> </div>
                </div>
                <div class='my_list_grid_div my_list_margin'>
                    <div> </div>
                    <div class='my_lists_border'> <a href='my_order_list.php'> 주문 내역 <hr /> <img class='my_lists_img' src='./source/buy_list.png'/> </a> </div>
                    <div class='my_lists_border'> 질문 & 답변 <hr /> <img class='my_lists_img' src='./source/my_question.png'/> </div>
                    <div class='my_lists_border'> 내가 쓴 게시물 <hr /> <img class='my_lists_img' src='./source/my_write_list.png'/> </div>
                </div>
            </div>

            </div>      <!-- 2 -->


        </div>
    </div>
  <script src = "script.js" type="text/javascript"> </script>
</body>

</html>