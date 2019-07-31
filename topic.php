<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <?php
      $id = $_GET['id'];

      $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
      $result = mysqli_query($mysql, "SELECT * FROM topic WHERE id = $id");

      $row = mysqli_fetch_array($result);
      $title = $row['title'];
      echo "<title> $title </title>";
    ?>
    
    <link rel = "stylesheet" href = "style.css?after" type = "text/css">
    <meta charset="utf-8">
  </head>
  
  <body>
    <?php
    echo "<div id='index_tool'>";
        require_once("./page/title.php");
        require_once("./page/category.php");

        header('Content-Type: text/html; charset=utf-8');
        $id = $_GET['id'];
        session_start();
        $user_id = $_SESSION['login'];

        $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
        $result = mysqli_query($mysql, "SELECT * FROM topic WHERE id = $id");

        $row = mysqli_fetch_array($result);
        $length = mysqli_num_rows($result) ; // 모든 게시글의 수
        $title = $row['title'];
        $category = $row['category'];
        $child = $row['child'];

        if($length === 0) {
          echo "<script> alert(\"존재하지 않는 게시물입니다.\"); </script>"; 
          echo "<script> window.location.replace('index.php'); </script>";
        }
    echo "</div>";

    echo "<div id='topic_tools_div'>"; // 1
    echo "<div> </div>";
      echo "<div id='topic_tools_rayout'>"; // 2
        echo "<div id='topic_img_notice'>"; // 3

          echo "<div id='topic_category_path'>"; //4
          echo "<a class='color_black' href='index.php'> 홈 </a>";
          echo "<img class='right_angel_img' src='./source/angel_right.png' />";
          echo "<a class='color_black' href='#'> ${category} </a>";
          echo "<img class='right_angel_img' src='./source/angel_right.png' />";
          echo "<a class='color_black' href='#'> ${child} </a>";
          echo "</div>"; //4
        echo "<hr />";

        $file = $row['file'];
        $id = $row['id'];
        $price_c = number_format($row['price']);

          echo "<h3 id='topic_title'> $title </h3>";
          echo "<div class='topic_img_notice_grid'>"; //5
            echo "<div id='topic_img'> <img id='topic_img_file' src='./source/topic_files/$file'/> </div>";
            echo "<div id='topic_notice_div'>";
              echo "<div id='topic_number'> 상품 번호 : $id";
              echo "<div class='topic_like_div $user_id $id'>";
              // <a href='#' class='topic_like_toggle'>";

              $result = mysqli_query($mysql, "SELECT * FROM `like` WHERE user_id = $user_id and topic_id = $id");
              $result_length = mysqli_num_rows($result);

              echo "<div class='topic_like_toggle'>";
              if($user_id === null) {
                echo "<img class='topic_like_img' src='./source/unlike.png'/> 찜하기";
              } else {

                // echo $result_length;
                if($result_length === 0) {
                  echo "<img class='topic_like_img' src='./source/unlike.png'/> 찜하기";
                  
                } else if($result_length >= 1) {
                  echo "<img class='topic_like_img on'src='./source/like.png'/> 찜 해제";
                }
              }
              // echo "</a>";
              echo "</div>";
              echo "</div>";

              echo "</div>";
              $price = $row['price'];
              echo "<div class='topic_price $price'> <h3> $price_c 원 </h3> </div>";

              echo "<div id='buy_topic_div'>";
              echo "<a class='ar_left ar'> <div> <img class='item_ar_img' src='./source/item_add.png' /> </div> </a> ";
              echo "<div> <input maxLength='3' class='item_total_num 0' type='text' /> </div>";
              echo "<a class='ar_right ar'> <div> <img class='item_ar_img' src='./source/item_remove.png' /> </div> </a>";
              echo "</div>";

              echo "<div id='buy_total_price_div'>";
              echo "<h2> <b id='buy_total_price'> 0 </b> 원</h2>";
              echo "</div>";

              echo "<div id='buy_item_selector_div'>";
              echo "<a href='javascript:add_cart($id)' class='color_black' id='add_cart'> <div id='buy_item_add_cart'> 장바구니 </div> </a>";
              echo "<a href='#' class='color_black'> <div> 바로 구매 </div> </a>";
              echo "</div>";

            echo "</div>";
          echo "</div>"; // 5
        echo "</div>"; // 3

      echo "</div>"; //2
    echo "</div>"; // 1
    echo "</div>"
    ?>
  
  <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>