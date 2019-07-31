<?php
    echo "<div class='title_tools'>";
    echo "<h3> <a href='index.php' title='홈 화면으로 이동합니다.' id='title'> Sejun's Mall </a> </h3> <hr />";
    
        echo "<div id='title_login_check'>";
        session_start();

        if(!isset($_SESSION['login'])) { // 로그인 하지 않은 상황
            echo "<div>";
            echo "<a href='login.php'> 로그인 </a>";
            echo "<u> | </u>";
            echo "<a href='signup.php'> 회원가입 </a>";
            echo "</div>";

        } else { // 로그인한 상황
            echo "<div>";
            echo "<a href='logout.php'> 로그아웃 </a>";
            echo "<u> | </u>";
            echo "<a> 마이페이지 </a>";
            echo "</div>";
        }
        echo "</div>";

    echo "</div>";
?>