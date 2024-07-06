<?php
    ob_start();
    session_start();
    include './database/connect.php'; 

    //CHECK IF ALREADY LOGIN
    if(!isset($_SESSION['login'])){
        // not logged in
        header('Location: ./auth/login.php');
        exit();
    }else{
        //Get Current User
        $getUser = $_SESSION['unique_id'] ?? "";
        $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$getUser';");
        if(mysqli_num_rows($sqlUser) > 0){
            while($row = mysqli_fetch_assoc($sqlUser)){
                $getName = $row["fname"];
                $getPosition = $row["position"];
                $getType = $row["type"];
            }
        }

        if($getType=="rider"){
            header('Location: ./rider/dashboard.php');
        }else if($getType=="admin" || $getType=="*" || $getType == "municipality"){
            header('Location: ./admin.php');
        }else if($getType=="passenger") {
            header('Location: ./passenger/dashboard.php');
        }else if($getType=="operator") {
            header('Location: ./operator/dashboard.php');
        }else{
            // not logged in
            header('Location: ./auth/login.php');
            exit();
        }
    }
?>
