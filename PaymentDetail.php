<?php
    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


    $con = mysqli_connect("192.168.0.12", "bpmddg", "@Rkddbals!", "bpm", 3306);
    mysqli_query($con,'SET NAMES utf8');

    $sql = "SELECT product, amount, unitPrice, totalPrice FROM PAY_DETAIL";
    $result = $con->query($sql);

    $response = array();

    if ($result->num_rows > 0) {
        // 데이터를 배열에 추가
        while($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    }

    echo json_encode($response);

?>
