<?php
    ob_start();
    session_start();
    include '../database/connect.php';   

    // For Notification
    $success = false;
    $error = false;
    $notif = "";

    if(isset($_POST["code"])) {
        $code = $_POST['code'];
        $id = $_GET['id'];
        $reset = NULL;
        
        $stmt = mysqli_query($conn,"SELECT * FROM account WHERE vercode='$code' AND unique_id = '$id'");
        $auth = mysqli_fetch_array($stmt);

        if($auth){ 
            $sql = "UPDATE account SET status='activated', vercode='$reset' WHERE unique_id = '$id'";
            mysqli_query($conn, $sql);  
    
            // Check the result
            if (mysqli_affected_rows($conn) > 0) {
                header("location: verify-success.php");
            } else {
                $error = true;
                $notif = "Something went wrong. Please try again.";
            }
        }else {
            $error = true;
            $notif = "The number you entered doesn’t match your code. Please try again.";
        }
    }
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
            <div class="mt-2 flex flex-col items-center">
                <div class="w-full flex-1 ">
                    <div class="flex justify-center">
                        <ion-icon class="h-20 w-20 text-blue-400" name="lock-closed-outline"></ion-icon>
                    </div>
                    <h3 class="text-2xl mt-3 font-bold text-center">Verify your account</h3>

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
                            <p class="mt-3 text-sm text-black text-center">
                                Please check your email for a message with your code. Your code is 6 numbers long.
                            </p>
                            <div class="flex items-center border-2 py-1 px-2 rounded-2xl mb-4 mt-4">
                                <ion-icon class="h-5 w-6 text-gray-400" name="key-outline"></ion-icon>
                                <input name="code" class="pl-2 w-full outline-none border-none" type="number" autocomplete="off" placeholder="Enter Code" />
                            </div>

                            <button name="submit" type="submit" class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <span class="ml-3">
                                    Verify
                                </span>
                            </button>
                            <p class="text-sm mt-3 cursor-pointer">Don't have an account? <a href="account-type.php" class="text-blue-500">Register</a></p>

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

    <script>
        // Hide and Unhide Password
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var icon = document.querySelector(".viewBtn .icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }

        // Cancel form resubmission on page refresh
        if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
    </script>
    
    <!-- IONICON -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Terms, Condition and Policy -->
    <script src="../js/conditions.js"></script>
</body>
</html>