<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $status = 'accepted';

        // Prepare and execute SQL query
        $sql = "UPDATE booking SET status = ? WHERE driver_id = '$unique_id' and status = 'pending'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('s', $status);

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