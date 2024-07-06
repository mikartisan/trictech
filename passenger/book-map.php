<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'] ?? "";
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
        header('Location: ../auth/login.php');
        exit();
    }else{
        if($getType=="admin" || $getType=="*") {
            header('Location: ../routing.php');
        }else if($getType=="rider") {
            header('Location: ../rider/dashboard.php');
        }
    }

    /*
    * GET DRIVER/BOOKING ID
    */
    $driver_id = $_GET['driver_id'];
    $booking_id = $_GET['booking_id'];

    /*
    * GET Fare for special trip
    */
    $sqlFare = mysqli_query($conn,"SELECT * FROM fare_and_discount");
    if(mysqli_num_rows($sqlFare) > 0){
        while($row = mysqli_fetch_assoc($sqlFare)){
            $getDiscount = $row['discount'];
        }
    }

    // For Notification
    $notif = $_SESSION["notif"] ?? ""; //For Session Notification phrase
    $statNotif = $_SESSION["status-notif"] ?? ""; // For checking notif if succes or error
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="../images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../dist/output.css">
    <!-- Datatables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind Elements -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" /> -->

    <!-- Notification and Modal -->
    <script src="../dist/tata.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- flowbite -->
    <script src="../dist/flowbite.js"></script>

    <style>    
        #data-table-basic_wrapper .dataTable, #data-table-basic_wrapper .dataTables_scrollHeadInner {
            width: 100% !important;
        }
    </style>
