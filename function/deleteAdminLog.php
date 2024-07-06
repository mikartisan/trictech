<?php
    ob_start();
    session_start();
    include '../database/connect.php';
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE email = '$getUser';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getFName = $row["fname"];
            $getLName = $row["lname"];
            $getPosition = $row["position"];
        }
    }

    // Delete Activity LOgs
    if(isset($_POST["clearLog"])) {
        $getConfirm = $_POST["clearLogConfirm"];
        $confirm = "confirm deletion";

        if($getConfirm==$confirm) {
             // Get all the submitted data from the form
            $sql = "UPDATE admin_log SET status='VOID'";
            mysqli_query($conn, $sql);  

            // Check the result
            if (mysqli_affected_rows($conn) > 0) {
                
                //Saved Activity Log
                $activity = "Activity Log cleard by ". $getFName;
                $log = "INSERT INTO admin_log (fname, lname, position, activity, status, date)VALUES ('$getFName', '$getLName', '$getPosition', '$activity', 'OK', '$datetime')";
                $pdo->exec($log);

                $_SESSION["status-notif"] = "true";
                $_SESSION["notif"] = "Logs Deleted!";
            } else {
                $_SESSION["status-notif"] = "false";
                $_SESSION["notif"] = "Someting went wrong!";
            }
        }else{
            $_SESSION["status-notif"] = "false";
            $_SESSION["notif"] = "Invali Input!";
        }
        header("location: ../setting.php");
    } 

    mysqli_close($conn);
?>