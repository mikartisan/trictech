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
        $sqlDriver = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$driver_id';");
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
        $sqlPassenger = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
        if(mysqli_num_rows($sqlPassenger) > 0){
            while($row = mysqli_fetch_assoc($sqlPassenger)){
                $getPassName = $row['fname'] .' '. $row['lname'];
                $getPassContact = $row["contact"];
                // $getEmerContact = $row["emer_contact"];
            }
        }

        // Construct the URL using string concatenation and variables
        $url = "http://sme.absierra.com/passenger/tricycle/emergency.php?driver_id=$driver_id&passenger_id=$unique_id&location=$encoded_location";

        $sql = "SELECT email FROM emergency_contacts WHERE unique_id = '$unique_id'";
        $result = $conn->query($sql);

        if ($result) {
            // Loop through the results and send SOS emails
            while ($row = $result->fetch_assoc()) {
                $to = $row['email'];
                $subject = "TricTech Emergency";
                // Construct the SOS message
                $message = "Emergency SOS: This is an urgent message. Please click the link below to view important information about the exact location and details of your relatives." . "<br><br>";
                $message .= "<strong>Driver Information:</strong><br>";
                $message .= "Name: $getDrivFName $getDrivLName<br>";
                $message .= "Email: $getDrivEmail<br>";
                $message .= "Contact: $getDrivContact<br><br>";
                $message .= "<strong>Passenger Information:</strong><br>";
                $message .= "Name: $getPassName<br>";
                $message .= "Contact: $getPassContact<br><br>";
                $message .= "<strong>SOS Details:</strong> <a href=\"$url\">$url</a>";
                
                // Set additional headers (optional)
                $header = "From: tritech@example.com\r\n";
                $header .= "Reply-To: trictech@example.com\r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-type: text/html; charset=utf-8\r\n";
                
                // Use the mail() function to send the email
                $mailSent = mail($to, $subject, $message, $header);
                
                // Check if the email was sent successfully
                if (!$mailSent) { 
                    echo json_encode(array("status" => "error"));
                    exit; // Exit the script if there's an error in sending email
                }
            }

            echo json_encode(array("status" => "success"));
        } else {
            // Handle the case where the query failed
            echo json_encode(array("status" => "error"));
        }

        // CODE FOR SMS SENDER
        $send_data = [];

        // START - Parameters to Change
        // Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        // Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+639813297245";
        // Put message content here
        
        $send_data['message'] = "Emergency SOS: This is an urgent message. Please click the link below to view important information about the exact location and details of your relatives.\n\n";
        $send_data['message'] .= "Driver Information:\n";
        $send_data['message'] .= "Name: $getDrivFName $getDrivLName\n";
        $send_data['message'] .= "Email: $getDrivEmail\n";
        $send_data['message'] .= "Contact: $getDrivContact\n\n";
        $send_data['message'] .= "Passenger Information:\n";
        $send_data['message'] .= "Name: $getPassName\n";
        $send_data['message'] .= "Contact: $getPassContact\n\n";
        $send_data['message'] .= "Current Location: $current_location\n\n";
        $send_data['message'] .= "SOS Details: $url";        

        // Put your API TOKEN here
        $token = "664|Rk2m2wLBqIDB7usOw3jmueZwuPkzmGi0LJIiPjKE";
        // END - Parameters to Change

        // No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

        curl_close($ch);

        // Close the mailer and proceed with SMS sending
    } else {
        echo json_encode(array("status" => "error"));
    }
?>
