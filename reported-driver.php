<?php
    ob_start();
    session_start();
    include './database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getName = $row["fname"];
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

    //Get User Profile To View
    $approval_id = $_GET["account_id"] ?? "";
    $sqlApproval = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$approval_id';");
    if(mysqli_num_rows($sqlApproval) > 0){
        while($row = mysqli_fetch_assoc($sqlApproval)){
            $getId = $row["id"];
            $getFirstName = $row["fname"];
            $getLastName = $row["lname"];
            // $getUserType = $row["passenger_type"];
            $getEmail = $row["email"];
            $getContact = $row["contact"];
            $getBirth = $row["birthdate"];
            $getAddress = $row["address"];
            $getDate = $row["date"];
            $getProfileImg = $row["profile_img"];
        }
    }
    
    // For Notification
    $notif = $_SESSION["notif"] ?? ""; //For Session Notification

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Identification</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="./images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="dist/output.css">
    <!-- Datatables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind Elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

    <!-- Notification and Modal -->
    <script src="./dist/tata.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- flowbite -->
    <script src="./dist/flowbite.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js" type="text/javascript"></script>

    <style>    
    #data-table-basic_wrapper .dataTable, #data-table-basic_wrapper .dataTables_scrollHeadInner {
        width: 100% !important;
    }
