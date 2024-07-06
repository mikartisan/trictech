<?php
    ob_start();
    session_start();
    include '../../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $idType = $_POST['type'];
        $passengerType = $_POST['passenger-type'];
        $status = "pending";

        // Check if file was uploaded successfully
        if (isset($_FILES['frontImage'])) {

            // FRONT IMAGE OF ID
            $front_filename = $_FILES["frontImage"]["name"];
            $front_tempname = $_FILES["frontImage"]["tmp_name"];    

            // BACK IMAGE OF ID
            $back_filename = $_FILES["backImage"]["name"];
            $back_tempname = $_FILES["backImage"]["tmp_name"];   

            // Construct the new filename with $unique_id and "-front" suffix
            $new_front_filename = $unique_id . "-front." . pathinfo($front_filename, PATHINFO_EXTENSION);
            $new_back_filename = $unique_id . "-back." . pathinfo($back_filename, PATHINFO_EXTENSION);
            
            $sql = "UPDATE booking_verification SET id_type = ?, front_img = ?, back_img = ?, passenger_type = ?, verification_status = ? WHERE verification_id = '$unique_id' and verification_status = 'NO'";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('sssss', $idType, $new_front_filename, $new_back_filename, $passengerType, $status);
    
                if ($stmt->execute()) {
                    // Move the uploaded image into the folder: image if an image is uploaded
                    if (!empty($_FILES["frontImage"]["name"]) && move_uploaded_file($front_tempname, "image/" . $new_front_filename) && move_uploaded_file($back_tempname, "image/" . $new_back_filename)) {
                        header("location: pending.php");
                        echo json_encode(array("status" => "success"));
                    } else {
                        header("location: verify.php");
                    }
                } else {
                    echo json_encode(array("status" => "error", "error" => $stmt->error));
                }
    
                $stmt->close();
            } else {
                echo json_encode(array("status" => "error", "error" => $conn->error));
            }
        }

    } else {
        echo json_encode(array("status" => "error"));
    }
?>