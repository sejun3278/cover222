<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall Login</title>
    <link rel = "stylesheet" href = "style.css?after" type = "text/css">
    <meta charset="utf-8">

  </head>

  <body>
    <div id='index_tool'>
      <?php
      require_once("./page/title.php");
      ?>
    </div>

    <h2 id='login_title'> Login </h2>
    <div class='login_form_grid'>
      <div> </div>
      <!-- 왼쪽 레이아웃 -->

      <div class='login_tool'>
        <div id='login_id_div'>
          <?php
            $id = $_GET['id'];
            echo "ID <br /> <input type='text' value='$id' class='login_input alert_id' id='login_id' />"
          ?>

        </div>

        <div id='login_password_div'>
          Password <br /> <input type='password' class='login_input alert_password' id='login_pass' />
        </div>
      </div>
    </div>

      <div id='login_button_div'>
        <a id='login_button' class='color_black'> Login in </a>
      </div>

      <div id='go_signup'>
        <a href='signup.php' class='color_black'> Signup </a>
      </div>
    <script src = "script.js" type="text/javascript"> </script>
  </body>
</html>