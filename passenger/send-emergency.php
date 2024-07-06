<?php
    ob_start();
    session_start();
    include '../../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $driver_id = $_POST['driver_id'];
        $current_location = $_POST['address'];

        // URL-encode the location to handle spaces and special characters
        $encoded_location = urlencode($current_location);


         //Get Current Driver
        $driverID = $_GET["driver_id"] ?? "";
        $sqlDriver = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$driverID';");
        if(mysqli_num_rows($sqlDriver) > 0){
            while($row = mysqli_fetch_assoc($sqlDriver)){
                $getDrivFName = $row["fname"];
                $getDrivLName = $row["lname"];
                $getDrivEmail = $row["email"];
                $getDrivContact = $row["contact"];
                $getDrivBirth = $row["birthdate"];
                $getDrivAddress = $row["address"];
                $getProfileImg = $row['profile_img'];
            }
        }

        //Get Current Passenger
        $passengerID = $_GET["passenger_id"] ?? "";
        $sqlPassenger = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$passengerID';");
        if(mysqli_num_rows($sqlPassenger) > 0){
            while($row = mysqli_fetch_assoc($sqlPassenger)){
                $getPassName = $row['fname'] .' '. $row['lname'];
                $getPassContact = $row["contact"];
            }
        }

        // Construct the URL using string concatenation and variables
        $url = "http://sme.absierra.com/passenger/tricycle/emergency.php?driver_id=$driver_id&location=$encoded_location";

        $sql = "SELECT email FROM emergency_contacts WHERE unique_id = '$unique_id'";
        $result = $conn->query($sql);

        if ($result) {
            // Loop through the results and send SOS emails
            while ($row = $result->fetch_assoc()) {
                $to = $row['email'];
                // $senderName = $row['fname'] ." ". $row['lname'];
        
                // Set the subject of the email
                $subject = "TricTech Emergency";
        
                // Construct the SOS message
                $message = "Emergency SOS: This is an urgent message. Please click the link below to view important information about the exact location and details of your relatives." . PHP_EOL;
                $message .= "Driver Information:" . PHP_EOL;
                $message .= "Name: $getDrivFName $getDrivLName" . PHP_EOL;
                $message .= "Email: $getDrivEmail" . PHP_EOL;
                $message .= "Contact: $getDrivContact" . PHP_EOL;
                $message .= "Passenger Information:" . PHP_EOL;
                $message .= "Name: $getPassName" . PHP_EOL;
                $message .= "Contact: $getPassContact" . PHP_EOL;
                $message .= "SOS Details: $url";

                // Set additional headers (optional)
                $headers = "From: trictoda@gmail.com\r\n";
                $headers .= "Reply-To: trictoda@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\r\n";
        
                // Use the mail() function to send the email
                $mailSent = mail($to, $subject, $message, $headers);
        
                // Check if the email was sent successfully
                if ($mailSent) { 
                } else {
                    echo json_encode(array("status" => "error"));
                }
                echo json_encode(array("status" => "success"));
            }
        } else {
            // Handle the case where the query failed
            echo json_encode(array("status" => "error"));
        }

        $conn->close();
    } else {
        echo json_encode(array("status" => "error"));
    }
?>