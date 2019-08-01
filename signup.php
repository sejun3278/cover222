<!doctype html>
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
      ?>

      <?php

//         echo "<div id='signup_none'>";
//         if($type === 'buyer') {
//             echo "<h3 id='user_info_title'> 회원 정보 </h3>";
//         } else {
//             echo "<h3 id='user_info_title'> 기업 정보 </h3>";
//         }
//         echo "<div class='signup_user_grid $id'>";
//             echo "<div> </div>";
//             echo "<div class='signup_form_div'>";
//         if($type === 'buyer') { // 구매자 회원일 경우
//             // echo "<div class='user_info_div'>";
//             //   echo "<div class='user_picture_div'>";
//             echo "<input type='file' name='user_img_input' id='user_img_change' style='display : none;' />";
//             echo "<img id='user_profile_img' src='./source/user_profile.png'/> <br />";
//             echo "<a id='user_profile_notice'> ▲ 클릭해 사진 추가 </a>";
//             echo "<br />";
// //                     </div>

// //                     <div class='user_info_input_div'>
//             echo "<div class='user_host_div'>";
//             echo "<b> 주소 </b> <br />";
//             echo "<input class='host_input signup_first_host' maxLength='20' placeholder='도/시/군 단위를 적어주세요.' type='text' /> <br />";
//             echo "<input class='host_input signup_second_host' maxLength='30' placeholder='상세 정보를 적어주세요.' type='text' />";
//             echo "</div>";

//             echo "<div class='user_host_div'>";
//             echo "<b> 휴대전화 </b> <br />";
//             echo "<select> <option> 010 </option> <option> 011 </option> <option> 013 </option> </select> -";
//             echo "<input class='user_phone_number_input signup_first_phone' type='text' maxLength='4'/> -";
//             echo "<input class='user_phone_number_input signup_second_phone' type='text' maxLength='4'/>";

//             echo "<div id='signup_div'> <a id='final_signup_button' class='point'> Signup </a> </div>";
//             echo "</div>";

//             echo "</div>";
//         echo "</div>";
//         }
//         echo "</div>";
      ?>
    </div>

    <div class='signup_form_grid'>
        <div> </div>
        <!-- 왼쪽 레이아웃 -->
        <form method='POST' action='#'>
        <div class='signup_form_div'>

        <div id='signup_id_div' class='signup_alerts'>
          <b> 아이디 </b> <br />
          <input type='text' name='id' id='signup_id' class='signup_input' maxLength='10'/>
        </div>

        <div id='signup_nickname_div' class='signup_alerts'>
          <b> 닉네임 </b> <br />
          <input type='text' name='nickname' id='signup_nick' class='signup_input' maxLength='10'/>
        </div>

        <div id='signup_password_div' class='signup_alerts'>
          <b> 비밀번호 </b> <br />
          <input type='password' name='password' id='signup_pass' class='signup_input' maxLength='10'/>
        </div>

        <div id='signup_confirm_div' class='signup_alerts'>
          <b> 비밀번호 확인 </b> <br />
          <input type='password' name='confirm' id='signup_confirm' class='signup_input' maxLength='10'/>
        </div>
        <br />
        <div>
          <b> 회원 종류 </b> <br />
          <div class='type_checkbox_div'>
            <div class='point'>
              <input type='radio' name='user_type' value='buyer' class='type_checkbox' id='buyer' checked='checked'/>
              <label for='buyer'> 구매자 </label>
            </div>

            <div class='point'>
              <input type='radio' name='user_type' value='seller' class='type_checkbox' id='seller'/>
              <label for='seller'> 판매자 </label>
            </div>
          </div>
    </div>

        <div id='signup_button_div'> 
          <a id='signup_button'> Next </a>
        </div>
        </form>
    </div>



    <script src = "script.js" type="text/javascript"> </script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  </body>
</html>