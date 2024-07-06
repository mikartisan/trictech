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
            } else {
                console.error('Failed to geocode location:', status);
            }
        });

    });

    // Create autocomplete objects for all inputs
    var options = {};

    var input1 = document.getElementById('origin');
    var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
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

function calcFastestRoute() {
    var origin = document.getElementById("origin").value;
    var destination = document.getElementById("to").value;

    if (destination === '') {
        const output = document.querySelector('#output');
        output.innerHTML = "<div class='alert-danger'><i class='fas fa-exclamation-triangle'></i> Please enter a destination.</div>";
        return;
    }

    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [origin],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING
    },

    function(response, status) {
        if (status === google.maps.DistanceMatrixStatus.OK) {
            var distances = response.rows[0].elements;
            var sortedDestinations = [];
    
            // Define the `destinations` variable here
            var destinations = [];
    
            for (var i = 0; i < distances.length; i++) {
                var distance = distances[i].distance.value;
                var dest = response.destinationAddresses[i]; // Get the destination address
                sortedDestinations.push({ destination: dest, distance: distance });
                destinations.push(dest); // Add the destination to the `destinations` array
            }                                                                        
    
            sortedDestinations.sort(function(a, b) {
                return a.distance - b.distance;
            });
    
            var waypoints = [];
            for (var j = 0; j < sortedDestinations.length; j++) {
                waypoints.push({
                    location: sortedDestinations[j].destination,
                    stopover: false,
                });
            }
        
            var request = {
                origin: origin,
                destination: sortedDestinations[sortedDestinations.length - 1].destination,
                waypoints: waypoints,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            };
    
            directionsService.route(request, function(result, status) {
                var totalDuration = 0;
                var totalDistance = 0;
    
                //Calculate total duration
                for (var i = 0; i < result.routes[0].legs.length; i++) {
                    totalDuration += result.routes[0].legs[i].duration.value;
                }
                var totalDurationInMinutes = totalDuration / 60;
                var formattedDuration = "";
        
                if (totalDurationInMinutes >= 60) {
                    var hours = Math.floor(totalDurationInMinutes / 60);
                    var minutes = Math.floor(totalDurationInMinutes % 60);
        
                    formattedDuration = hours + " hour" + (hours > 1 ? "s" : "") + " " + minutes + " minute" + (minutes > 1 ? "s" : "");
                } else {
                    formattedDuration = Math.floor(totalDurationInMinutes) + " minutes";
                }
    
                /**
                 * 
                 * Calculate total Distance
                 * 
                 * **/
                for (var i = 0; i < result.routes.length; i++) {
                    var route = result.routes[i];
        
                    for (var j = 0; j < route.legs.length; j++) {
                        var leg = route.legs[j];
                        totalDistance += leg.distance.value;
                    }
                }
                
                /**
                 * 
                 * calculate the fare based on the kilometers
                 * 
                 * **/
                var totalDistanceInKm = totalDistance / 1000;
                var fare = calculateFare(totalDistanceInKm);
                // Format the distance and fare
                var formattedDistance = totalDistanceInKm.toFixed(2) + " km";
                var formattedFare = parseFloat(fare.toFixed(2));
                
                /**
                 * 
                 * Display the destination/distance/duration fo entire path
                 * 
                 * **/
                if (status === google.maps.DirectionsStatus.OK) {
                    const output = document.querySelector('#output');
                    output.innerHTML = "<div class='rounded-md text-black'><div class='bg-blue-300 p-4 rounded-xl mb-2'><b>Origin: </b>" + origin + ".</div><div class='bg-blue-300 p-4 rounded-xl mb-2'><b>Destinations: </b>" + sortedDestinations.map(dest => dest.destination).join(' / ') + ".</div><div class='bg-blue-300 p-4 rounded-xl mb-2'><b>Driving Distance: </b><i class='fas fa-road'></i> " + formattedDistance + ". <br> <b>Duration : </b><i class='fas fa-hourglass-start'></i> " + formattedDuration + ". </div><div class='bg-blue-300 p-4 rounded-xl'><b>Estimated Price : <span class='text-xl'> <br> ₱" + formattedFare + " - ₱" + (formattedFare + 5).toFixed(2); +"</span></div></div>";

                    directionsDisplay.setDirections(result);
                } else {
                    directionsDisplay.setDirections({ routes: [] });
                    map.setCenter(myLatLng);

                    const output = document.querySelector('#output');
                    output.innerHTML = "<div class='alert-danger'><i class='fas fa-exclamation-triangle'></i> Could not retrieve driving distance.</div>";
                }
                
            });
        } else {
            const output = document.querySelector('#output');
            output.innerHTML = "<div class='alert-danger'><i class='fas fa-exclamation-triangle'></i> Could not calculate distances.</div>";
        }
    });
}

//Get Rider Current Location
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