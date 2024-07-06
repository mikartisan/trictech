<?php
    ob_start();
    session_start();
    include_once '../database/connect.php'; 
    require('../pdf/mc_table.php');

    // Get Date
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getFirstName = $row["fname"];
            $getPosition = $row["position"];
            $getType = $row["type"];
        }
    }

    //CHECK IF ALREADY LOGIN
    if(!isset($_SESSION['login'])){
        // not logged in
        header('Location: auth/login.php');
        exit();
    }else{
        if($getType=="rider"){
            header('Location: rider/dashboard.php');
        } else if ($getType=="passenger") {
            header('Location: passenger/dashboard.php');
        }
    }

    // Initialize PDF
    $pdf = new PDF_MC_Table();
    $pdf->AddPage();

    // Set column widths
    $pdf->SetWidths(array(20, 20, 10, 25, 40, 45, 30));

    // Set document title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'Trictech User Accounts', 0, 1, 'C');
    $pdf->Ln(5);

    // Date
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'DATE : '. substr($datetime, 0, 10), 0, 1);

    // Header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(193,229,252);
    $pdf->Row(array(
        'Last Name',
        'First Name',
        'Position',
        'Age',
        'Address',
        'Email',
        'Contact No.',
    ), true);
    $pdf->SetFont('Arial', '', 10);

    // SQL query to get data for the table
    $current_month = date('m');
    $current_year = date('Y');
    $sql = "SELECT * FROM account";
    $result = mysqli_query($conn, $sql);

    // Fetch and display data in the table
    $counter = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $counter++;
            $pdf->Row(array(
                $row["lname"],
                $row["fname"],
                !empty($row["birthdate"]) && $row["birthdate"] != "0" ? (new DateTime($row["birthdate"]))->diff(new DateTime())->y : "No",
                $row["position"],
                $row["address"],
                $row["email"],
                $row["contact"],
            ));
        }
    }

    // Output total number of rows
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Total Drivers : '. $counter, 0, 1); 

    // Output PDF
    $pdf->Output();
?>
