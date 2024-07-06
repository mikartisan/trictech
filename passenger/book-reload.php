<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'] ?? "";
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getFirstName = $row["fname"];
            $getPosition = $row["position"];
            $getType = $row["type"];
        }
    }

    $booking_id = $_GET['booking_id'];

    // Query to check if the column has changed (replace 'your_table' and 'your_column' with actual table and column names)
    $query = "SELECT * FROM booking WHERE booking_id = '$booking_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];

        // Check if the column value has changed (you need to implement your own logic here)
        if ($status == 'accepted' ) {
            echo 'changed';
        }else if ($status == 'completed' ) {
            echo 'completed';
        }else if ($status == 'destroy' ) {
            echo 'cancelled';
        }else {
            echo 'unchanged';
        }
    } else {
        echo 'error';
    }

    $conn->close();
?>