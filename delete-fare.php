<?php
    ob_start();
    session_start();
    include './database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteID'])) {

        $deleteID = $_POST['deleteID'];

        // Prepare and execute SQL query
        $sql = "DELETE FROM fare_matrix WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $deleteID); // Assuming 'i' is the type for an integer ID
        
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success"));
            //Saved Activity Log
            $activity = "Update: You deleted a fare from fare matrix.";
            $log = "INSERT INTO user_log (activity_id, fname, lname, position, activity, status, date)VALUES ('$unique_id', '$getFName', '$getLName', '$getPosition', '$activity', 'OK', '$datetime')";
            $pdo->exec($log);
        } else {
            echo json_encode(array("status" => "error", "error" => $stmt->error));
        }

    } else {
        echo json_encode(array("status" => "error"));
    }
?>