<?php
    ob_start();
    session_start();
    include '../../database/connect.php';   

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'] ?? "";
    $sqlUser = mysqli_query($conn,"SELECT * FROM account WHERE unique_id = '$unique_id';");
    if(mysqli_num_rows($sqlUser) > 0){
        while($row = mysqli_fetch_assoc($sqlUser)){
            $getName = $row["fname"];
            $getPosition = $row["position"];
            $getType = $row["type"];
        }
    }

    $url = $_GET['driver_id'] ?? $_COOKIE['driver_id'];
    setcookie('driver_id', $url, time() + 60 * 60 * 24 * 30, '/'); // Expires in 30 days
    //CHECK IF ALREADY LOGIN
    if(!isset($_SESSION['login'])){
        // not logged in
        header('Location: ../../auth/login.php');
        exit();
    }else{
        if($getType=="admin" || $getType=="*" ||  $getType=="municipality") {
            header('Location: ../../admin.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="../images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../../dist/output.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Notifications & Modal -->
    <script src="../../dist/tata.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    <style>
        body {
            font-family: "Inter", sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
    <div class="max-w-screen-xl m-0 sm:m-20 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="mt-2 flex flex-col items-center">
                <div class="w-full flex-1 ">
                    <div class="flex justify-center p-5">
                        <img class="w-48" src="../../images/logo.png" alt="logo">
                    </div>
                    <h3 class="text-xl mb-6 font-bold text-center">Choose Action</h3>

                    <div class="mx-auto max-w-xs">
                        <form method="POST">
                            <!-- Driver -->
                            <a href="driver-info.php?driver_id=<?php echo $_COOKIE['driver_id']; ?>" class="mt-5 tracking-wide font-semibold bg-blue-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <span class="ml-3">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    View Driver
                                </span>
                            </a>

                            <!-- Passenger -->
                            <a href="#" class="mt-3 tracking-wide font-semibold bg-red-400 text-gray-100 w-full py-4 rounded-lg hover:bg-emergency-500 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none" onclick="sendSOS()">
                                <span class="ml-3">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        SOS
                                </span>
                            </a>
                            
                            <p class="mt-6 text-xs text-gray-600 text-center">
                                I agree to abide by Company
                                <a href="#" id="terms_modal" class="border-b border-gray-500 border-dotted">
                                Terms of Service
                                </a>
                                and its
                                <a href="#" id="privacy_modal" class="border-b border-gray-500 border-dotted">
                                Privacy Policy
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
            <div
            class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
            style="background-image: url('https://storage.googleapis.com/devitary-image-host.appspot.com/15848031292911696601-undraw_designer_life_w96d.svg');"
            ></div>
        </div>
    </div>
    
    <!-- IONICON -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        
        function sendSOS() {
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
                                            url: 'send-emergency.php',
                                            method: 'POST',
                                            data: {
                                                driver_id: '<?php echo $_COOKIE['driver_id']; ?>',
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
    </script>
</body>
</html>