<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <title> Sejun's Mall - My Order List </title>
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

            <div id='order_list_tools_div'>    <!-- 2 -->
                <div> </div>
                <div class='center_rayout'> <!-- 3 -->
                    <div class='title_div'> <!-- 4 -->
                        <a class='color_black'> 
                            <img class='title_img' src='./source/buy_list.png'/>
                            <b class='titles'> 주문 내역 </b>
                        </a>
                    </div> <!-- 4 -->
                    <hr />
                    <div class='my_order_list_div'>
                        <?php
                            session_start();
                            $user_id = $_SESSION['login'];

                            $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
                            $result = mysqli_query($mysql, "SELECT * FROM `order` where user_id = $user_id ORDER BY topic_id DESC");
                            $row = mysqli_fetch_array($result);

                            $result_length = mysqli_num_rows($result);
                            if($result_length === 0) {
                                echo "<div class='empty_div'>";
                                echo "<img class='empty' src='./source/empty_buy_list.png'/>";
                                echo "<div> <h3> 구매한 내역이 하나도 없습니다. </h3> </div>";
                                echo "</div>";
                                echo "<hr />";

                            } else {
                                $search = mysqli_query($mysql, "SELECT *, count(*) FROM `order` WHERE user_id = $user_id GROUP BY order_id");
                                $search_length = mysqli_num_rows($search);
                                
                                echo "<div>";
                                echo "총 $search_length 개의 구매 목록이 있습니다.";
                                echo "</div>";

                                echo "<div class='my_order_list_margin'>";
                                while($row = mysqli_fetch_array($search)) {
                                    echo "<div class='my_order_lists'>";
                                    $order_id = $row['order_id'];
                                    $date = $row['date'];
                                    $status = $row['status'];

                                    $day = substr($date, 0, 10);
                                    $time = substr($date, 10);

                                    echo "<div class='my_order_list_grid'>";
                                    echo "<div> </div>";
                                    echo "<div> 주문 번호 : $order_id </div>";
                                    echo "<div> 주문 날짜 : <u title='$time'> $day </u> </div>";
                                    echo "<div> 주문 현황 : <b> $status </b> </div>";
                                    echo "</div>";
                                
                                    $result = mysqli_query($mysql, "SELECT `order`.payment_type, num, topic.* 
                                                                    FROM `order` INNER JOIN topic
                                                                    ON `order`.topic_id = topic.id AND `order`.order_id = $order_id
                                                                    ORDER BY topic_id DESC;
                                                                ");
                                    while($row = mysqli_fetch_array($result)) {
                                        $seller_id = $row['seller_id'];

                                        $topic_id = $row['id'];
                                        $img = $row['file'];

                                        $price = $row['price'];

                                        echo "<div class='my_order_lists_contents_grid'>";

                                        echo "<div>";
                                            echo "<a href='topic.php?id=$topic_id'> <img class='my_order_list_img' src='./source/topic_files/$img' /> </a>";
                                        echo "</div>";

                                        $id = $row['id'];
                                        $title = $row['title'];
                                        $num = $row['num'];

                                        $total = $num * $price;
                                        $c_total = number_format($total);

                                        $seller_id = $row['seller_id'];
                                        $seller = mysqli_query($mysql, "SELECT * FROM `user` WHERE user_id = $seller_id");
                                        $row = mysqli_fetch_array($seller);

                                        $company = $row['company'];

                                        echo "<div class='my_order_lists_margin'>";
                                            echo "<a href='topic.php?id=$topic_id'>";
                                            echo "<u> 상품 번호 : $id </u>";
                                            echo "<u class='my_order_lists_company'> 판매자 : $company </u>";
                                            echo "</a>";

                                            echo "<div id='aa'> <b> $title </b></div>";
                                            echo "<div id='bb'> 수량 : $num </div>";
                                            echo "<div id='cc'> <b> 금액 : $c_total 원 </b> </div>";
                                        echo "</div>";
                                        
                                        echo "</div>";
                                        echo "<hr />";
                                    }

                                    echo "</div>";
                                }

                                
                                // $result = mysqli_query($mysql, "SELECT order.*, topic.* FROM cart INNER JOIN topic ON cart.topic_id = topic.id AND cart.user_id = $user_id ORDER BY seller_id DESC");

                                echo "</div>";
                            }
                            
                        ?>
                    </div>

                </div>  <!-- 3 -->
            </div> <!-- 2 -->
    </div>      <!-- 1 -->

    <script src = "script.js" type="text/javascript"> </script>
    </body>
</html>