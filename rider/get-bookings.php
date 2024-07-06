<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 
    date_default_timezone_set('Asia/Manila');
    $datetime = date("Y-m-d H:i:s");

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    $getBooking = "SELECT booking.passenger_id, booking.booking_id, booking.passenger_type, booking.passenger_origin, booking.passenger_destination, booking.distance, booking.estimated_fare, booking.passenger_notes, account.fname, account.lname, account.profile_img FROM booking INNER JOIN account ON booking.passenger_id = account.unique_id WHERE driver_id = ? AND booking.status = ?";
    // Prepare statement
    $status = 'pending';
    $stmt = $conn->prepare($getBooking);
    // Bind driver ID to the query parameter
    $stmt->bind_param("ss", $unique_id, $status);
    // Execute the query
    $stmt->execute();
    // Get results
    $result = $stmt->get_result();
    
    // Check for results
    if ($result->num_rows > 0) {
        // Loop through results
        while ($row = $result->fetch_assoc()) {
            // Extract data from each row
            $passenger_id = $row['passenger_id'];
            $booking_id = $row['booking_id'];
            $name = $row['fname']. ' ' .$row['lname'];
            $origin = $row['passenger_origin'];
            $destination = $row['passenger_destination'];
            $distance = $row['distance'];
            $estimated_fare = $row['estimated_fare'];
            $notes = $row['passenger_notes'];
            $passenger_type = $row['passenger_type'];
            $getProfileImg = $row["profile_img"];

            ?>
            
            <article class="pt-6 pb-6 border-b border-gray-300">
                <div class="flex items-center mb-4">
                    <img class="w-14 h-14 rounded-full" src="../images/profile/<?php echo $getProfileImg ?? "profile.png"; ?>" alt="Rounded avatar">                          
                    <div class="font-medium dark:text-white">
                        <p class="ml-3"><?php echo $name;?> <time class="block text-sm text-gray-500 dark:text-gray-400">Passenger</p>
                    </div>
                </div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Origin :</span> <?php echo $origin; ?></p></div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Destination :</span> <?php echo $destination; ?></p></div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Total Distance :</span> <?php echo $distance; ?></p></div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Passenger Type : </span><?php echo $passenger_type; ?></p></div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Estimated Price : </span>₱<?php echo $estimated_fare. '' . " - ₱" . ($estimated_fare + 5); ?></p></div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Passenger Notes : </span><?php echo $notes; ?></p></div>
                <div class="flex justify-between mb-3 mt-5">
                <button type="button" onclick="acceptBooking()" class="text-md font-bold text-white bg-green-400 rounded-md px-5 py-3 w-[49%] hover:bg-green-500">
                    <i class="fa fa-check" aria-hidden="true"></i> Accept
                </button>

                    <button type="button" onclick="declineBooking()" class="text-md font-bold text-white bg-red-400 rounded-md px-5 py-3 w-[49%] hover:bg-red-500"><i class="fa fa-times" aria-hidden="true"></i> Decline</button>
                </div>
            </article>
        
            <?php
        }
    } else {
        // No ratings found
        echo "No available booking yet. Please wait...";
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
?>

<script>
    function acceptBooking() {
        var booking_id = "<?php echo $booking_id ?? ""; ?>";
        Swal.fire({
            title: 'Accept Booking',
            text: "Are you sure you want to accept this booking?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                // Now, send the SOS with the retrieved address
                $.ajax({
                    url: 'accept-booking.php',
                    method: 'POST',
                    dataType: 'json', // Specify that the response is JSON
                    success: function(response) {
                        // Handle response from PHP script
                        if (response.status === 'success') {
                            Swal.fire(
                                'Booking Accepted!',
                                'You can now go to your passenger pick-up location',
                                'success'
                            ).then(() => {
                                window.location.href = `book-map.php?passenger_id=<?php echo $passenger_id ?? " "; ?>` + "&booking_id=" + booking_id;// Reload the page after confirmation
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to accept booking. Please try again.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    }

    function declineBooking() {
        var booking_id = "<?php echo $booking_id ?? ""; ?>";

        Swal.fire({
            title: 'Decline Booking',
            text: "Are you sure you want to decline this booking?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            input: 'text', // Add input field
            inputAttributes: {
            autocapitalize: 'off' // Prevent auto-capitalization (optional)
            },
            inputPlaceholder: 'Enter reason for declining' // Set placeholder text
        }).then((result) => {
            if (result.isConfirmed) {
            const reason = result.value; // Get the input value (decline reason)

            // Only proceed if reason is provided
            if (reason) {
                $.ajax({
                    url: 'decline-booking.php',
                    method: 'POST',
                    data: {
                        booking_id: booking_id,
                        reason: reason
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Booking Declined!',
                                'You can choose another booking from the passenger.',
                                'success'
                            ).then(() => {
                                window.location.reload();// Reload the page after confirmation
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to decline booking. Please try again.',
                                'error'
                            );

                        }
                    }
                });
            } else {
                Swal.fire(
                    'Reason Required!',
                    'Please enter a reason for declining the booking.',
                    'warning'
                );
            }
            }
        });
        }

</script>