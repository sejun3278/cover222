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

<!-- //////////////////////////////////////////////////////////////////////// -->
      <div class='signup_none_buyer'>         <!-- 1 -->
        <h3 class='user_info_title'> 회원 정보 </h3>
        <div class='signup_user_grid'>    <!-- 2 -->
        <div> </div>        <!-- 2-1 -->
        <form method='POST' action='#'>
          <div class='user_picture_div'>      <!-- 2-2 -->
                <input type='file' name='user_img_input_buyer' class='user_img_change user_img_change_buyer' id='img_change_buyer' style='display : none;' />
                <img class='add_profile_img add_profile_img_buyer' src='./source/user_profile.png'/> <br />
                <a id='user_profile_notice'> ▲ 클릭해 사진 추가 </a>
                <br />
          </div>        <!-- 2-2 -->

          <div class='user_host_div user_host_alert_div_buyer'>
            <b> 주소 </b> <br />
            <input class='host_input signup_first_host_buyer' maxLength='20' placeholder='도/시/군 단위를 적어주세요.' type='text' /> <br />
            <input class='host_input signup_second_host_buyer' maxLength='30' placeholder='상세 정보를 적어주세요.' type='text' /> <br />
          </div>

          <div class='user_host_div user_phone_alert_div_buyer'>
            <b> 휴대전화 </b> <br />
            <select name='phone_first_num_buyer' id='first_phone_number_select'> <option> 010 </option> <option> 011 </option> <option> 013 </option> </select> -
            <input class='user_phone_number_input signup_middle_phone_buyer' type='text' maxLength='4'/> -
            <input class='user_phone_number_input signup_last_phone_buyer' type='text' maxLength='4'/> <br />
          </div>

        </form>
        </div>        <!-- 2 -->
        <div class='signup_complate_div'>
          <a class='signup_complate_button point'> Signup </a>
        </div>
      </div>          <!-- 1 -->
      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <div class='signup_none_seller'>
        <h3 class='user_info_title'> 판매자 정보 </h3>
        <div class='signup_user_grid'>    <!-- 2 -->
          <div> </div>        <!-- 2-1 -->
          <form method='POST' action='#'>
          <p id='seller_logo'> * 판매 대표 로고 (필수) </p>
          <div class='user_picture_div user_picture_div_seller'>      <!-- 2-2 -->
                <input type='file' name='user_img_input_seller' class='user_img_change user_img_change_seller' id='img_change_seller' style='display : none;' />
                <img class='add_profile_img add_profile_img_seller' src='./source/user_profile.png'/> <br />
                <a id='user_profile_notice'> ▲ 클릭해 사진 추가 </a>
                <br />
          </div>        <!-- 2-2 -->

          <div class='user_host_div user_company_alert_div'>
            <b> 회사 이름 </b> <br />
            <!-- <u id='company_name_input'> 기입하지 않으면 닉네임으로 대체 </u> -->
            <input id='company_name_input' maxLength='15' placeholder='기입하지 않을 경우 닉네임으로 대체됩니다.'/> 
            <br />
          </div>

          <div class='user_host_div user_host_alert_div_seller'>
            <b> 주소 </b> <br />
            <input class='host_input signup_first_host_seller' maxLength='20' placeholder='도/시/군 단위를 적어주세요.' type='text' /> <br />
            <input class='host_input signup_second_host_seller' maxLength='30' placeholder='상세 정보를 적어주세요.' type='text' /> <br />
          </div>

          <div class='user_host_div user_phone_alert_div_seller'>
            <b> 전화번호 </b> <br />
            <select name='phone_first_num_seller' id='first_phone_number_select'> <option> 010 </option> <option> 011 </option> <option> 013 </option> </select> -
            <input class='user_phone_number_input signup_middle_phone_seller' type='text' maxLength='4'/> -
            <input class='user_phone_number_input signup_last_phone_seller' type='text' maxLength='4'/> <br />
          </div>

        </form>
        </div>    <!-- 2 -->
        <br />
        <div class='signup_complate_div'>
            <a class='signup_complate_button point'> Signup </a>
        </div>
        <br /> <br />
      </div>

          <!-- ///////////////////////////////////////////////////// -->
        <div class='signup_form_div'>
          <div> </div>
          <form>
          <div>
            <div id='signup_id_div' class='signup_alerts'>
              <b> 아이디 </b> <br />
              <input type='text' name='id' id='signup_id' class='signup_input signup_input_id' maxLength='10'/>
            </div>

            <div id='signup_nickname_div' class='signup_alerts'>
              <b> 닉네임 </b> <br />
              <input type='text' name='nickname' id='signup_nick' class='signup_input signup_input_nick' maxLength='10'/>
            </div>

            <div id='signup_password_div' class='signup_alerts'>
              <b> 비밀번호 </b> <br />
              <input autocomplete='off' type='password' name='password' id='signup_pass' class='signup_input signup_input_pass' maxLength='10'/>
            </div>

            <div id='signup_confirm_div' class='signup_alerts'>
              <b> 비밀번호 확인 </b> <br />
              <input autocomplete='off' type='password' name='confirm' id='signup_confirm' class='signup_input signup_input_confirm' maxLength='10'/>
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
          </div>
        </form>
    </div>

    <script src = "script.js" type="text/javascript"> </script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  </body>
</html>