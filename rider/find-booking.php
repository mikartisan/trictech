<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    function generateUniqueId($length = 16) {
        $characters = '0123456789abcdef';
        $uniqueId = '';
    
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $uniqueId .= $characters[$index];
        }
    
        return $uniqueId;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /**
         * Accept Booking
        */
        $current_location = $_POST['address'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $booking_id = generateUniqueId();

        // URL-encode the location to handle spaces and special characters
        $encoded_location = urlencode($current_location);
        
        // Prepare and execute SQL query
        $sql = "INSERT INTO booking (booking_id, driver_id, current_location, driver_latitude, driver_longitude) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('sssss', $booking_id, $unique_id, $current_location, $latitude, $longitude);

            if ($stmt->execute()) {
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "error", "error" => $stmt->error));
            }

            $stmt->close();
        } else {
            echo json_encode(array("status" => "error", "error" => $conn->error));
        }

        $conn->close();
    } else {
        echo json_encode(array("status" => "error"));
    }
?>