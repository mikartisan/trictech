<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['report'])) {

        $passenger_id = $_POST['passenger_id'];
        $report = $_POST['report'];
        $report_id = generateUniqueId();
        $report_by = "driver";

        // Prepare and execute SQL query
        $sql = "INSERT INTO reports (report_id, driver_id, passenger_id, reason, report_by, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ssssss', $report_id, $unique_id, $passenger_id, $report, $report_by, $datetime);

            if ($stmt->execute()) {
                echo json_encode(array("status" => "success"));

                // Sent verification email
                $email = 'trictoda@gmail.com';
                $subject = 'TricTech: Passenger Account Reported';
                $message = 'A passenger reported by a driver : ' . $report .  PHP_EOL;
                $message .= 'Visit for more information about the report : https://sme.absierra.com/suspend.php';
                $header = 'From: trictech@gmail.com';
                    
                if (mail($email, $subject, $message, $header)) {
                    // Send the code to db
                    $sql = "UPDATE account SET vercode='$code' WHERE email = '$email'";
                    mysqli_query($conn, $sql);  
                } else {
                    $error = true;
                    $notif = "Email could not be sent.";
                }
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