</head>
<body class="bg-gray-50" onload="getMyLocation()">
    <div>
        
        <!-- Toast Notifications -->
        <?php
            if(!empty($notif) && $statNotif == "true") {
                ?> <script type="text/javascript">tata.success('SUCCESS', '<?php echo $notif; ?>', {position: 'tr', duration: 5000})</script> <?php
            } else if(!empty($notif) && $statNotif == "false") {
                ?> <script type="text/javascript">tata.error('ERROR', '<?php echo $notif; ?>', {position: 'tr', duration: 5000})</script> <?php
            }
        ?>
        <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <!-- Nav Button for Small devices -->
                        <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <a href="dashboard.php" class="text-xl font-bold flex items-center p-2 lg:ml-2.5">
                            <img class="w-20 lg:w-28" src="../images/logo.png" alt="logo">
                        </a>
                    </div>
                    <div class="flex items-center">
                        <button id="toggleSidebarMobileSearch" type="button" class="lg:hidden text-gray-500 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-lg">
                            <!-- <span class="sr-only">Search</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg> -->
                        </button>

                        <a href="chat.php?driver_id=<?php echo $driver_id; ?>&booking_id=<?php echo $booking_id; ?>" class="relative inline-flex items-center p-2 text-sm font-medium text-center text-white bg-blue-400 rounded-lg hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                                <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                            </svg>
                            <span class="sr-only">Notifications</span>
                            <div id="unreadCount" class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2">
                                <!-- Show the count of unred message here -->
                            </div>
                        </a>

                        <!-- Dropdown Profile Menu -->
                        <div class="hidden lg:block">
                            <a href="#" id="dropdownDefault" data-dropdown-toggle="dropdown" class="sm:inline-flex ml-5 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mr-3">
                                <!-- <svg class="svg-inline--fa fa-gem -ml-1 mr-2 h-4 w-4" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="gem" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M378.7 32H133.3L256 182.7L378.7 32zM512 192l-107.4-141.3L289.6 192H512zM107.4 50.67L0 192h222.4L107.4 50.67zM244.3 474.9C247.3 478.2 251.6 480 256 480s8.653-1.828 11.67-5.062L510.6 224H1.365L244.3 474.9z"></path>
                                </svg> -->
                                <i class="mr-2 text-base fa fa-user-circle" aria-hidden="true"></i>
                                Profile
                            </a>
                            <!-- Dropdown Profile Menu -->
                            <div id="dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                                <div class="px-4 py-3">
                                    <span class="block text-sm text-gray-900 dark:text-white"><b>Hello, <?php echo ucwords($getFirstName); ?></b></span>
                                    <!-- <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">jmdeocampo@gmail.com</span> -->
                                </div>
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                                    <li>
                                        <a href="profile.php" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                                    </li>
                                    <li>
                                        <a href="../auth/logout.php" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        
        <div class="flex overflow-hidden bg-white pt-16">
            <aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
                <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
                    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                        <div class="flex-1 px-3 bg-white divide-y space-y-1">
                            <ul class="space-y-2 pb-2">
                                <li>
                                    <form action="#" method="GET" class="lg:hidden">
                                        <label for="mobile-search" class="sr-only">Search</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                                </svg>
                                            </div>
                                            <input type="text" name="email" id="mobile-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600  block w-full pl-10 p-2.5" placeholder="Search">
                                        </div>
                                    </form>
                                </li>

                                <!-- Profile -->
                                <div class="lg:hidden">
                                    <li>
                                        <a href="profile.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                        <i class="fa fa-user-circle  text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                        <span class="ml-3 flex-1 whitespace-nowrap">Profile</span>
                                        </a>
                                    </li>
                                </div>
                                
                                <li>
                                    <a href="dashboard.php" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <i class="text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75 fa fa-pie-chart" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Dashboard</span>
                                    </a>
                                </li>

                                <!-- Booking -->
                                <li>
                                    <a href="booking.php" class="text-base text-gray-900 font-normal rounded-lg bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-motorcycle text-xl text-blue-600 flex-shrink-0 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap text-blue-600">Booking</span>
                                    </a>
                                </li>

                                <!-- Fare Estimation -->
                                <li>
                                    <a href="fare.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-location text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Fare Estimation</span>
                                    </a>
                                </li>

                                <!-- Fare Estimation -->
                                <li>
                                    <a href="fare-matrix.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-map text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Fare Matrix</span>
                                    </a>
                                </li>

                                <!-- Points & Rewards -->
                                <!-- <li>
                                    <a href="rewards.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-star text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Points & Rewards</span>
                                    </a>
                                </li> -->
                                
                                <!-- Logout -->
                                <div class="lg:hidden">
                                    <li>
                                        <a href="../auth/login.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                        <i class="fa fa-sign-out text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                        <span class="ml-3 flex-1 whitespace-nowrap">Sign out</span>
                                        </a>
                                    </li>
                                </div>
                            </ul>
                            
                            <div class="space-y-2 pt-2">
                                <!-- Activity Log -->
                                <a href="logs.php" class="text-base hover:bg-gray-100 font-normal rounded-lg group transition duration-75 flex items-center p-2">
                                    <i class="fa fa-clock  text-base text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" name="settings-outline"></i>
                                    <span class="ml-3">Activity Log</span>
                                </a>

                                <!-- Setting -->
                                <a href="../setting.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                                    <i class="fa fa-cog  text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" name="settings-outline"></i>
                                    <span class="ml-3">Settings</span>
                                </a>

                                <a href="#" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-3">Help</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
            <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
                <main>
                    <div class="pt-6 px-4">
                        <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
                            <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                                <div class="mb-1 flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Booking</h3>
                                        <span class="text-base font-normal text-gray-500">View your booking details here.</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <button type="button" onclick="reportDriver()" class="-mt-2 text-sm font-bold text-white bg-red-400 rounded-full px-3 py-1 hover:bg-red-500">
                                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            Report
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col mt-1">
                                    <div class="overflow-x-auto rounded-lg">

                                        <?php
                                            $driver = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$driver_id';");
                                            if(mysqli_num_rows($driver) > 0){
                                                while($row = mysqli_fetch_assoc($driver)){
                                                    $getDrivFName = $row["fname"];
                                                    $getDrivLName = $row["lname"];
                                                    $getDrivEmail = $row["email"];
                                                    $getProfileImg = $row['profile_img'];
                                                }
                                            }
                                        ?>

                                        <div class="w-full h-1/2 p-8 flex justify-center">
                                        <img class="w-32 h-32 rounded-full" src="../images/profile/<?php echo $getProfileImg ?? "profile.png"; ?>" alt="Rounded avatar">                    
                                        </div>
                                        <div class="justify-center text-center">
                                            <p class="text-2xl font-semibold block"><?php echo $getDrivFName ." ". $getDrivLName; ?></>
                                            <h3 class="text-gray-600">Driver</h3>
                                        </div>
                                        <div class="align-middle inline-block min-w-full">
                                            <?php
                                                $getPassBook = mysqli_query($conn,"SELECT * FROM booking WHERE booking_id = '$booking_id'");
                                                if(mysqli_num_rows($getPassBook) > 0){
                                                    while($row = mysqli_fetch_assoc($getPassBook)){
                                                        $getOrigin = $row["passenger_origin"];
                                                        $getDestination = $row["passenger_destination"];
                                                        $getDistance = $row["distance"];
                                                        $getFare = $row["estimated_fare"];
                                                        $getStatus = $row["status"];
                                                        $getPassType = $row["passenger_type"];
                                                    }
                                                }
                                            ?>
                                            <div class="shadow overflow-hidden sm:rounded-lg">
                                                
                                                <?php 
                                                    if($getStatus === 'pending') {
                                                        ?>
                                                            <div class='rounded-md text-black mb-3 mt-3'>
                                                                <div class='bg-blue-300 p-4 rounded-xl mb-2'><div class='bg-blue-300 p-3 rounded-xl'>Wait for the driver to accept your booking. Remember, you can cancel anytime if the driver hasn't accepted yet.</div></div>
                                                            </div>
                                                            <div class="flex justify-between mb-3">
                                                                <button type="button" onclick="cancelBookingPassenger()" class="text-md font-bold text-white bg-red-400 rounded-full px-5 py-3 w-full hover:bg-red-500">
                                                                    <i class="fa fa-times" aria-hidden="true"></i> cancel
                                                                </button>
                                                            </div>
                                                        <?php
                                                    } else if($getStatus === 'accepted' || $getStatus === 'completed') {
                                                        ?>
                                                            <form method="POST">
                                                                <!-- Origin -->
                                                                <div class="flex items-center border-2 py-2 px-2 rounded-2xl mb-4 mt-6">
                                                                    <ion-icon name="locate-outline" class="text-xl ml-2 mr-2 text-gray-400"></ion-icon>
                                                                    <input type="text" id="origin" value="<?php echo $getOrigin; ?>" placeholder="Origin" class="pl-3 w-full outline-none border-none" readonly/>
                                                                </div>

                                                                <!-- Destination Input -->
                                                                <div class="flex items-center border-2 py-3 px-2 rounded-2xl mb-4 mt-4">
                                                                    <ion-icon name="location-outline" class="text-xl ml-2 mr-2 text-gray-400"></ion-icon>
                                                                    <input type="text" id="to" value="<?php echo $getDestination; ?>" class="pl-3 w-full outline-none border-none" readonly/>
                                                                </div>

                                                                <div class='rounded-md text-black mb-4 mt-4 p-3'>
                                                                    <h3 class="text-lg text-[#333] font-bold mb-3">Booking Summary</h3>
                                                                    <ul class="text-base text-[#333] space-y-2 mt-2">
                                                                        <li class="flex flex-wrap gap-4">Passenger Type <span class="ml-auto"><?php echo $getPassType; ?></span></li>
                                                                        
                                                                        <li class="flex flex-wrap gap-4">Discount <span class="ml-auto">
                                                                            <?php 
                                                                                if($getPassType !== 'Regular') {
                                                                                    echo $getDiscount . "%";
                                                                                }else {
                                                                                    echo "Not Applicable";
                                                                                }
                                                                            ?>
                                                                        </span></li>
                                                                        <li class="flex flex-wrap gap-4">Total Distance <span class="ml-auto"><?php echo $getDistance ?></span></li>
                                                                        <li class="flex flex-wrap gap-4">Estimated Price <span class="ml-auto font-semibold">
                                                                            ₱<?php echo $getFare ." -  ₱". ($getFare + 5); ?></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </form>

                                                            <!-- Rate/SOS Button -->
                                                            <div class="mb-4 mt-5 flex">
                                                                <?php
                                                                    if($getStatus === 'completed') {
                                                                        ?>
                                                                        <a href="tricycle/rate.php?driver_id=<?php echo $driver_id; ?>" class="w-1/2 bg-blue-500 mr-1 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                                                                            <span>
                                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                                Rate
                                                                            </span>
                                                                        </a>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <a href="#" class="w-1/2 bg-blue-500 mr-1 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center pointer-events-none opacity-50">
                                                                            <span>
                                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                                Rate
                                                                            </span>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                ?> 
                                                                
                                                                <!-- <div>
                                                                    <div class="flex justify-between mb-3">
                                                                        <a href="chat.php?passenger_id=<?php echo $passenger_id; ?>&booking_id=<?php echo $booking_id; ?>" class="text-md font-bold text-white bg-green-400 rounded-full px-5 py-3 w-full text-center hover:bg-green-500"><i class="fa fa-commenting" aria-hidden="true"></i> Chat (0)</a>
                                                                    </div>
                                                                </div> -->

                                                                <a href="#" onclick="sendSOS()" class="w-1/2 bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                                                                    <span>
                                                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                                        SOS
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        <?php
                                                    }
                                                ?>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Map -->
                            <?php 
                                if($getStatus === 'pending') {
                                    ?>
                                        <div class="bg-white shadow rounded-lg min-h-[500px] p-4 sm:p-6 xl:p-8 2xl:col-span-2 flex flex-col items-center justify-center">
                                            <img src="../images/map-loader.gif" alt="loader" class="mb-4">
                                        </div>
                                    <?php
                                } else {
                                    ?>
                                        <div id="googleMap" class="bg-white shadow rounded-lg min-h-[500px] p-4 sm:p-6 xl:p-8  2xl:col-span-2">
                                        </div>  
                                    <?php
                                }
                            ?>

                        </div>
                    </div>

                    <div class="pt-6 px-4">
                        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Weather Forecast</h2>
                            <div id="ww_158555083e806" v='1.3' loc='auto' a='{"t":"responsive","lang":"en","sl_lpl":1,"ids":[],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"#FFFFFF","cl_font":"#000000","cl_cloud":"#d4d4d4","cl_persp":"#2196F3","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","cl_odd":"#0000000a","el_nme":3}'>Встановити <a href="https://weatherwidget.org/uk/" id="ww_158555083e806_u" target="_blank">HTML інформер погоди для сайту</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_158555083e806"></script>
                            <!-- <iframe src="https://www.rainviewer.com/map.html?loc=14.9634,121.3371,9&oFa=0&oC=1&oU=0&oCS=1&oF=0&oAP=1&c=3&o=90&lm=1&layer=radar&sm=1&sn=1&hu=0" width="100%" frameborder="0" style="border:0;height:50vh;" allowfullscreen></iframe> -->
                        </div>
                    </div>
                </main>
                <footer class="bg-white md:flex md:items-center md:justify-between shadow rounded-lg p-4 md:p-6 xl:p-8 my-6 mx-4">
                    <ul class="flex items-center flex-wrap mb-6 md:mb-0">
                        <li><a id="terms_modal" href="#" class="text-sm font-normal text-gray-500 hover:underline mr-4 md:mr-6">Terms and conditions</a></li>
                        <li><a id="privacy_modal" href="#" class="text-sm font-normal text-gray-500 hover:underline mr-4 md:mr-6">Privacy Policy</a></li>
                        <li><a id="license_modal"  href="#" class="text-sm font-normal text-gray-500 hover:underline mr-4 md:mr-6">Licensing</a></li>
                        <li><a id="cookie_modal" href="#" class="text-sm font-normal text-gray-500 hover:underline mr-4 md:mr-6">Cookie Policy</a></li>
                        <li><a id="member_modal" href="#" class="text-sm font-normal text-gray-500 hover:underline">Contact</a></li>
                    </ul>
                    <div class="flex sm:justify-center space-x-6">
                    <a href="#" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    </div>
                </footer>
                <p class="text-center text-sm text-gray-500 my-10">
                    &copy; <?php echo date('Y'); ?> <a href="#" class="hover:underline" >TriTech</a>. All rights reserved.
                </p>
            </div>
        </div>

        <!-- IONIC_ICONS -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        <!-- JQuery/DataTables JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>

        <!-- Tailwind Elements -->
        <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>

        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
        <!-- Terms, Condition and Policy -->
        <script src="../js/conditions.js"></script>

        <!-- Google Map / Courier Routing-->
        <script src="../js/passenger-book-map.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBXQ709mh8Hcuv3tZzU4vhUgG2isUPPPE&libraries=places&callback=initMap" async defer></script>

        <script>
            $(document).ready(function() {
                var booking_id = "<?php echo $booking_id; ?>";

                function checkBookingStatus() {
                    $.ajax({
                        url: 'book-reload.php',
                        method: 'GET',
                        data: {
                            booking_id: booking_id
                        },
                        success: function(response) {
                            console.log(response);

                            // Retrieve isReloaded flag from local storage (preventing continuous reload)
                            var isBookingReloaded = localStorage.getItem('isBookingReloaded') === 'true';
                            var isBookingCompleted = localStorage.getItem('isBookingCompleted') === 'true';
                            var isBookingCancelled = localStorage.getItem('isBookingCancelled') === 'true';

                            if (response.trim() === 'changed' && !isBookingReloaded) {
                                clearTimeout(checkBookingStatus); // Clear any pending timeout
                                location.reload();

                                // Store isBooking Reloaded flag in local storage (persists across reloads)
                                localStorage.setItem('isBookingReloaded', 'true');
                            } else if (response.trim() === 'completed' && !isBookingCompleted) {
                                    Swal.fire(
                                        'Booking Completed',
                                        'You can now rate the driver.',
                                        'success'
                                    ).then(() => {
                                        clearTimeout(checkBookingStatus); // Clear any pending timeout
                                        location.reload();// Reload the page after confirmation

                                        // Store isBooking Reloaded flag in local storage (persists across reloads)
                                        localStorage.setItem('isBookingCompleted', 'true');
                                    });
                            } else if (response.trim() === 'cancelled' && !isBookingCancelled) {
                                    Swal.fire(
                                        'Booking Cancelled',
                                        'The driver decline your booking :(',
                                        'error'
                                    ).then(() => {
                                        clearTimeout(checkBookingStatus); // Clear any pending timeout
                                        window.location.href = "booking.php";// Reload the page after confirmation

                                        // Store isBooking Reloaded flag in local storage (persists across reloads)
                                        localStorage.setItem('isBookingCancelled', 'true');
                                    });
                            } else {
                                setTimeout(checkBookingStatus, 5000); // Schedule next check
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX error:', textStatus, errorThrown);
                            // Handle potential AJAX request errors (optional)
                        }
                    });
                }

                // Initial check when the page loads
                checkBookingStatus();

                // Optional: Clear local storage in specific scenarios (e.g., booking completion)
                // You can add an event listener or logic to clear localStorage.removeItem('isReloaded');
            });

            function cancelBookingPassenger() {
                Swal.fire({
                    title: 'Cancel Booking',
                    text: "Are you sure you want to cancel this booking?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Now, send the SOS with the retrieved address
                        $.ajax({
                            url: 'cancel-booking.php',
                            method: 'POST',
                            dataType: 'json', // Specify that the response is JSON
                            success: function(response) {
                                // Handle response from PHP script
                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Booking Cancelled!',
                                        'You can choose another driver in the booking module..',
                                        'success'
                                    ).then(() => {
                                        window.location.href = `booking.php`; // Reload the page after confirmation
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to cancelled booking. Please try again.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            }

            function sendSOS() {
                driver_id = "<?php echo $driver_id; ?>";
                Swal.fire({
                    title: 'SOS',
                    text: "Are you sure you want to send an SOS signal?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, send!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Inside the geolocation success callback
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                function(position) {
                                    const latitude = position.coords.latitude;
                                    const longitude = position.coords.longitude;

                                    const timestamp = new Date().getTime(); // Generate a unique timestamp

                                    const geocodingApiUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyDBXQ709mh8Hcuv3tZzU4vhUgG2isUPPPE&_=${timestamp}`;

                                    fetch(geocodingApiUrl)
                                        .then(response => response.json())
                                        .then(data => {
                                            const address = data.results[0].formatted_address;

                                            // Now, send the SOS with the retrieved address
                                            $.ajax({
                                                url: './tricycle/send-emergency.php',
                                                method: 'POST',
                                                data: {
                                                    driver_id: driver_id,
                                                    address: address
                                                },
                                                dataType: 'json', // Specify that the response is JSON
                                                success: function(response) {
                                                    // Handle response from PHP script
                                                    if (response.status === 'success') {
                                                        Swal.fire(
                                                            'SOS Signal Sent!',
                                                            'Emergency signal has been sent.',
                                                            'success'
                                                        );
                                                    } else {
                                                        Swal.fire(
                                                            'Error!',
                                                            'Failed to send SOS signal. Please try again.',
                                                            'error'
                                                        );
                                                    }
                                                }
                                            });
                                        })
                                        .catch(error => {
                                            console.log("Error occurred while retrieving location:", error);
                                        });
                                },
                                function(error) {
                                    console.log("Error occurred while retrieving coordinates:", error.message);
                                }
                            );
                        } else {
                            console.log("Geolocation is not supported by your browser");
                        }
                    }
                });
            }

            function updateUnreadCount() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("unreadCount").innerText = this.responseText;
                    }
                };
                xhttp.open("GET", "get_unread_count.php?booking_id=<?php echo $booking_id; ?>", true);
                xhttp.send();
            }

            // Call the function initially
            updateUnreadCount();

            // Update the count every X milliseconds (e.g., every 10 seconds)
            setInterval(updateUnreadCount, 5000); // Adjust the interval as needed

            function reportDriver() {
                driver_id = "<?php echo $driver_id ?? ""; ?>";
                Swal.fire({
                    title: 'Report',
                    html: `
                        <label>Choose a reason for reporting:</label><br>
                        <input type="radio" name="report-reason" value="Disrespectful" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"> Disrespectful<br>
                        <input type="radio" name="report-reason" value="Overcharge" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"> Overcharge<br>
                        <input type="radio" name="report-reason" value="Reckless Driving" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"> Reckless Driving<br>
                        <input type="radio" name="report-reason" value="Other" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"> Other: <input type="text" id="other-reason-input" class="swal2-input w-[82%]" placeholder="Specify other reason..."><br>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, report!',
                    preConfirm: () => {
                        const selectedReason = document.querySelector('input[name="report-reason"]:checked');
                        if (selectedReason && selectedReason.value === 'Other') {
                            return document.getElementById('other-reason-input').value;
                        } else if (selectedReason) {
                            return selectedReason.value;
                        }
                        return null; // If no reason selected
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const reportText = result.value;
                        $.ajax({
                            url: 'report-driver.php',
                            method: 'POST',
                            data: {
                                report: reportText,
                                driver_id: driver_id,
                            },
                            dataType: 'json', // Specify that the response is JSON
                            success: function(response) {
                                // Handle response from PHP script
                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Driver Reported!',
                                        'The driver has been reported to the admin.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to send report. Please try again.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });

                // Toggle display of other reason input based on radio button selection
                document.querySelectorAll('input[name="report-reason"]').forEach(function(input) {
                    input.addEventListener('change', function() {
                        const otherReasonInput = document.getElementById('other-reason-input');
                        if (this.value === 'Other') {
                            otherReasonInput.style.display = 'inline'; // Show the input box
                        } else {
                            otherReasonInput.style.display = 'none';  // Hide the input box
                        }
                    });
                });
            }
        </script>
    </div>
</body>
</html>
<?php
    unset($_SESSION["notif"]);
    unset($_SESSION["status-notif"]);
?>