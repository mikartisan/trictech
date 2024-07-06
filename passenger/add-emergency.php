<?php
    ob_start();
    session_start();
    include '../database/connect.php';

    // Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getName = $row["fname"];
            $getPosition = $row["position"];
            $getType = $row["type"];
        }
    }

    // Check if it's an AJAX request
    if (isset($_POST['email'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $relationship = $_POST['relationship'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        // Check the current count of emergency contacts for the user
        $countSql = $conn->prepare("SELECT COUNT(*) FROM emergency_contacts WHERE unique_id = ?");
        $countSql->bind_param("s", $unique_id);
        $countSql->execute();
        $countSql->bind_result($contactCount);
        $countSql->fetch();
        $countSql->close();

        // Check if the user has already reached the maximum limit (2)
        if ($contactCount >= 2) {
            echo json_encode(array("message" => "limit"));
            exit;
        }

        // Prepare and bind the SELECT statement to check if the email exists
        $checkSql = $conn->prepare("SELECT COUNT(*) FROM emergency_contacts WHERE contact = ?");
        $checkSql->bind_param("s", $email);
        $checkSql->execute();
        $checkSql->bind_result($count);
        $checkSql->fetch();
        $checkSql->close();

        if ($count > 0) {
            // Email already exists, return an error message
            echo json_encode(array("message" => "error"));
        } else {
            // Prepare and bind the insert statement
            $insertSql = $conn->prepare("INSERT INTO emergency_contacts (unique_id, name, relationship, email, contact) VALUES (?, ?, ?, ?, ?)");
            $insertSql->bind_param("ssssi", $unique_id, $name, $relationship, $email, $contact);

            if ($insertSql->execute()) {
                echo json_encode(array("message" => "success"));
            } else {
                echo json_encode(array("message" => "error"));
            }

            // Close statement
            $insertSql->close();
        }

        // Close connection
        $conn->close();
        exit; // Stop executing the PHP script after handling the AJAX request
    }

    // Check if it's an AJAX request
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];

        // Check the number of rows in the table
        $countSql = "SELECT COUNT(*) as count FROM emergency_contacts";
        $result = $conn->query($countSql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $rowCount = $row['count'];

            // Proceed with deletion only if there is more than one row
            if ($rowCount > 1) {
                $deleteSql = "DELETE FROM emergency_contacts WHERE id = {$id}";

                if ($conn->query($deleteSql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            } else {
                echo "You need to provide at least one recipient email";
            }
        } else {
            echo "Error: Unable to fetch row count.";
        }

        $conn->close();
        exit;
    }
?>
