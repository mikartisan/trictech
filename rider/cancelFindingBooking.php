<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $sql = "DELETE FROM booking WHERE driver_id = ? AND passenger_id IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $unique_id);
        
        if ($stmt->execute()) {
            $affected_rows = $stmt->affected_rows;

            if ($affected_rows > 0) {
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "error"));
            }
        }

        $stmt->close();

    } else {
        echo json_encode(array("status" => "error"));
    }
?>