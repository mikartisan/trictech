<?php
    ob_start();
    session_start();
    include './database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getFName = $row["fname"];
            $getLName = $row["lname"];
            $getPosition = $row["position"];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $approval_id = $_POST['approval_id'];
        $status = "NO";

        $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$approval_id';");
        if(mysqli_num_rows($sqlUser) > 0){
            while($row = mysqli_fetch_assoc($sqlUser)){
                $getEmail = $row["email"];
            }
        }

        // Prepare and execute SQL query
        $sql = "UPDATE booking_verification SET verification_status = ? WHERE verification_id = '$approval_id'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('s', $status);

            if ($stmt->execute()) {
                // Sent verification email
                $subject = 'TricTech: Booking Approval';
                $message = 'We regret to inform you that your application for access to our booking service has not been approved at this time. After careful review, we have determined that your application does not meet our current criteria for approval.'. PHP_EOL;
                $message .= 'Use Tritech Booking through this link : ' . 'https://sme.absierra.com/';
                $headers = 'From: trictech@gmail.com';
                    
                if (mail($getEmail, $subject, $message, $headers)) {
                    echo json_encode(array("status" => "success"));

                    //Saved Activity Log
                    $activity = "A passenger account has been declined for verification.";
                    $log = "INSERT INTO user_log (activity_id, fname, lname, position, activity, status, date)VALUES ('$unique_id', '$getFName', '$getLName', '$getPosition', '$activity', 'OK', '$datetime')";
                    $pdo->exec($log);
                } else {
                    echo json_encode(array("status" => "error", "error" => $stmt->error));
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