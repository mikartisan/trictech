var map;
var directionsService;
var directionsDisplay;

function initMap() {
    var myLatLng = { lat: 14.776673, lng: 120.516190 };
    map = new google.maps.Map(document.getElementById('googleMap'), {
        center: myLatLng,
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer();
    distanceService = new google.maps.DistanceMatrixService();
    directionsDisplay.setMap(map);

    var marker = null;

    // Add click event listener to the map
    map.addListener('click', function(event) {
        var clickedLocation = event.latLng;

        // Remove the existing marker
        if (marker !== null) {
            marker.setMap(null);
        }

        // Add a new marker
        marker = new google.maps.Marker({
        // marker = new google.maps.marker.AdvancedMarkerElement({
            position: clickedLocation,
            map: map
        });

        // Get the formatted address of the clicked location
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: clickedLocation }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var closestResult = findClosestResult(clickedLocation, results);
                var formattedAddress = closestResult.formatted_address;

                console.log(results);
                console.log(formattedAddress);

                // Update the destination input with the formatted address
                document.getElementById('to').value = formattedAddress;

                // Calculate distance between origin and destination
                calculateDistance();
            } else {
                console.error('Failed to geocode location:', status);
            }
        });
    });

    // Create autocomplete objects for all inputs
    var options = {};

    var input1 = document.getElementById('origin');
    var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
    var input2 = document.getElementById('to');
    var autocomplete2 = new google.maps.places.Autocomplete(input2, options);
}

function calculateDistance() {
    var origin = document.getElementById('origin').value;
    var destination = document.getElementById('to').value;

    if (origin && destination) {
        distanceService.getDistanceMatrix({
            origins: [origin],
            destinations: [destination],
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, function(response, status) {
            if (status === 'OK') {
                var totalDistance = response.rows[0].elements[0].distance.value;
                var totalDistanceInKm = totalDistance / 1000;
                var totalDuration = response.rows[0].elements[0].duration.value;

                // Calculate fare based on distance
                var fare = calculateFare(totalDistanceInKm);

                // Format the distance and fare
                var formattedDistance = totalDistanceInKm.toFixed(2) + " KM";
                var formattedFare = parseFloat(fare.toFixed(2));

                console.log('Distance: ' + formattedDistance);
                console.log('Fare: $' + formattedFare);

                document.getElementById("distance").value = formattedDistance; // Corrected typo here
                document.getElementById("fare").value = formattedFare;

                const output = document.querySelector('#output');

                output.innerHTML = "<li class='flex flex-wrap gap-4'>Total Distance <span class='ml-auto'>"+ formattedDistance +"</span></li><li class='flex flex-wrap gap-4'>Duration <span class='ml-auto'>" + Math.floor(totalDuration / 60) + " minutes</span></li><li class='flex flex-wrap gap-4'>Estimated Price <span class='ml-auto font-semibold'>₱ "+ formattedFare + " - ₱" + (formattedFare + 5).toFixed(2); +"</span></li>";
                
                // You can now use the formattedDistance and formattedFare values as needed
            } else {
                console.error('Error calculating distance:', status);
            }
        });
    }
}

// Function to find the closest result to the clicked location
function findClosestResult(clickedLocation, results) {
    var closestResult = results[0];
    var closestDistance = google.maps.geometry.spherical.computeDistanceBetween(
        clickedLocation,
        closestResult.geometry.location
    );

    for (var i = 1; i < results.length; i++) {
        var distance = google.maps.geometry.spherical.computeDistanceBetween(
            clickedLocation,
            results[i].geometry.location
        );

        if (distance < closestDistance) {
            closestResult = results[i];
            closestDistance = distance;
        }
    }

    return closestResult;
}

//Get The Current Location
function getMyLocation() {
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
                        document.getElementById("origin").value = address;
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