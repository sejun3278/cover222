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

        session_start();
        $id = $_SESSION['login'];

        if(!isset($_SESSION['login'])) {

          echo "<script> alert(\"잘못된 경로입니다.\"); </script>"; 
          echo "<script> window.location.replace('index.php'); </script>";

        } else {
          header('Content-Type: text/html; charset=utf-8');
          $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
          $result = mysqli_query($mysql, "SELECT * FROM user WHERE id = $id");

          while($row = mysqli_fetch_array($result)) {
              $type = $row['type'];

              if($type === 'buyer') {
                echo "<script> alert(\"잘못된 경로입니다.\"); </script>"; 
                echo "<script> window.location.replace('index.php'); </script>";
              }
          }
        }
    ?>

    <div id='write_tools'>
      <div> </div>

      <div class='center_rayout'>
        <div class='center_margin'>
            <div id='write_category'>
              <div>
                카테고리 <br />
                <select id='write_category_list' value='write_category_val'> </select>
              </div>

              <div id='write_child_list_div'>
                <select id='write_child_list'> </select>
              </div>
            </div>

            <div class='write_title_div write_divs'>
            제목 <br /> <input id='write_title_input' type='text' maxLength='50' placeholder='최소 1글자 이상 입력하세요.'/>
            </div>

            <div class='write_textarea_div write_divs'>
            내용 <br /> <textarea id='write_textarea' maxLength='1000' rows='25' ></textarea>
            </div>

            <div class='write_price_div write_divs'>
            희망 판매가 <u title='개당 가격가'> <u class='each_price'> (1개 가격) </u> <br /> <input id='write_price' type='type' maxLength='9' placeholder='숫자로만 적어주세요.'/> 원
            </div>

            <div class='write_file_div write_divs'>
              <img src='https://cdns.iconmonstr.com/wp-content/assets/preview/2012/240/iconmonstr-picture-1.png'/> 
              <u> 이미지 첨부 </u>
                <div class='write_file_upload_div'>
                  대표 이미지 : <input name='write_files' type='file' id='write_file_input'/>
                </div>
            </div>
        </div>
      </div>

      <div id='write_complate'>
        <a href='#' id='write_submit'> 등록하기 </a>
      </div>
    </div>

    </div>
    <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>