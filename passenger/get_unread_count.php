<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    // Include your database connection code here
    $booking_id = $_GET['booking_id']; // Assuming you're passing booking_id as a GET parameter

    $sql = "SELECT COUNT(*) as unread FROM chats WHERE booking_id = '$booking_id' AND sender = 'driver' AND seen IS NULL";
    $result = $conn->query($sql);

    if ($result) {
        // Fetch the result as an associative array
        $row = $result->fetch_assoc();
        $unreadCount = $row['unread'];

        echo $unreadCount;
    }
?>