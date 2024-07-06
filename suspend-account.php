<?php
    ob_start();
    session_start();
    include './database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $email = $_POST['email'];
        $status = 'suspended';
        $reason = $_POST['reason'];

        // Prepare and execute SQL query
        $sql = "UPDATE account SET suspension = ?, suspension_reason = ? WHERE id = '$id'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ss', $status, $reason);

            if ($stmt->execute()) {
                // Code matches, retrieve the email
                $subject = 'Account Suspension Notification';
                $message = '
                Dear User,

                We regret to inform you that your account has been temporarily suspended due to a violation of our terms of service. 
                This decision has been made following a careful review of your account activities. During the suspension period, 
                you will not be able to access your account or perform any actions on our platform. 
                We kindly ask you to review our terms of service to understand the specific policy violation that led to this action.

                If you believe this suspension is in error or if you have any questions regarding the suspension, 
                please contact our support team at [trictoda@gmail.com]. Include your account details and any relevant information to 
                expedite the resolution process.

                We appreciate your understanding and cooperation in maintaining a safe and compliant community.

                Sincerely,
                TricTech
                trictoda@gmail.com
                ';
                $headers = 'From: trictoda@gmail.com';

                if (mail($email, $subject, $message, $headers)) {
                    echo json_encode(array("status" => "success"));
                } else {
                    echo json_encode(array("status" => "error", "error" => $stmt->error));
                }

                
                // SMS SENDER
                // Put the SID here
                $send_data['sender_id'] = "PhilSMS";
                // Put the number or numbers here separated by comma w/ the country code +63
                $send_data['recipient'] = "+639813297245";
                // Put message content here
                $send_data['message'] = "Account Suspension Notification: \n\n";
                $send_data['message'] .= "Your account has been temporarily suspended due to a violation of our terms. Contact support at [trictoda@gmail.com] for assistance. Thank you for your cooperation. - TricTech";

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
            } else {
                echo json_encode(array("status" => "error", "error" => $stmt->error));
            }
        }

    } else {
        echo json_encode(array("status" => "error"));
    }
?>