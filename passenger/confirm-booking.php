<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $origin = $_POST['origin'];
        $to = $_POST['to'];
        $driver_id = $_POST['driver_id'];
        $booking_id = $_POST['booking_id'];
        $distance = $_POST['distance'];
        $fare = $_POST['fare'];
        $notes = $_POST['notes'];
        $passenger_type = $_POST['passenger_type'];

        if($fare === '0'){
            echo json_encode(array("status" => "error", "error" => $stmt->error));
        }else {
            // Prepare and execute SQL query
            $sql = "UPDATE booking SET passenger_id = ?, passenger_origin = ?, passenger_destination = ?, passenger_notes = ?, distance = ?, estimated_fare = ?, passenger_type = ? WHERE booking_id = '$booking_id' and status = 'pending'";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('sssssis', $unique_id, $origin, $to, $notes, $distance, $fare, $passenger_type);

                if ($stmt->execute()) {
                    echo json_encode(array("status" => "success"));
                } else {
                    echo json_encode(array("status" => "error", "error" => $stmt->error));
                }

                $stmt->close();
            } else {
                echo json_encode(array("status" => "error", "error" => $conn->error));
            }
        }
    } else {
        echo json_encode(array("status" => "error"));
    }
?>