<?php
    ob_start();
    session_start();
    include '../../database/connect.php';   

    // For Notification
    $success = false;
    $error = false;
    $notif = "";

    if(isset($_POST["submit"])) {
        if(empty($_POST['email']) || empty($_POST['password'])) {
            $error = true;
            $notif = "Input field cannot be empty!";
        }else{
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Create a md5 hash of the password
            $hash = md5($password);

            $stmt = mysqli_query($conn,"SELECT * FROM account WHERE password='$hash' AND email='$email' OR contact='$email'");
            $auth = mysqli_fetch_array($stmt);

            if($auth){
                $pending = "SELECT * FROM account WHERE status = 'pending' AND email='$email' OR contact='$email' ";
                $result = $conn->query($pending); 
                if ($result->num_rows > 0) {
                    header('Location: pending-account.php');
                } else {
                    // Account Approved
                    $_SESSION['login'] = "login";
                    $_SESSION['user'] = "$email";
                    
                    // Retrieve unique_id from database
                    $unique_id_query = "SELECT unique_id FROM account WHERE email='$email' OR contact='$email'";
                    $unique_id_result = $conn->query($unique_id_query);
                    $row = $unique_id_result->fetch_assoc();
                    $unique_id = $row['unique_id'];

                    // Add unique_id to session
                    $_SESSION['unique_id'] = $unique_id;

                    header('Location: action.php');
                    die();
                }
                
            }else{
                // login failed
                $error = true;
                $notif = "Invalid username or password.";
                $_SESSION['er-email'] = $email; // display the email if incorrect email/pass
            }
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
                    <div class="flex justify-center p-5">
                        <img class="w-48" src="../../images/logo.png" alt="logo">
                    </div>
                    <h3 class="text-2xl mb-6 font-bold text-center">Login to your account</h3>

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
                            <div class="flex items-center border-2 py-1 px-2 rounded-2xl mb-4 mt-4">
                                <ion-icon class="h-5 w-6 text-gray-400" name="at-outline"></ion-icon>
                                <input name="email" value="<?php echo isset($_SESSION['er-email']) ? $_SESSION['er-email'] : ''; ?>" class="pl-2 w-full outline-none border-none" type="text" autocomplete="off" placeholder="Email / Contact No." />
                            </div>

                            <div class="flex items-center border-2 py-1 px-2 rounded-2xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <input name="password" class="pl-2 w-[85%] outline-none border-none" type="password" id="password" placeholder="Password" />
                                <button type="button" class="viewBtn" onclick="togglePassword()">
                                    <i class="icon fa fa-eye-slash text-gray-400" aria-hidden="true"></i>
                                </button>
                            </div>
                            <a href="find-account.php" class="text-blue-500 text-sm text-right">Forget password?</a>
                            <button name="submit" type="submit" class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <span class="ml-3">
                                Log in
                                </span>
                            </button>
                            <p class="text-sm mt-3 cursor-pointer">Don't have an account? <a href="../../auth/account-type.php" class="text-blue-500">Register</a></p>

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