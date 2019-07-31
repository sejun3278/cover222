<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall </title>
    <link rel = "stylesheet" href = "style.css?after" type = "text/css">
    <meta charset="utf-8">

  </head>

  <body>
    <div id='index_tool'>
    <?php
        require_once("./page/title.php");
        require_once("./page/category.php");

           header('Content-Type: text/html; charset=utf-8');
           $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
           $result = mysqli_query($mysql, "SELECT * FROM topic ORDER BY id DESC");

           if(isset($_GET['page'])) {
            $page = $_GET['page'];
          
          } else {
            $page = 1;
          }

          $row = $result -> fetch_assoc();
          $all_post = mysqli_num_rows($result) ; // 모든 게시글의 수

          $one_page = 5; // 한 페이지에 보여줄 게시글의 수.
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

            echo "<div id='lately_topics' class='index_tools'>";
            echo "<h3 title='판매자들이 최근에 등록한 모든 게시물을 보여줍니다.'> Lately Items! </h3>";

            echo "<div id='lately_lists_tool'>";
              $current_limit = ($one_page * $page) - $one_page;
              $sql_limit = ' limit ' . $current_limit . ', ' . $one_page;
              $result = mysqli_query($mysql, "SELECT * FROM topic ORDER BY id DESC" . $sql_limit);

              date_default_timezone_set("Asia/Seoul");
              $today = date("Y-m-d H:i:s");

              while($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $date = $row['date'];
                $title = $row['title'];

                echo '<div>'; 
                echo "<a class='color_black' href='topic.php?id=$id'>";

                  echo '<div class="lately_date_div">';  
                  if(substr($today, 0, 10) === substr($date, 0, 10)) {
                    echo '<u title="오늘 생성된 게시물입니다." class="lately_date"> Today </u>';
                    echo substr($date, 10, 6);

                  } else {
                    echo substr($date, 0, 10);
                  }
                  echo '</div>';

                  echo "<div class='lately_div'>";
                  $img = $row['file'];
                  echo "<img class='lately_imgs' src='./source/topic_files/$img'/>";
                  echo '</div>';

                  echo '<div class="lately_title">';
                  echo "<a class='color_black' href='topic.php?id=$id'> $title </a>";
                  echo '</div>';
                  echo '</div>';
                  echo "</a>";
              }
            echo "</div>";

            echo "<div id='lately_page_tool'>";
              echo "<hr />";
              if($page != 1) { 
                echo "<a class='page page_start' href='./index.php'> 처음 </a>";
              }

              if($current_section != 1) {
                echo `<a class="page page_prev" href="./index.php?page=$prev_page"> 이전 </a> `;
              }

              for($i = $first_page; $i <= $last_page; $i++) {
                if($i == $page) {
                  echo "<b class='page current'> $i </b>";
              
                } else {
                  echo "<a class='page' href='./index.php?page=$i'> $i </a>";  
                }
              }

              if($current_section != $all_section) { 
                echo "<a class='page page_next' href='./index.php?page=$next_page'> 다음 </a>";
              }

              if($page != $all_page) { 
                echo "<a class='page page_end' href='./index.php?page=$all_page'> 끝 </a>";
              }
              
            echo "</div>";
            echo "<div>";
          ?>
          
          </div>
        </div>
    </div>
    <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>