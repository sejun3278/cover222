        <div class='category_tools'>
          <div> </div>
          <div id='index_category_menu_div'> 
            <a class='point'> <img title='카테고리를 볼 수 있습니다.' id='category_img' src='./source/category.png' /> <u id='category_label'> 카테고리 </u> </a>
          </div>

          <div id='user_index_div'>
            <div> <a class='color_white' href='cart.php'> 장바구니 </a> </div>
            <div> <a class='color_white' href='like_list.php' class='plz_login my_page'> 찜 리스트 </a> </div>
            <?php
              session_start();
              if(isset($_SESSION['login'])) {
                $id = $_SESSION['login'];

                require_once("./config/config.php");
                $result = mysqli_query($mysql, "SELECT * FROM user WHERE id = $id");

                while($row = mysqli_fetch_array($result)) {
                  $type = $row['type'];
                }

                if($type === 'seller') {
                  echo "<div> <a class='plz_login write point'> 상품 등록 </a> </div>";
                }
              }
            ?>
          </div>
        </div> <!-- // category div 끝 -->