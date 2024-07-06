<?php
    ob_start();
    session_start();
    include '../database/connect.php'; 

    //Get Current User
    $getUser = $_SESSION['user'] ?? "";
    $unique_id = $_SESSION['unique_id'];

    
    function haversineDistance($lat1, $lon1, $lat2, $lon2) {
        $R = 6371; // Radius of the Earth in ki lometers
    
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
    
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        $distance = $R * $c; // Distance in kilometers
        return $distance;
    }
    
    $getRider = "SELECT *, booking.driver_latitude AS driver_latitude, booking.driver_longitude AS driver_longitude
                FROM booking
                INNER JOIN account ON booking.driver_id = account.unique_id
                WHERE booking.status='pending'";
    $stmt = $conn->prepare($getRider);
    $stmt->execute();     
    $result = $stmt->get_result();

    // Check for results
    if ($result->num_rows > 0) {

        $myLatitude = $_POST['myLatitude'] ?? 0;
        $myLongitude = $_POST['myLongitude'] ?? 0;

        // Loop through results
        while ($row = $result->fetch_assoc()) {
            // Extract data from each row
            $getProfileImg = $row['profile_img'];
            $name = $row['fname'] . ' ' . $row['lname'];
            $location = $row['current_location'];
            $getDate = $row['date'];

            // Get the driver's average rating
            $driver_id = $row['unique_id'];
            $booking_id = $row['booking_id'];
            $avg_rating_sql = mysqli_query($conn, "SELECT AVG(star) AS average_rating FROM driver_ratings WHERE driver_id='$driver_id'");
            $avg_rating_row = mysqli_fetch_assoc($avg_rating_sql);
            $average_rating = $avg_rating_row['average_rating'];
            mysqli_free_result($avg_rating_sql); // Free the result set

            // Calculate the distance between your location and the driver's location
            $driverLatitude = $row['driver_latitude'];
            $driverLongitude = $row['driver_longitude'];
            $distance = haversineDistance($myLatitude, $myLongitude, $driverLatitude, $driverLongitude);

            // Store the distance in the $row array
            $row['distance'] = $distance;

            // Store the row in an array for sorting later
            $drivers[] = $row;
        }

        // Sort the array based on distance (ascending order)
        usort($drivers, function ($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        // Display the sorted drivers
        foreach ($drivers as $row) {
            // Extract data from each row
            $name = $row['fname']. ' ' .$row['lname'];
            $location = $row['current_location'];
            $getDate = $row['date'];

            // Get the driver's average rating
            $driver_id = $row['unique_id'];
            $booking_id = $row['booking_id'];
            $avg_rating_sql = mysqli_query($conn, "SELECT AVG(star) AS average_rating, COUNT(*) AS total_ratings FROM driver_ratings WHERE driver_id='$driver_id'");
            $avg_rating_row = mysqli_fetch_assoc($avg_rating_sql);
            $average_rating = $avg_rating_row['average_rating'];
            $total_rating = $avg_rating_row['total_ratings'];
            mysqli_free_result($avg_rating_sql); // Free the result set
            ?>
            <article class="pt-6 pb-6 border-b border-gray-300">
                <!-- Your existing HTML structure -->
                <div class="flex items-center mb-4">
                    <img class="w-11 h-11 rounded-full" src="../images/profile/<?php echo $getProfileImg ?? "profile.png"; ?>" alt="Rounded avatar">
                    <div class="font-medium dark:text-white">
                        <p class="ml-2"><?php echo $name;?> <time class="block text-sm text-gray-500">Joined on <?php echo $getDate ? strftime("%B %d, %Y", strtotime($getDate)) : ""; ?></time></p>
                    </div>
                </div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Plate No. :</span> <?php echo "VXY232"; ?></p></div>
                <div class="mb-2 text-base text-gray-500"><p><span class="font-bold">Current Location :</span> <?php echo $location; ?></p></div>
                <div class="mb-5 text-base text-gray-500 ">
                    <p><span class="font-bold">Average Ratings : </span> <?php echo number_format($average_rating, 1); ?>/5 (<?php echo $total_rating; ?> Reviews)
                        <i class="mr-2 text-base fa fa-star text-yellow-300" aria-hidden="true"></i>
                    </p>
                </div>
                <a href="destination.php?driver_id=<?php echo $driver_id; ?>&booking_id=<?php echo $booking_id; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold mr-2 mt-2 py-2 px-6 rounded">
                    Book Now
                </a>  
                <!-- <a href="driver.php?driver_id=<?php echo $driver_id; ?>" class="bg-purple-400 hover:bg-purple-500 text-white font-bold mt-2 py-2 px-12 rounded">
                    View
                </a>    -->
                <a href="driver.php?driver_id=<?php echo $driver_id; ?>" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white">
                    <span class="relative px-12 py-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    View
                    </span>
                </a>
            </article>
            <?php
        }
    } else {
        // No drivers found
        echo "No driver found near you...";
    }
?>