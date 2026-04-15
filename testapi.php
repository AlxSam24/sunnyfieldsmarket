<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Section</title>
    <style>
        /* Set the size of the map container */
        #map-container {
            height: 300px;
            width: 15%;
        }
    </style>
</head>
<body>

<!-- Google Maps Section -->
<section id="google-maps-section">
    <h2>Visit Us</h2>
    <p>Find us on the map below:</p>
    
    <!-- Replace YOUR_API_KEY with your actual Google Maps API key -->
    <div id="map-container"></div>

    <!-- Include the Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtDU-crOo8fqHGZQVSgPNWFB5zmEDpW_8&callback=initMap" async defer></script>

    <script>
        // Initialize the map
        function initMap() {
            // Replace the coordinates with the actual latitude and longitude of Sunny Fields Market
            var sunnyFieldsLocation = { lat: 51.497708, lng: -0.192580 };

            // Create a map centered at Sunny Fields Market
            var map = new google.maps.Map(document.getElementById('map-container'), {
                center: sunnyFieldsLocation,
                zoom: 15 // Adjust the zoom level as needed
            });

            // Add a marker at Sunny Fields Market
            var marker = new google.maps.Marker({
                position: sunnyFieldsLocation,
                map: map,
                title: 'Sunny Fields Market'
            });
        }
    </script>
</section>

<!-- Other content on your webpage -->

</body>
</html>