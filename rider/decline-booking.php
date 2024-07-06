<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $status = 'destroy';
        $booking_id = $_POST['booking_id'];
        $reason = $_POST['reason'];

        // Prepare and execute SQL query
        $sql = "UPDATE booking SET status = ?, decline_note = ?, created_at = ? WHERE booking_id = '$booking_id'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('sss', $status, $reason, $datetime);

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