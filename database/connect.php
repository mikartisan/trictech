<?php
    $conn = mysqli_connect('localhost', 'root', '','courier_db') or die("Connection failed: " . mysqli_connect_error());
	// $conn = mysqli_connect('localhost', 'id20122348_courier', '2vdcp_?^YTI6*Y]x','id20122348_courier_db') or die("Connection failed: " . mysqli_connect_error());
	try{
        $pdo = new PDO("mysql:host=localhost;dbname=courier_db", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }
    
?> 