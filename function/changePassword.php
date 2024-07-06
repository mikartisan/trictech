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
            $getName = $row["name"];
            $getPosition = $row["position"];
            $getPass = $row["password"];
        }
    }

    // Delete Activity LOgs
    if(isset($_POST["changePass"])) {
        $oldPassword = md5($_POST["oldPass"]);
        $newPassword = md5($_POST["newPass"]);
        $confirmPassword = md5($_POST["confirmPass"]);

        if($oldPassword==$getPass) {

            if($newPassword==$confirmPassword) {

                // Get all the submitted data from the form
                $sql = "UPDATE account SET password='$newPassword' WHERE email = '$getUser'";
                mysqli_query($conn, $sql);  

                // Check the result
                if (mysqli_affected_rows($conn) > 0) {
                    
                    //Saved Activity Log
                    $activity = "Activity Log cleard by ".$getName.".";
                    $log = "INSERT INTO admin_log (name, position, activity, status, date)VALUES ('$getName', '$getPosition', '$activity', 'OK', '$datetime')";
                    $pdo->exec($log);

                    $_SESSION["status-notif"] = "true";
                    $_SESSION["notif"] = "Password Change!";
                } else {
                    $_SESSION["status-notif"] = "false";
                    $_SESSION["notif"] = "Someting went wrong!";
                }
 
            }else{
                $_SESSION["status-notif"] = "false";
                $_SESSION["notif"] = "Password Not Match!";
            }
            
        }else{
            $_SESSION["status-notif"] = "false";
            $_SESSION["notif"] = "Incorrect Password!";
        }
    }

        header("location: ../setting.php");

    mysqli_close($conn);
?>