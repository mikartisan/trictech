<?php
    ob_start();
    session_start();
    include './database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $first_km = $_POST['first_km'];
        $succ_km = $_POST['succ_km'];
        $discount = $_POST['discount'];

        // Prepare and execute SQL query
        $sql = "UPDATE fare_and_discount SET first_kilometers = ?, succeeding_kilometers = ?, discount= ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('iii', $first_km, $succ_km, $discount);

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