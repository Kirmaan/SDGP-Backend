<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");
    include("DbConnect.php");
    $conn = new DbConnect();
    $db = $conn->connect();
    $method = $_SERVER['REQUEST_METHOD'];
    switch($method) {
        case 'GET':
           $sql = "SELECT * FROM Appointment";
           $stmt = $db->prepare($sql);
           $stmt->execute();
           $users = $stmt->fetchAll(PDO::FETCH_ASSOC);        
           echo json_encode($users);
           break;
        case 'POST':
            $user = json_decode(file_get_contents('php://input'));
            $request_body = file_get_contents('php://input');
            $data2 = json_decode($request_body, true);


            $item = $data2['item']; // Works!
            $itemReal = $item['number']['number'];
            $sql = "DELETE FROM `Appointment` WHERE NHS_NUMBER = $itemReal";
            $stmt = $db->prepare($sql);
            if($stmt->execute()) {
                
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $data = ['status' => 0, 'message' => "Failed to create record."];
            }
           // echo json_encode($data);
            echo json_encode($users);
            break;
        }
?>