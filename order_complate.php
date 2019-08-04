<?php
    $mysql = mysqli_connect('sejun.chpyfqbmwueu.ap-northeast-2.rds.amazonaws.com', 'sejun', 'q1w2e3r4t5', 'mall');
            
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    
      } else {
        session_start();
        $user_id = $_SESSION['login'];
        $type = $_POST['type'];
        
        if($type === 'delete') {
            $topic_id = $_POST['topic_id'];
            $search = mysqli_query($mysql, "SELECT * FROM `cart` where user_id = $user_id AND topic_id = $topic_id");
            $row = mysqli_fetch_array($search);

            $num = $row['num'];

            mysqli_query($mysql, "DELETE FROM `cart` where user_id = $user_id AND topic_id = $topic_id");
            echo $num;
            exit;

        } else if($type === 'alert') {
            $seller_id = $_POST['seller_id'];
            mysqli_query($mysql, "INSERT INTO order_alert(seller_id) VALUES('$seller_id')");
            exit;

        } else if($type === 'search') {
            $result = mysqli_query($mysql, "SELECT * FROM `order` ORDER BY order_id DESC limit 1");
            $row = mysqli_fetch_array($result);

            $data = array();
            $order_id = $row['order_id'];

            echo $order_id;
            exit;

        } else if($type === 'add') {
            $order_id = $_POST['order_id'];
            $seller_id = $_POST['seller_id'];
            $payment = $_POST['payment_type'];
            $topic_id = $_POST['topic_id'];
            $price = $_POST['price'];
            $num = $_POST['num'];

            date_default_timezone_set("Asia/Seoul");
            $date = date("Y-m-d H:i:s");

            mysqli_query($mysql, "INSERT INTO `order`(order_id, user_id, seller_id, payment_type, topic_id, price, status, num, date) VALUES('$order_id', '$user_id', '$seller_id', '$payment', '$topic_id', '$price', '주문 완료', '$num', '$date')");   
            echo 'true';
            exit;
        }

    }

?>