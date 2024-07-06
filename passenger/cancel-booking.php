<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $status = 'pending';
        $passenger_id = NULL;
        $passenger_origin = NULL;
        $passenger_destination = NULL;
        $distance = NULL;
        $fare = NULL;
        $decline_note = NULL;
        $passenger_type = NULL;

        // Prepare and execute SQL query
        $sql = "UPDATE booking SET passenger_id = ?, passenger_origin = ?, passenger_destination = ?, distance = ?, estimated_fare = ?, status = ?, decline_note = ?, passenger_type = ? WHERE passenger_id = '$unique_id' and status = 'pending'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ssssisss', $passenger_id, $passenger_origin, $passenger_destination, $distance, $fare, $status, $decline_note, $passenger_type);

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