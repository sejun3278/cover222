<!-- <!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall Signup </title>
    <link rel = "stylesheet" href = "style.css?after" type = "text/css">
    <meta charset="utf-8">

  </head>

  <body>
    <div id='index_tool'>
      <?php
        require_once("./page/url_exit.php");
        require_once("./page/title.php");
        $type = $_GET['type'];
        $id = $_GET['id'];

        if($type === 'buyer') {
            echo "<h3 id='user_info_title'> 회원 정보 </h3>";
        } else {
            echo "<h3 id='user_info_title'> 기업 정보 </h3>";
        }
        echo "<div class='signup_user_grid $id'>";
            echo "<div> </div>";
            echo "<div class='signup_form_div'>";
        if($type === 'buyer') { // 구매자 회원일 경우
            // echo "<div class='user_info_div'>";
            //   echo "<div class='user_picture_div'>";
            echo "<input type='file' name='user_img_input' id='user_img_change' style='display : none;' />";
            echo "<img id='user_profile_img' src='./source/user_profile.png'/> <br />";
            echo "<a id='user_profile_notice'> ▲ 클릭해 사진 추가 </a>";
            echo "<br />";
//                     </div>

//                     <div class='user_info_input_div'>
            echo "<div class='user_host_div'>";
            echo "<b> 주소 </b> <br />";
            echo "<input class='host_input signup_first_host' maxLength='20' placeholder='도/시/군 단위를 적어주세요.' type='text' /> <br />";
            echo "<input class='host_input signup_second_host' maxLength='30' placeholder='상세 정보를 적어주세요.' type='text' />";
            echo "</div>";

            echo "<div class='user_host_div'>";
            echo "<b> 휴대전화 </b> <br />";
            echo "<select> <option> 010 </option> <option> 011 </option> <option> 013 </option> </select> -";
            echo "<input class='user_phone_number_input signup_first_phone' type='text' maxLength='4'/> -";
            echo "<input class='user_phone_number_input signup_second_phone' type='text' maxLength='4'/>";

            echo "<div id='signup_div'> <a id='final_signup_button' class='point'> Signup </a> </div>";
            echo "</div>";

            echo "</div>";
        echo "</div>";
        }
      ?>
    </div>

    <script src = "script.js" type="text/javascript"> </script>
  </body>

</html> -->