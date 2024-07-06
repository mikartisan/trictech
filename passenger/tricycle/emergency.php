<?php
    ob_start();
    session_start();
    include '../../database/connect.php'; 
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
            $getDate = $row["date"];
        }
    }

    $location = $_GET['location'];

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
    <title>Emergency</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="../images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../../dist/output.css">
    <!-- Datatables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind Elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

    <!-- Notification and Modal -->
    <script src="../../dist/tata.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- flowbite -->
    <script src="../../dist/flowbite.js"></script>

    <style>    
    #data-table-basic_wrapper .dataTable, #data-table-basic_wrapper .dataTables_scrollHeadInner {
        width: 100% !important;
    }
</style>
</head>
<body class="bg-gray-50">
    <?php
         //Get Current Driver
        $driverID = $_GET["driver_id"] ?? "";
        $sqlDriver = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$driverID';");
        if(mysqli_num_rows($sqlDriver) > 0){
            while($row = mysqli_fetch_assoc($sqlDriver)){
                $getDrivFName = $row["fname"];
                $getDrivLName = $row["lname"];
                $getDrivEmail = $row["email"];
                $getDrivContact = $row["contact"];
                $getDrivBirth = $row["birthdate"];
                $getDrivAddress = $row["address"];
                $getProfileImg = $row['profile_img'];
            }
        }

        //Get Current Passenger
        $passengerID = $_GET["passenger_id"] ?? "";
        $sqlPassenger = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$passengerID';");
        if(mysqli_num_rows($sqlPassenger) > 0){
            while($row = mysqli_fetch_assoc($sqlPassenger)){
                $getPassName = $row['fname'] .' '. $row['lname'];
                $getPassContact = $row["contact"];
            }
        }
    ?>
    <div>
        <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <a href="#" class="text-xl font-bold flex items-center p-2 lg:ml-2.5">
                            <img class="w-20 lg:w-28" src="../../images/logo.png" alt="logo">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="flex pt-16">
            <div id="main-content" class="h-full w-[95%] bg-gray-50 relative overflow-y-auto lg:ml-12">
                <main>
                    <div class="pt-6 px-4">
                        <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
                            <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                                <div class="mb-1 flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Driver Information</h3>
                                        <span class="text-base font-normal text-gray-500">Check the information and location here.</span>
                                    </div>
                                </div>
                                <div class="flex flex-col mt-2">
                                    <div class="overflow-x-auto rounded-lg">
                                        <div class="w-full h-1/2 p-8 flex justify-center">
                                            <img class="w-32 h-32 rounded-full" src="../../images/profile/<?php echo $getProfileImg ?? "profile.png"; ?>" alt="Rounded avatar">                                                   
                                        </div>
                                        <div class="justify-center text-center">
                                            <p class="text-2xl font-semibold block"><?php echo $getDrivFName ." ". $getDrivLName; ?></>
                                            <h3 class="text-gray-600">Driver</h3>
                                        </div>
                                        <div class="mb-4 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full p-6 mt-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                                            <p class="block text-gray-700 text-base mb-3"><span class="font-bold">Email : </span><?php echo $getDrivEmail; ?></p>
                                            <p class="block text-gray-700 text-base mb-3"><span class="font-bold">Contact No. : </span><?php echo $getDrivContact; ?></p>
                                            <p class="block text-gray-700 text-base mb-3"><span class="font-bold">Address : </span><?php echo $getDrivAddress; ?></p>
                                            <p class="block text-gray-700 text-base mb-3"><span class="font-bold">Age : </span><?php echo $age = date_diff(date_create($getDrivBirth), date_create('today'))->y;?></p>
                                        </div>
                                        <div class="mb-4 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full p-6 mt-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                                            <p class="block text-gray-700 text-base mb-3"><span class="font-bold">Passenger  : </span><?php echo $getPassName; ?></p>
                                            <p class="block text-gray-700 text-base mb-3"><span class="font-bold">Contact No. : </span><?php echo $getPassContact; ?></p>
                                            <p class="block text-gray-700 text-base mb-3"><span class="font-bold">Current Location : </span><?php echo $_GET['location']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Map -->
                            <div id="googleMap" class="bg-white shadow rounded-lg min-h-[500px] p-4 sm:p-6 xl:p-8  2xl:col-span-2">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white md:flex md:items-center md:justify-between shadow rounded-lg p-4 md:p-6 xl:p-8 my-6 mx-4">
                        <ul class="flex items-center flex-wrap mb-6 md:mb-0">
                            <li><a id="terms_modal" href="#" class="text-sm font-bold text-gray-500 hover:underline mr-4 md:mr-6">BATAAN EMERGENCY HOTLINES </a></li>
                            <li><a id="terms_modal" href="#" class="text-sm font-bold text-blue-500 hover:underline mr-4 md:mr-6">DIAL : 911</a></li>
                            <li><a id="privacy_modal" href="#" class="text-sm font-bold text-blue-500 hover:underline mr-4 md:mr-6">LANDLINE : (047) 613-8888</a></li>
                            <li><a id="privacy_modal" href="#" class="text-sm font-bold text-blue-500 hover:underline mr-4 md:mr-6">SMART : 0919-9146232</a></li>
                            <li><a id="privacy_modal" href="#" class="text-sm font-bold text-blue-500 hover:underline mr-4 md:mr-6">GLOBE : 0927-6056991</a></li>
                        </ul>
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
    </div>

    <!-- IONIC_ICONS -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- JQuery/DataTables JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Tailwind Elements -->
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
    <!-- Terms, Condition and Policy -->
    <script src="../../js/conditions.js"></script>

    <!-- Google Map -->
    <script src="../../js/emergency-map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBXQ709mh8Hcuv3tZzU4vhUgG2isUPPPE&libraries=places&callback=initMap" async defer></script>
    <script>
        var current_location = '<?php echo $location; ?>';

        var map;
        var geocoder;

        function initMap() {
            geocoder = new google.maps.Geocoder();
            // Decode the Plus Code and set the map
            decodePlusCode(current_location);
        }

        function decodePlusCode(plusCode) {
            geocoder.geocode({ 'address': plusCode }, function (results, status) {
                if (status == 'OK') {
                    var location = results[0].geometry.location;

                    // Set the initial center of the map based on the decoded location
                    map = new google.maps.Map(document.getElementById('googleMap'), {
                        center: location,
                        zoom: 13,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    // Add a marker at the decoded location
                    var marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });

                    console.log(location);
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>
</body>
</html>
<?php
    unset($_SESSION["notif"]);
    unset($_SESSION["status-notif"]);
?>