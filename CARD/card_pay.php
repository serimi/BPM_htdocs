<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $receivedData = file_get_contents('php://input'); // POST 데이터 읽어오기
        parse_str($receivedData, $postData);

        $c_num = $postData["c_num"];
        $c_cvc = $postData["c_cvc"];
        $c_date = $postData["c_date"];
        $c_pw = $postData["c_pw"];

        try {
            $db = new PDO("mysql:host=192.168.0.5;dbname=card;charset=utf8", "bpm", "@Rkddbals0217");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $statement = $db->prepare("SELECT * FROM CARD_TABLE WHERE c_num  = :c_num AND c_cvc  = :c_cvc AND c_date  = :c_date AND c_pw  = :c_pw");
            $statement->bindParam(':c_num', $c_num, PDO::PARAM_STR);
            $statement->bindParam(':c_cvc', $c_cvc, PDO::PARAM_STR);
            $statement->bindParam(':c_date', $c_date, PDO::PARAM_STR);
            $statement->bindParam(':c_pw', $c_pw, PDO::PARAM_STR);  
            $statement->execute();

            $response = array();
            $response["purchased"] = false;
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response["purchased"] = true;
            }
            echo json_encode($response);
            } catch (PDOException $e) {
            // 에러 처리
            echo "Database Error: " . $e->getMessage();
        }
    // echo "Received data from sending server: " . $receivedData;
    } else {
        echo "Invalid request";
    }
?>