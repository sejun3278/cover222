<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall - Like List</title>
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

    <div id='like_list_tools_div'>    <!-- 2 -->
      <div> </div>
      <div class='center_rayout'>     <!-- 3 -->
        <div id='like_list_title_div'>
          <img class='title_img' src='./source/like_list_title.png'/>
          <b class='titles'> <a class='color_black' href='like_list.php'> 찜 리스트 </a> </b>
        </div>

        <div id='liek_list_tool'>
          <?php
            $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
            
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            
              } else {

                if(isset($_GET['page'])) {
                  $page = $_GET['page'];
                
                } else {
                  $page = 1;
                }

                session_start();
                $user_id = $_SESSION['login'];

                $result = mysqli_query($mysql, "SELECT topic_id FROM `like` where user_id = $user_id");
      
                $row = $result -> fetch_assoc();
                $all_post = mysqli_num_rows($result) ; // 모든 게시글의 수
      
                $one_page = 10;// 한 페이지에 보여줄 게시글의 수.
                $all_page = ceil($all_post / $one_page); //전체 페이지의 수
      
                if($page < 1 || ($all_page && $page > $all_page)) {
                  echo "<script> alert(\"존재하지 않는 페이지입니다.\"); </script>"; 
                  echo "<script> window.location.replace('index.php'); </script>";
                }

                $one_section = 10;
                $current_section = ceil($page / $one_section);
                $all_section = ceil($all_page / $one_section);
      
                $first_page = ($current_section * $one_section) - ($one_section - 1);
      
                if($current_section == $all_section) {
                  $last_page = $all_page; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
                
                } else {            
                  $last_page = $current_section * $one_section; //현재 섹션의 마지막 페이지
                }
      
                $prev_page = (($current_section - 1) * $one_section); // 페이지를 10씩 이동 (이전);
                $next_page = (($current_section + 1) * $one_section) - ($one_section - 1);

                $current_limit = ($one_page * $page) - $one_page;
                $sql_limit = ' limit ' . $current_limit . ', ' . $one_page;

                // $result = mysqli_query($mysql, "SELECT * FROM `topic` left join `like` on topic");
                $result = mysqli_query($mysql, "SELECT topic_id FROM `like` where user_id = $user_id" . $sql_limit);

                $result_length = mysqli_num_rows($result);

                echo "<hr />";

                if($result_length === 0) {
                    echo "<div class='empty_div'>";
                    echo "<img class='empty' src='./source/empty_list.png'/>";
                    echo "<div id='null_like_list'> <h3> 선택한 찜 리스트가 없습니다. </h3> </div>";
                    echo "</div>";
                    echo "<hr />";
                    exit;
                }

                echo "<div class='other_div'>";
                    echo "<div> </div>";
                    echo "<div class='choice_result_num 0'> <input type='checkbox' class='all_choice' id='all_total_choice' /> <label class='point' for='all_total_choice'> 전체 선택 ( <u class='choice_select_lists'> 0 </u> / <u class='all_total_num $result_length'> $result_length </u> ) </label> </div>";
                    echo "<div> <a class='color_black point list_all_remove like_list'> 선택 삭제 </a> </div>";
                echo "</div>";

                
                while($row = mysqli_fetch_array($result)) {
                    $topic_id = $row['topic_id'];
                    
                    $select = mysqli_query($mysql, "SELECT * FROM `topic` where id = $topic_id ");
                    
                    while($row = mysqli_fetch_array($select)) {
                        $title = $row['title'];
                        $file = $row['file'];
                        $id = $row['id'];
                        $price = $row['price'];
                        $price_c = number_format($price);

                        echo "<div id='like_lists'>"; // 2
                        echo "<div id='like_lists_check_div'> <input id='c_lists_check_$id' class='check_list $id' name='lists_check_$id' type='checkbox' />";
                        echo "<label class='label_choice point' for='c_lists_check_$id'> 선택 </lavel> </div>";
                        echo "<div> <a href='topic.php?id=$id'> <img src='./source/topic_files/$file' /> </a> </div>";
                        // echo "<div> </div>";
                        echo "<div id='like_lists_title_div'> <a class='color_black' href='topic.php?id=$id'> <div id='like_lists_num'> 상품 번호 : $id </div> <h4 class='l_l_title'> $title </h4> </a> <div id='like_list_price'> $price_c 원 </div> </div>";
                        echo "<div class='each_remove_button $id like_list'> <a class='point'> 개별 삭제 </a> </div>";
                        echo "</div>"; // 2;
                    }
                  }

            echo "<div id='like_list_page_tool'>";
              echo "<hr />";
              if($page != 1) { 
                echo "<a class='page page_start' href='./like_list.php'> 처음 </a>";
              }

              if($current_section != 1) {
                echo `<a class="page page_prev" href="./like_list.php?page=$prev_page"> 이전 </a> `;
              }

              for($i = $first_page; $i <= $last_page; $i++) {
                if($i == $page) {
                  echo "<b class='page current'> $i </b>";
              
                } else {
                  echo "<a class='page' href='./like_list.php?page=$i'> $i </a>";  
                }
              }

              if($current_section != $all_section) { 
                echo "<a class='page page_next' href='./like_list.php?page=$next_page'> 다음 </a>";
              }

              if($page != $all_page) { 
                echo "<a class='page page_end' href='./like_list.php?page=$all_page'> 끝 </a>";
              }
              
            echo "</div>";

                echo "</div>";
              }
          ?>
        </div>

        </div>    <!-- 3 -->
      </div>    <!-- 2 -->
    </div>    <!-- 1 -->

  </body>
  <script src = "script.js" type="text/javascript"> </script>
</html>