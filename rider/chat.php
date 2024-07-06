<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 
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

    /*
    * GET Passenger ID
    */
    $passenger_id = $_GET['passenger_id'];
    $booking_id = $_GET['booking_id'];

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
    <title>Message</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="../images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../dist/output.css">
    <!-- Datatables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind Elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

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
<body class="bg-gray-50">
    <div>
        <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <a href="book-map.php?passenger_id=<?php echo $passenger_id; ?>&booking_id=<?php echo $booking_id; ?>" class="text-md font-bold text-white bg-blue-500 rounded-full px-4 py-1.5 hover:bg-blue-600">Back</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="flex pt-16" style="margin-bottom: 80px;"> <!-- Adjust the margin-bottom value as needed -->
            <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-12">
                <main class="p-5">
                    
                    <?php 
                        $getChat = "SELECT * FROM chats INNER JOIN account ON account.unique_id = chats.passenger_id WHERE booking_id = ? ORDER BY created_at ASC";
                        // Prepare statement
                        $stmt = $conn->prepare($getChat);
                        $stmt->bind_param("s", $booking_id);
                        $stmt->execute();

                        // Get results
                        $result = $stmt->get_result();
                        
                        // Check for results
                        if ($result->num_rows > 0) {
                            // Loop through results
                            while ($row = $result->fetch_assoc()) {
                                $chatName = $row['fname']. " " . $row['lname'];

                                $timeSent = $row['created_at'];
                                $message = $row['message'];       
                                
                                // Check if the message has been seen
                                $seenClass = ($row['seen'] == 1) ? 'message-seen' : '';  

                                if($row['sender'] === 'driver') {
                                    ?>
                                        <div class="flex items-end justify-end gap-2.5 mt-5">
                                            <div class="flex flex- gap-1 max-w-[250px]">
                                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400"><?php echo date('g:i a', strtotime($timeSent)); ?></span>
                                                <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-blue-300 rounded-tl-xl rounded-tr-xl rounded-bl-xl">
                                                    <p class="text-sm font-normal text-gray-90"><?php echo $message; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                } else if($row['sender'] === 'passenger') {
                                    ?>
                                        <div class="flex items-start gap-2.5 mt-5">
                                            <img class="w-8 h-8 rounded-full" src="https://cdn-icons-png.flaticon.com/512/147/147133.png" alt="Jese image">
                                            <div class="flex flex-col gap-1 w-full max-w-[320px]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo $chatName; ?></span>
                                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400"><?php echo date('g:i a', strtotime($timeSent)); ?></span>
                                                </div>
                                                <?php
                                                    $message_length = strlen($message);
                                                    $min_width = 80; // Minimum width for the div
                                                    $max_width = 250; // Maximum width for the div
                                                    $width = max($min_width, min($max_width, $message_length * 10)); // Adjust multiplier to control width
                                                ?>

                                                <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl" style="width: <?php echo $width; ?>px;">
                                                    <p class="text-sm font-normal text-gray-900"><?php echo $message; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                                

                                // Update 'seen' status in the database
                                if ($seenClass == '') {
                                    $updateSeen = "UPDATE chats SET seen = 1 WHERE booking_id = ? AND sender = 'passenger'";
                                    $stmtUpdateSeen = $conn->prepare($updateSeen);
                                    $stmtUpdateSeen->bind_param("i", $booking_id);
                                    $stmtUpdateSeen->execute();
                                }
                            }
                        }
                    ?>
                    
                </main>
            </div>
            
            <nav class="bg-white border-t border-gray-200 fixed z-30 w-full bottom-0">
                <div class="px-4 py-4 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start w-full">
                            <input type="text" id="message" placeholder="Type your message" class="w-full px-2 py-1 border border-gray-300 rounded-md mr-2">
                            <button onClick="sendMessage()" id="sendButton" class="bg-blue-500 text-white px-3 py-1 rounded-md"> <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </nav>

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
    <script src="../js/conditions.js"></script>

    <script>
        const messageInput = document.getElementById("message");
        const sendButton = document.getElementById("sendButton");

        messageInput.addEventListener("input", () => {
            if (messageInput.value.trim()) {
                sendButton.disabled = false;
            } else {
                sendButton.disabled = true;
            }
        });

        function sendMessage() {
            // Get the origin and destination values
            const message = document.getElementById("message").value;
            var booking_id  = "<?php echo $booking_id; ?>";
            var passenger_id  = "<?php echo $passenger_id; ?>";

            $.ajax({
                url: 'send-chat.php',
                method: 'POST',
                data: {
                    message: message,
                    booking_id: booking_id,
                    passenger_id: passenger_id,
                },
                dataType: 'json', // Specify that the response is JSON
                success: function(response) {
                    // Handle response from PHP script
                    if (response.status === 'success') {
                        window.location.reload();
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again.',
                            'error'
                        );
                    }
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