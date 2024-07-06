<?php
    ob_start();
    session_start();
    // Database Connection.
    include '../database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    // For Notification
    $success = false;
    $error = false;
    $notif = "";

    //Validate Password
    $passValid = true;

    if(isset($_POST["submit"])) {

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

            $fname = $_POST["fname"]; 
            $lname = $_POST["lname"]; 
            $email = $_POST["email"]; 
            $contact_number = $_POST["contact_number"]; 
            $birthdate = $_POST["birthdate"]; 
            $lisence = $_POST["lisence"]; 
            $password = $_POST["password"]; 
            $cpassword = $_POST["cpassword"];
            $operator_id = $_POST["operator_id"] ?? "";  
            $address = $_POST["street"] .', '. $_POST["barangay"] .', '. $_POST["municipality"] .', '. $_POST["province"]; 

            // SESSION
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['email'] = $email;
            $_SESSION['contact_number'] = $contact_number;
            $_SESSION['birthdate'] = $birthdate;
            $_SESSION['street'] = $_POST["street"];
            $_SESSION['lisence'] = $lisence;
            $_SESSION['barangay'] = $_POST["barangay"];
            $_SESSION['municipality'] = $_POST["municipality"];
            $_SESSION['province'] = $_POST["province"];
            $_SESSION['password'] = $password;
            $_SESSION['cpassword'] = $cpassword;

            if(!isset($_POST["operator_id"])) {
                $error = true;
                $notif = "Please select your operator";
            } else {
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
                                        $user = "INSERT INTO account (unique_id, fname, lname,  email, contact, address, birthdate, password, status, position, type, date) VALUES ('$uniqueID', '$fname', '$lname', '$email', '$contact_number', '$address', '$birthdate', '$hash', 'pending', 'Rider', 'rider', '$datetime')";
                                        $result = mysqli_query($conn, $user);
                                        if ($result) {
    
                                            /**
                                             * Add the driver to the operator
                                             */
                                            $operator = "INSERT INTO operator_drivers (operator_id, driver_id, lisence_number, created_at) VALUES ('$operator_id', '$uniqueID', '$lisence', '$datetime')";
                                            $result = mysqli_query($conn, $operator);
                                            if ($result) {
                                                header('location: pending-driver.php');
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
                    
                    //Email already registered
                    }else if($num>0) {
                        $error = true;
                        $notif = "Email not available"; 
                    } 
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
    <title>Driver Registration</title>

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
    <form method="POST" class="form bg-white p-6 my-10 relative">
                
        <h3 class="text-2xl text-gray-900 font-semibold">Create Driver Account</h3>
        <p class="text-gray-600"> To help you choose your property</p>

        <!-- Login Error -->
        <?php
            if($error  == true) {
                ?> 
                <div class="bg-orange-100 p-3 mt-5 rounded-md">
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

        <select name="operator_id" class="bg-white rounded-2xl border-gray-200 border-2  p-2 mt-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option disabled selected>Choose your operator</option>
            <?php
                // Fetch data from the database
                $sql = "SELECT unique_id, fname, lname FROM account WHERE type='operator'";
                $result = $conn->query($sql);
                // Loop through the database results and generate options
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['unique_id'] . '">' . $row['fname'] .' ' . $row['lname']  . '</option>';
                }
            ?>
        </select>

        <div class="flex space-x-5 mt-3">
            <input type="text" name="fname" id="" placeholder="First Name" class="rounded-2xl border-gray-200 border-2 w-1/2 mr-2" value="<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : ''; ?>" required>
            <input type="text" name="lname" id="" placeholder="Last Name" class="rounded-2xl border-gray-200 border-2 w-1/2" value="<?php echo isset($_SESSION['lname']) ? $_SESSION['lname'] : ''; ?>" required>
        </div>
        
        <input type="email" name="email" id="" placeholder="Your Email" class="rounded-2xl border-gray-200 border-2 w-full mt-3" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
        <input type="number" name="contact_number" id="" placeholder="Contact No." class="rounded-2xl border-gray-200 border-2 w-full mt-3" value="<?php echo isset($_SESSION['contact_number']) ? $_SESSION['contact_number'] : ''; ?>" required>

        <div class="flex space-x-5 mt-3">
            <input type="date" name="birthdate" id="" placeholder="Birthdate" class="rounded-2xl border-gray-200 border-2 w-1/2 mr-2" value="<?php echo isset($_SESSION['birthdate']) ? $_SESSION['birthdate'] : ''; ?>" required>
            <input type="text" name="lisence" id="" placeholder="Lisence No." class="rounded-2xl border-gray-200 border-2 w-1/2" onkeyup="autoCapsLock(this)" value="<?php echo isset($_SESSION['lisence']) ? $_SESSION['lisence'] : ''; ?>" required>
        </div>

        <input type="text" name="street" id="" placeholder="Street" class="rounded-2xl border-gray-200 border-2 w-full mt-3" value="<?php echo isset($_SESSION['street']) ? $_SESSION['street'] : ''; ?>" required>
        <input type="text" name="barangay" id="" placeholder="Barangay" class="rounded-2xl border-gray-200 border-2 w-full mt-3" value="<?php echo isset($_SESSION['barangay']) ? $_SESSION['barangay'] : ''; ?>" required>
        
        <div class="flex space-x-5 mt-3">
            <input type="text" name="municipality" id="" placeholder="Municipality" class="rounded-2xl border-gray-200 border-2 w-1/2 mr-2" value="<?php echo isset($_SESSION['municipality']) ? $_SESSION['municipality'] : ''; ?>" required>
            <input type="text" name="province" id="" placeholder="Province" class="rounded-2xl border-gray-200 border-2 w-1/2" value="<?php echo isset($_SESSION['province']) ? $_SESSION['province'] : ''; ?>" required>
        </div>

        <div class="flex space-x-5 mt-3">
            <input type="password" name="password" id="" placeholder="Password" class="rounded-2xl border-gray-200 border-2 w-1/2 mr-2" required>
            <input type="password" name="cpassword" id="" placeholder="Confirm Password" class="rounded-2xl border-gray-200 border-2 w-1/2" required>
        </div>

        <p class="font-bold text-sm mt-3">TriTech Agreement *</p>
        <div class="flex items-baseline space-x-2 mt-2">
            <input type="checkbox" name="terms_conditions" id="" class="inline-block">
            <p class="text-gray-600 text-sm"><span class="text-sm">I accept the <a href="#" id="terms_modal" class="text-blue-500">Terms and Conditions</a></span></p>
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

        function autoCapsLock(input) {
            input.value = input.value.toUpperCase();
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
?>