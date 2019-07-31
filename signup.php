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
        require_once("./page/title.php");
      ?>
    </div>

    <div class='signup_form_grid'>
        <div> </div>
        <!-- 왼쪽 레이아웃 -->
        <form method='POST' action='#'>
        <div class='signup_form_div'>

        <div id='signup_id_div' class='signup_alerts'>
          ID <br />
          <input type='text' name='id' id='signup_id' class='signup_input' maxLength='10'/>
        </div>

        <div id='signup_nickname_div' class='signup_alerts'>
          Nickname <br />
          <input type='text' name='nickname' id='signup_nick' class='signup_input' maxLength='10'/>
        </div>

        <div id='signup_password_div' class='signup_alerts'>
          Password <br />
          <input type='password' name='password' id='signup_pass' class='signup_input' maxLength='10'/>
        </div>

        <div id='signup_confirm_div' class='signup_alerts'>
          Confirm Password <br />
          <input type='password' name='confirm' id='signup_confirm' class='signup_input' maxLength='10'/>
        </div>

        <div>
          User Type <br />
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
        <div>
    </div>

        <div id='signup_button_div'> 
          <a id='signup_button'> Signup </a>
        </div>
        </form>
    </div>

    <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>