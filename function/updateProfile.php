<?php
    ob_start();
    session_start();
    include '../database/connect.php';
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
            $getPass = $row["password"];
        }
    }

    // Update profile
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $birthdate = $_POST["birthdate"];
        $contact = $_POST["contact"];
        $address = $_POST["address"];

        // Check if a new image is uploaded
        if(!empty($_FILES["profileImage"]["name"])) {
            // FRONT IMAGE OF ID
            $profile_filename = $_FILES["profileImage"]["name"];
            $profile_tempname = $_FILES["profileImage"]["tmp_name"];    

            // Construct the new filename with $unique_id and "-profile" suffix
            $new_profile_filename = $unique_id . "-profile." . pathinfo($profile_filename, PATHINFO_EXTENSION);
            move_uploaded_file($profile_tempname, "../images/profile/" . $new_profile_filename);
        }

        // Get all the submitted data from the form
        // Construct SQL query based on whether a new image is uploaded or not
        if(!empty($_FILES["profileImage"]["name"])) {
            $sql = "UPDATE account SET profile_img = ?, fname = ?, lname = ?, birthdate = ?, contact = ?, address = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param('sssssss', $new_profile_filename, $fname, $lname, $birthdate, $contact, $address, $getUser);
            }
        } else {
            $sql = "UPDATE account SET fname = ?, lname = ?, birthdate = ?, contact = ?, address = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param('ssssss', $fname, $lname, $birthdate, $contact, $address, $getUser);
            }
        }

        if ($stmt->execute()) {
            $_SESSION["status-notif"] = "true";
            $_SESSION["notif"] = "Profile Updated!";
        } else {
            $_SESSION["status-notif"] = "false";
            $_SESSION["notif"] = "Something went wrong!";
        }

        // Saved Activity Log
        $activity = "Update: Your information has been successfully modified.";
        $log = "INSERT INTO user_log (activity_id, fname, lname, position, activity, status, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_log = $pdo->prepare($log);
        if ($stmt_log) {
            $stmt_log->execute([$unique_id, $getFName, $getLName, $getPosition, $activity, 'OK', $datetime]);
        }
    }

    header("location: ../profile.php");
    exit();

?>