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

    // Set initial values for 'origin' and 'to'
    var origin = document.getElementById('origin').value;
    var destination = document.getElementById('to').value;


    // Call calculateRoute function with initial values
    calculateRoute(origin, destination);
}

function calculateRoute(origin, destination) {
    var request = {
        origin: origin,
        destination: destination,
        travelMode: 'DRIVING'
    };

    directionsService.route(request, function (result, status) {
        if (status === 'OK') {
            directionsDisplay.setDirections(result);
        } else {
            console.error('Error calculating route:', status);
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