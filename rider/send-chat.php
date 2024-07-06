<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {

        $passenger_id = $_POST['passenger_id'];
        $booking_id = $_POST['booking_id'];
        $message = $_POST['message'];
        $sender = "driver";

        // Prepare and execute SQL query
        $sql = "INSERT INTO chats (booking_id, driver_id, passenger_id, message, sender, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ssssss', $booking_id, $unique_id, $passenger_id, $message, $sender, $datetime);

            if ($stmt->execute()) {
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "error", "error" => $stmt->error));
            }

            $stmt->close();
        } else {
            echo json_encode(array("status" => "error", "error" => $conn->error));
        }

    } else {
        echo json_encode(array("status" => "error"));
    }
?>