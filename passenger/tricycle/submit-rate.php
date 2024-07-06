<?php
    ob_start();
    session_start();
    include '../../database/connect.php'; 
    // Include badwords.php
    include 'badwords.php';
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getFirstName = $row["fname"];
            $getPosition = $row["position"];
            $getType = $row["type"];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get data from POST request
        $title = $_POST['title'];
        $comment = $_POST['comment'];
        $starCount = $_POST['star_count'];
        $driverID = $_POST['driver_id'];
        $points = 0.3; // points to be inserted per rating

        if(empty($title) || empty($comment)) {
            echo json_encode(array("message" => "error"));
        }

        // Convert the comment to lowercase for case-insensitive comparison
        $commentLower = strtolower($comment);

        // Function to check for bad words
        function hasBadWord($text, $badWords) {
            foreach ($badWords as $badWord) {
                if (strpos($text, $badWord) !== false) {
                    return true;
                }
            }
            return false;
        }

        // Check if any bad words are present
        if (hasBadWord($commentLower, $badWords)) {
            echo json_encode(array("message" => "badword"));
            exit;
        } else {
            // Prepare and execute SQL query
            $sql = "INSERT INTO driver_ratings (driver_id, passenger_id, name, star, title, comment, datetime) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssssss', $driverID, $unique_id, $getFirstName, $starCount, $title, $comment, $datetime);

            if ($stmt->execute()) {
                // Prepare and execute SQL query for adding rewards
                $sqlReward = "INSERT INTO rewards (passenger_id, points, date_earned) VALUES (?, ?, ?)";
                $stmtReward = $conn->prepare($sqlReward);
                $stmtReward->bind_param('sds', $unique_id, $points, $datetime);

                // Check if reward query execution is successful
                if ($stmtReward->execute()) {
                    echo json_encode(array("message" => "success"));
                } else {
                    // Handle reward insertion error
                    echo json_encode(array("message" => "error"));
                }
            } else {
                echo json_encode(array("message" => "error"));
            }
        }

        $stmt->close();
        $stmtReward->close();
        $conn->close();
    } else {
        echo json_encode(array("message" => "error"));
    }
?>