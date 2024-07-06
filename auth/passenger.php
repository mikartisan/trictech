<?php
    ob_start();
    session_start();
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    // For Notification
    $success = false;
    $error = false;
    $notif = "";

    //Validate Password
    $passValid = true;

    if(isset($_POST["submit"])) {

        // generate unique id
        function generateUniqueId($length = 16) {
            $characters = '0123456789abcdef';
            $uniqueId = '';
            
            for ($i = 0; $i < $length; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $uniqueId .= $characters[$index];
            }
            
            return $uniqueId;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // Database Connection.
            include '../database/connect.php';   
            
            $fname = $_POST["fname"]; 
            $lname = $_POST["lname"]; 
            $email = $_POST["email"];
            $contact = $_POST["contact"];
            $birthdate = $_POST["birthdate"];
            $password = $_POST["password"]; 
            $cpassword = $_POST["cpassword"];

            // Emergency Contacts
            $emName = $_POST["emer_name"];
            $emRelationship = $_POST["emer_relationship"];
            $emEmail = $_POST["emer_email"];
            $emContact = $_POST["emer_contact"];

            // SESSION
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['email'] = $email;
            $_SESSION['contact'] = $contact;
            $_SESSION['birthdate'] = $birthdate;
            $_SESSION['password'] = $password;
            $_SESSION['cpassword'] = $cpassword;

            if(!isset( $_POST["terms_conditions"])) {
                $error = true;
                $notif = "You must accept the terms and conditions to continue.";
            }else{
                $sql = "SELECT * FROM account WHERE email='$email'";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result); 
                
                // This sql query is use to check if
                // the username is already present 
                // or not in our Database
                if($num == 0) {
                    // Validate Email
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error = true;
                        $notif = "Email is not valid";
                    } else {

                        // Extract the domain from the email address
                        $domain = substr(strrchr($email, "@"), 1);

                        // Additional checks for the domain if needed
                        if (!checkdnsrr($domain, 'MX')) {
                            $error = true;
                            $notif = "Email domain is not valid";
                        } else {

                            //Validate Password
                            $uppercase = preg_match('@[A-Z]@', $password);
                            $lowercase = preg_match('@[a-z]@', $password);
                            $number    = preg_match('@[0-9]@', $password);
                            $specialChars = preg_match('@[^\w]@', $password);

                            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                                $error = true;
                                $notif = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
                            } else {
                                
                                // Confirm Password
                                if($password == $cpassword) {
                                    //Hash the password
                                    $hash = md5($password);
                                    $uniqueID = generateUniqueId();
                                    
                                    // Password Hashing is used here and saved the account to database
                                    $user = "INSERT INTO account (unique_id, fname, lname,  email, contact, birthdate, password, status, position, type, date) VALUES ('$uniqueID', '$fname', '$lname', '$email', '$contact', '$birthdate', '$hash', 'pending', 'Passenger', 'passenger', '$datetime')";
                                    $result = mysqli_query($conn, $user);
                                    if ($result) {

                                        // Save the unique ID to booking_verifaication
                                        $booking = "INSERT INTO booking_verification (verification_id, verification_status) VALUES ('$uniqueID', 'NO')";
                                        $result = mysqli_query($conn, $booking);
                                        if ($result) {

                                            $emergency = $conn->prepare("INSERT INTO emergency_contacts (unique_id, name, relationship, email, contact) VALUES (?, ?, ?, ?, ?)");
                                            $emergency->bind_param("ssssi", $uniqueID, $emName, $emRelationship, $emEmail, $emContact);

                                            if ($emergency->execute()) {
                                                header('location: pending-passenger.php');
                                                $code = rand(100000, 999999);

                                                // Sent verification email
                                                $subject = 'TricTech: Account Verification';
                                                $message = 'Your verification code is: ' . $code . PHP_EOL;
                                                $message .= 'Verify it through this link: https://sme.absierra.com/auth/verify.php?id=' . $uniqueID;
                                                $header = 'From: trictech@gmail.com';
                                                    
                                                if (mail($email, $subject, $message, $header)) {
                                                    // Send the code to db
                                                    $sql = "UPDATE account SET vercode='$code' WHERE email = '$email'";
                                                    mysqli_query($conn, $sql);  
                                                } else {
                                                    $error = true;
                                                    $notif = "Email could not be sent.";
                                                }
                                                
                                                //UNSET SESSION
                                                $_SESSION['fname'] = "";
                                                $_SESSION['lname'] = "";
                                                $_SESSION['email'] = "";
                                                $_SESSION['contact'] = "";
                                                $_SESSION['birthdate'] = "";
                                                $_SESSION['password'] = "";
                                                $_SESSION['cpassword'] = "";
                                                $_SESSION['emer_name'] = "";
                                                $_SESSION['emer_relationship'] = "";
                                                $_SESSION['emer_email'] = "";
                                                $_SESSION['emer_contact'] = "";

                                                // SMS SENDER
                                                // Put the SID here
                                                $send_data['sender_id'] = "PhilSMS";
                                                // Put the number or numbers here separated by comma w/ the country code +63
                                                $send_data['recipient'] = "+639813297245";
                                                // Put message content here
                                                $send_data['message'] = "Use verification code: ".  $code ." for TricTech authentication.\n\n";     
                                                $send_data['message'] .= 'Verify it through this link: https://sme.absierra.com/auth/verify.php?id=' . $uniqueID;

                                                // Put your API TOKEN here
                                                $token = "664|Rk2m2wLBqIDB7usOw3jmueZwuPkzmGi0LJIiPjKE";
                                                // END - Parameters to Change

                                                // No more parameters to change below.
                                                $parameters = json_encode($send_data);
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
                                                curl_setopt($ch, CURLOPT_POST, true);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                                $headers = [];
                                                $headers = array(
                                                    "Content-Type: application/json",
                                                    "Authorization: Bearer $token"
                                                );
                                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                                $get_sms_status = curl_exec($ch);

                                                curl_close($ch);
                                            } else {
                                                echo "Error: " . $user . "<br>" . mysqli_error($conn);
                                            }
                                        }
                                        
                                    }else{
                                        echo "Error: " . $user . "<br>" . mysqli_error($conn);
                                    }
                                } else { 
                                    $error = true;
                                    $notif = "Password not match!";
                                } 
                            }
                        }
                    }
                
                }else {
                    $error = true;
                    $notif = "Email not available"; 
                } 
            }
        }//end if  
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="../images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../dist/output.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Notifications & Modal -->
    <script src="../dist/tata.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .gradient {
                background-image: linear-gradient(-225deg, #cbbacc 20%, #2580b3 100%);
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
    <div class="max-w-screen-xl m-0 sm:m-20 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-4 sm:p-12">
            <div class="flex flex-col items-center">
                <div class="w-full flex-1 ">
                    <div class="flex justify-center p-5">
                        <img class="w-48" src="../images/logo.png" alt="logo">
                    </div>
                    <h3 class="text-2xl mb-6 font-bold text-center">Create your account</h3>

                    <div class="mx-auto max-w-xs">
                        <!-- Login Error -->
                        <?php
                            if($error  == true) {
                                ?> 
                                <div class="bg-orange-100 p-3 rounded-md">
                                    <p class="bg-orange-100 rounded-md text-red-500 text-sm"><?php echo $notif; ?></p>
                                </div>      
                                <?php
                            }else if($success  == true) {
                                ?> 
                                <div class="bg-green-100 p-3 rounded-md">
                                    <p class="rounded-md text-green-500 text-sm"><?php echo $notif; ?> <a href="login.php" class="text-green-500"><b> Login here</b></a></p>
                                </div>      
                                <?php
                            }

                        ?>

                        <form method="POST">
                            <!-- Name -->
                            <div class="flex items-center border-2 py-1 px-2 rounded-2xl mb-4 mt-4">
                                <ion-icon class="h-5 w-5 text-gray-400" name="person"></ion-icon>
                                <input name="fname" id="" class="pl-2 w-full outline-none border-none" type="text" placeholder="First Name" value="<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : ''; ?>" required />
                            </div>

                            <div class="flex items-center border-2 py-1 px-2 rounded-2xl mb-4 mt-4">
                                <ion-icon class="h-5 w-5 text-gray-400" name="person"></ion-icon>
                                <input name="lname" id="" class="pl-2 w-full outline-none border-none" type="text" placeholder="Last Name" value="<?php echo isset($_SESSION['lname']) ? $_SESSION['lname'] : ''; ?>" required />
                            </div>

                            <div class="flex items-center border-2 py-1 px-2 rounded-2xl mb-4 mt-4">
                                <i class="fa fa-birthday-cake h-5 w-5wwwtext-gray-400" aria-hidden="true"></i>
                                <input name="birthdate" id="" class="pl-2 w-full outline-none border-none" type="date" placeholder="Birthday" value="<?php echo isset($_SESSION['birthdate']) ? $_SESSION['birthdate'] : ''; ?>" required />
                            </div>

                            <!-- Email -->
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                                <input name="email" id="" class="pl-2 w-full outline-none border-none" type="text" placeholder="Email Address" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required />
                            </div>

                            <!-- Contact -->
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <ion-icon class="h-5 w-5 text-gray-400" name="call-outline"></ion-icon>
                                <input name="contact" id="" class="pl-2 w-full outline-none border-none" type="number" placeholder="Contact Number" value="<?php echo isset($_SESSION['contact']) ? $_SESSION['contact'] : ''; ?>" required />
                            </div>

                            <!-- Passowrd -->
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <input name="password" id="password1" class="pl-2 w-[85%] outline-none border-none" type="password" placeholder="Password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" required />
                                <button type="button" class="viewBtn" onclick="togglePassword()">
                                    <i class="icon fa fa-eye-slash text-gray-400" aria-hidden="true"></i>
                                </button>
                            </div>

                            <!-- Confirm Password -->
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <input name="cpassword" id="password2" class="pl-2 w-full outline-none border-none" type="password" placeholder="Password" value="<?php echo isset($_SESSION['cpassword']) ? $_SESSION['cpassword'] : ''; ?>" required />
                            </div>

                            <div>
                                <p class="block mb-2 text-md font-medium text-gray-90">Emergency Contacts</p>
                            </div>

                            <!-- Emergency Contact -->
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <ion-icon class="h-5 w-5 text-gray-400" name="person"></ion-icon>
                                <input name="emer_name" id="" class="pl-2 w-full outline-none border-none" type="text" placeholder="Family Name" value="<?php echo isset($_SESSION['emer_name']) ? $_SESSION['emer_name'] : ''; ?>" required />
                            </div>
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <ion-icon class="h-5 w-5 text-gray-400" name="heart-outline"></ion-icon>
                                <input name="emer_relationship" id="" class="pl-2 w-full outline-none border-none" type="text" placeholder="Relationsip e.g Mother" value="<?php echo isset($_SESSION['emer_relationship']) ? $_SESSION['emer_relationship'] : ''; ?>" required />
                            </div>
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                                <input name="emer_email" id="" class="pl-2 w-full outline-none border-none" type="text" placeholder="Email Address" value="<?php echo isset($_SESSION['emer_email']) ? $_SESSION['emer_email'] : ''; ?>" required />
                            </div>
                            <div class="flex items-center border-2 py-1 px-4 rounded-2xl mb-4">
                                <ion-icon class="h-5 w-5 text-gray-400" name="call-outline"></ion-icon>
                                <input name="emer_contact" id="" class="pl-2 w-full outline-none border-none" type="number" placeholder="Contact No." value="<?php echo isset($_SESSION['emer_contact']) ? $_SESSION['emer_contact'] : ''; ?>" required />
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="flex items-center">
                                <input name="terms_conditions" type="checkbox" class="w-4 h-4 ml-1" />
                                <span class="text-sm ml-2">I accept the <a href="#" id="terms_modal" class="text-blue-500">Terms and Conditions</a></span>
                            </div>

                            <button name="submit" type="submit" class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <svg
                                class="w-6 h-6 -ml-2"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                >
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <path d="M20 8v6M23 11h-6" />
                                </svg>
                                <span class="ml-3">
                                    Register
                                </span>
                            </button>
                            <p class="text-sm mt-3 cursor-pointer">Already have an account? <a href="login.php" class="text-blue-500">Login here</a></p>
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

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Terms, Condition and Policy -->
    <script src="../js/conditions.js"></script>

    <script>
        // Hide and Unhide Password
        function togglePassword() {
            var passwordInput1 = document.getElementById("password1"); 
            var passwordInput2 = document.getElementById("password2"); 
            var icon = document.querySelector(".viewBtn .icon");
            if (passwordInput1.type === "password") {
                passwordInput1.type = "text";
                passwordInput2.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput1.type = "password";
                passwordInput2.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>
</html>
<?php
    //UNSET SESSION
    $_SESSION['fname'] = "";
    $_SESSION['lname'] = "";
    $_SESSION['email'] = "";
    $_SESSION['password'] = "";
    $_SESSION['cpassword'] = "";
    $_SESSION['emer_name'] = "";
    $_SESSION['emer_relationship'] = "";
    $_SESSION['emer_email'] = "";
    $_SESSION['emer_contact'] = "";
?>