</style>
</head>
<body>
    <div>
        <!-- Toast Notifications -->
        <?php
            if(!empty($notif) && $notif != "false") {
                ?> <script type="text/javascript">tata.success('SUCCESS', '<?php echo $notif; ?>', {position: 'tr', duration: 5000})</script> <?php
            } else if(!empty($notif) && $notif == "false") {
                ?> <script type="text/javascript">tata.error('ERROR', 'Something went wrong!', {position: 'tr', duration: 5000})</script> <?php
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
                        <a href="index.php" class="text-xl font-bold flex items-center p-2 lg:ml-2.5">
                            <img class="w-20 lg:w-28" src="./images/logo.png" alt="logo">
                        </a>
                        <!-- <form action="#" method="GET" class="hidden lg:block lg:pl-32">
                            <label for="topbar-search" class="sr-only">Search</label>
                            <div class="mt-1 relative lg:w-64">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full pl-10 p-2.5" placeholder="Search">
                            </div>
                        </form> -->
                    </div>
                    <div class="flex items-center">
                        <button id="toggleSidebarMobileSearch" type="button" class="lg:hidden text-gray-500 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-lg">
                            <!-- <span class="sr-only">Search</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg> -->
                        </button>
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
                                    <span class="block text-sm text-gray-900 dark:text-white"><b>Hello, <?php echo ucwords($getName); ?></b></span>
                                    <!-- <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">jmdeocampo@gmail.com</span> -->
                                </div>
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                                    <li>
                                        <a href="profile.php" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                                    </li>
                                    <li>
                                        <a href="./auth/logout.php" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
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
                                
                                <!-- Dashboard -->
                                <li>
                                    <a href="admin.php" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <i class="text-xl text-gray-500 flex-shrink-0 transition duration-75 fa fa-pie-chart" aria-hidden="true"></i>
                                    <span class="ml-3">Dashboard</span>
                                    </a>
                                </li>

                                <!-- Operator -->
                                <?php if ($getType === 'admin') : ?>
                                    <li>
                                        <a href="operator.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group">
                                            <i class="fa fa-male text-xl text-gray-500 flex-shrink-0 transition duration-75" aria-hidden="true"></i>
                                            <span class="ml-3 flex-1 whitespace-nowrap">Add Operator</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                

                                <!-- Fare Matrix -->
                                <?php if($getType === 'municipality') : ?>
                                    <li>
                                        <a href="fare-matrix.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                        <i class="fa fa-map text-xl text-gray-500 flex-shrink-0 transition duration-75" aria-hidden="true"></i>
                                        <span class="ml-3 flex-1 whitespace-nowrap">Fare Matrix</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- Fare Matrix -->
                                <?php if($getType === 'admin') : ?>
                                    <li>
                                        <a href="view/fare-matrix.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                        <i class="fa fa-map text-xl text-gray-500 flex-shrink-0 transition duration-75" aria-hidden="true"></i>
                                        <span class="ml-3 flex-1 whitespace-nowrap">Fare Matrix</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- User -->
                                <?php if($getType === 'admin') : ?>
                                    <a href="user.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-users textdrF\ -xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Users</span>
                                    </a>
                                <?php endif; ?>

                                <!-- Suspend Account -->
                                <?php if($getType === 'municipality') : ?>
                                    <li>
                                        <a href="suspend.php" class="text-base text-gray-900 font-normal rounded-lg bg-gray-100 flex items-center p-2 group ">
                                        <i class="fa fa-users text-xl text-blue-600 flex-shrink-0 transition duration-75" aria-hidden="true"></i>
                                        <span class="ml-3 flex-1 text-blue-600 whitespace-nowrap">Suspend Accounts</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- Top Performers -->
                                <li>
                                    <a href="top-performer.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-trophy text-xl text-gray-500 flex-shrink-0 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Top Performers</span>
                                    </a>
                                </li>

                                <!-- Account Approval -->
                                <li>
                                    <a href="verification-list.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-address-card text-xl text-gray-500 flex-shrink-0 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Account Verification
                                        <span class="bg-blue-200 px-1 rounded-md">
                                            <?php
                                                $totApproval = "SELECT * FROM booking_verification WHERE verification_status = 'pending'";

                                                if ($result = mysqli_query($conn, $totApproval)) {
                                                    // Return the number of rows in result set
                                                    $rowcount = mysqli_num_rows( $result );
                                                    
                                                    // Display result
                                                    echo $rowcount;
                                                }
                                            ?> 
                                        </span>
                                    </span>
                                    </a>
                                </li>

                                <!-- Logout -->
                                <div class="lg:hidden">
                                    <li>
                                        <a href="./auth/logout.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                        <i class="fa fa-sign-out text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                        <span class="ml-3 flex-1 whitespace-nowrap">Sign out</span>
                                        </a>
                                    </li>
                                </div>
                            </ul>
                            <div class="space-y-2 pt-2">
                                <!-- Activity Log -->
                                <a href="logs.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                                    <i class="fa fa-clock  text-base text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" name="settings-outline"></i>
                                    <span class="ml-3">Activity Log</span>
                                </a>

                                <!-- User -->
                                <?php if($getType === 'admin') : ?>
                                    <a href="user.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <i class="fa fa-users text-xl text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true"></i>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Users</span>
                                    </a>
                                <?php endif; ?>
                                
                                <a href="setting.php" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
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
            <div class=" opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
                <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
                <main>
                    <div class="">
                        <div class="container mx-auto py-8">
                            <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 md:px-4">
                                <div class="col-span-4 sm:col-span-3">
                                    <div class="bg-white shadow rounded-lg p-6 pb-9 w-full">
                                        <div class="flex flex-col items-center">
                                            <img class="w-32 h-32 mb-2 rounded-full" src="images/profile/<?php echo $getProfileImg ?? "profile.png"; ?>" alt="Rounded avatar">                                                     
                                            <h1 class="text-xl font-bold"><?php echo $getFirstName ." ". $getLastName; ?></h1>
                                            <p class="text-gray-700">User Account</p>
                                            <div class="mt-6 flex flex-wrap gap-1 justify-center">
                                                <!-- <a href="suspend.php"" class="bg-red-400 hover:bg-red-500 text-white py-2 px-4 rounded">Back</a> -->
                                                <button onclick="suspendAccount(<?php echo $getId; ?>, '<?php echo $getEmail; ?>')" type="button" class="bg-red-400 hover:bg-red-400 text-white py-2 px-6 rounded">Suspend</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-4 sm:col-span-9">
                                    <div class="bg-white shadow rounded-lg p-6">
                                            <div class="flex items-center space-x-2 mb-5 font-bold text-gray-700 leading-8">
                                                <span class="text-gray-500">
                                                    <i class="fa fa-user h-5" aria-hidden="true"></i>
                                                </span>
                                                <span class="tracking-wide">About</span>
                                            </div>
                                            <div class="text-gray-700">
                                                <div class="grid md:grid-cols-2 text-sm">
                                                    <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">First Name</div>
                                                        <div class="px-4 py-2"><?php echo $getFirstName; ?></div>
                                                    </div>
                                                    <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">Last Name</div>
                                                        <div class="px-4 py-2"><?php echo $getLastName; ?></div>
                                                    </div>
                                                    <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">Gender</div>
                                                        <div class="px-4 py-2">Male</div>
                                                    </div>
                                                    <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">Contact No.</div>
                                                        <div class="px-4 py-2">+63 <?php echo $getContact; ?></div>
                                                    </div>
                                                    <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">Current Address</div>
                                                        <div class="px-4 py-2"><?php echo $getAddress; ?></div>
                                                    </div>
                                                    <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">Email</div>
                                                        <div class="px-4 py-2">
                                                            <a class="text-blue-800" href="mailto:jane@example.com"><?php echo $getEmail;  ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">Birthday</div>
                                                        <div class="px-4 py-2"><?php echo date("F d, Y", strtotime($getBirth)); ?></div>
                                                    </div>
                                                    <!-- <div class="grid grid-cols-2">
                                                        <div class="px-4 py-2 font-bold">Passenger Type</div>
                                                        <div class="px-4 py-2"><?php echo $getUserType; ?></div>
                                                    </div> -->
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2 mt-9 mb-5 font-bold text-gray-700 leading-8">
                                                <span class="text-gray-500">
                                                    <i class="fa fa-id-card h-5" aria-hidden="true"></i>
                                                </span>
                                                <span class="tracking-wide">Reports</span>
                                            </div>

                                            <div>
                                            <table id="table_reports" class="display" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="py-3 px-6">Name</th>
                                                            <th scope="col" class="py-3 px-6">Email</th>
                                                            <th scope="col" class="py-3 px-6">Contact</th>
                                                            <th scope="col" class="py-3 px-6">Reason</th>
                                                            <th scope="col" class="py-3 px-6">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php 
                                                            // //Display all account of rider and passenger
                                                            $sql = mysqli_query($conn, "SELECT * FROM reports WHERE report_by = 'passenger' AND driver_id = '$approval_id'");
                                                            if(mysqli_num_rows($sql) > 0){
                                                                while($row = mysqli_fetch_assoc($sql)){
                                                                    extract($row);

                                                                    //Get User Profile To View
                                                                    $sqlApproval = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$passenger_id';");
                                                                    if(mysqli_num_rows($sqlApproval) > 0){
                                                                        while($row = mysqli_fetch_assoc($sqlApproval)){
                                                                            $getPassFirstName = $row["fname"];
                                                                            $getPassLastName = $row["lname"];
                                                                            $getPassEmail = $row["email"];
                                                                            $getPassContact = $row["contact"];
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td scope="row"><b><?php echo $getPassFirstName. " " . $getPassLastName; ?></b></td>
                                                                        <td scope="row"><?php echo $getPassEmail; ?></td>
                                                                        <td scope="row"><?php echo $getPassContact; ?></td>
                                                                        <td scope="row"><?php echo $reason; ?></td>
                                                                        <td scope="row"><?php echo $created_at; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </div>
                            </div>
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
                    &copy; <?php echo date('Y'); ?> <a href="#" class="hover:underline" >TricTech</a>. All rights reserved.
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
        <script src="./js/conditions.js"></script>

        <script>
            $(document).ready(function () {
                $('#table_reports').DataTable({
                    scrollY: '500px',
                    scrollCollapse: true,
                    paging: true,
                });
            });

            function suspendAccount(id, email) {
                Swal.fire({
                    title: 'Suspend',
                    html: '<label for="reason">Are you sure you want to suspend this account? Enter a reason:</label><br>' +
                        '<textarea id="reason" class="swal2-textarea" style="width: 85%;" placeholder="Enter reason for suspension"></textarea>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, suspend!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var reason = $('#reason').val(); // Get the reason entered by the user
                        
                        // Now, send the SOS with the retrieved address
                        $.ajax({
                            url: 'suspend-account.php',
                            method: 'POST',
                            data: { 
                                id: id,
                                email: email,
                                reason: reason // Pass the reason to the server
                            },
                            dataType: 'json', // Specify that the response is JSON
                            success: function(response) {
                                // Handle response from PHP script
                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Suspend Account',
                                        'Account Suspended!',
                                        'success'
                                    ).then(() => {
                                        window.location.href = `suspend.php`; // Reload the page after confirmation
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to suspend account. Please try again.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            }
        </script>
    </div>
</body>
</html>
<?php
    unset($_SESSION["notif"]);
    unset($_SESSION["er-email"]);
    mysqli_close($conn);
?>