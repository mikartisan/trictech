<?php
    ob_start();
    session_start();
    include './database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $status = "NO";
        $reason = NULL;

        // Prepare and execute SQL query
        $sql = "UPDATE account SET suspension = ?, suspension_reason = ? WHERE id = '$id'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ss', $status, $reason);

            if ($stmt->execute()) {
                echo json_encode(array("status" => "success"));

                $sql = mysqli_query($conn,"SELECT * FROM account WHERE id = '$id'");
                if(mysqli_num_rows($sql) > 0){
                    while($row = mysqli_fetch_assoc($sql)){
                        extract($row);
                    }
                }

                $subject = 'Account Suspension Notification';
                $message = '
                Dear User,

                We are pleased to inform you that your account suspension has been lifted, and you can now access 
                and use our platform again. We apologize for any inconvenience this temporary suspension may have caused. 
                We appreciate your cooperation during the review process. If you have any questions or concerns, 
                please dont hesitate to contact our support team at [trictoda@gmail.com]. Our team will be happy to assist you further.

                Thank you for your patience and understanding.

                Sincerely,
                TricTech
                trictoda@gmail.com';

                $headers = 'From: trictoda@gmail.com';

                if (mail($email, $subject, $message, $headers)) {
                    echo json_encode(array("status" => "success"));
                } else {
                    echo json_encode(array("status" => "error", "error" => $stmt->error));
                }

            } else {
                echo json_encode(array("status" => "error", "error" => $stmt->error));
            }
        }

    } else {
        echo json_encode(array("status" => "error"));
    }
?>