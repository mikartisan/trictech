<?php
    ob_start();
    session_start();
    include '../database/connect.php';   

    // For Notification
    $success = false;
    $error = false;
    $notif = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Routing System</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="../images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../dist/output.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Notifications & Modal -->
    <script src="../dist/tata.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Inter", sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
    <div class="max-w-screen-xl m-0 sm:m-20 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="mt-5 flex flex-col items-center">
                <div class="w-full flex-1">
                    <div class="flex justify-center">
                        <ion-icon class="h-20 w-20 text-blue-400" name="mail-outline"></ion-icon>
                    </div>
                    <h3 class="text-2xl mb-2 mt-3 font-bold text-center">Success</h3>

                    <div class="mx-auto max-w-xs">
                        <!-- Login Error -->
                        <?php
                            if($error  == true) {
                                ?> 
                                <div class="bg-orange-100 p-3 rounded-md">
                                    <p class="bg-orange-100 rounded-md text-red-500 text-sm"><?php echo $notif; ?></p>
                                </div>      
                                <?php
                            }
                        ?>

                        <form method="POST">
                            <p class="text-lg mt-1 text-center">Your account is now verified. You can log in to your account.<a href="login.php" class="text-blue-500">  Login here</a></p>
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

    <!-- Terms, Condition and Policy -->
    <script src="../js/conditions.js"></script>
</body>
</html>