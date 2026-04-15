<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY7AslsNk3TgqHc4D1p3n6YprTpsz2ZUI&callback=initMap" defer></script>
<link rel="stylesheet" href="AboutUs.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
<title>Sunny Fields Market</title>
<style>
        /* Set the size of the map  */
        #map-container {
            height: 300px;
            width: 15%;
        }
</style>
</head>
<body> 
<a target="_self" href="http://localhost:81/my-app/Home.php" title="Sunny Fields"><div class="logo"><img src="Logo.jpg" alt="Sunny Fields" width="100" height="100" class="ccm-image-block img-responsive bID-215" title="Sunny Fields"></a></div>
<header>
  <hr style="height:2px;border-width:0;color:gray;background-color:white">
  <nav>
    <li title="Home"  style=><b><a class="active" href="http://localhost:81/my-app/Home.php">Home</b></a></li>
    <li title ="About Us" ><b><a href="http://localhost:81/my-app/AboutUs.php">About Us</b></a></li>
    <li title ="Account"><b><a href="http://localhost:81/my-app/AccountLog.php">Account</b></a></li>
    <li title ="Contact"><b><a href="http://localhost:81/my-app/Contact.php">Contact</b></a></li>
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['user'])) {
        // Display the "Previous Orders" link
        echo '<li title="Previous Orders"><b><a href="http://localhost:81/my-app/PreviousOrders.php">Previous Orders</a></b></li>';
    }
    ?>
  </nav>
  <hr style="height:2px;border-width:0;color:gray;background-color:white">
</header>
<header>
        <h1>About Our Company</h1>
    </header>

    <section>
        <h2>Welcome to Sunny Fields Market</h2>
        <p>At Sunny Fields Market, we take pride in being your go-to destination for a delightful shopping experience in the heart of Kensington. Established with a commitment to providing the finest and freshest produce, our grocery store is dedicated to serving the diverse needs of our community.</p>

        <h3>Our Commitment</h3>
        <p>Sunny Fields Market is more than just a grocery store; it's a reflection of our passion for quality, freshness, and community. We believe in sourcing the best products to ensure that every item you find on our shelves is of the highest standard. From succulent meats and crisp vegetables to farm-fresh dairy and wholesome pantry essentials, we curate our selection with care and consideration.</p>

        <h3>Freshness Guaranteed</h3>
        <p>We prioritize freshness in everything we offer. Our team works closely with local farmers and trusted suppliers to bring you the finest meats, vibrant vegetables, and dairy products straight from the source.</p>
        <img src="about us image.jpeg" alt="Freshness Guaranteed">
        

        <h3>Local Love</h3>
        <p>Supporting our local community is at the core of Sunny Fields Market. By collaborating with nearby farmers and producers, we contribute to the growth of local businesses and bring you the best of what Kensington has to offer.</p>
        <img src="about us meat.jpg" alt="Freshness Guaranteed">

        <h3>Personalized Service</h3>
        <p>Our friendly and knowledgeable staff is here to assist you on your shopping journey. Whether you're looking for cooking tips, product recommendations, or have special requests, we're always happy to help.</p>

        <h3>Your Feedback Matters</h3>
        <p>At Sunny Fields Market, we consider our customers to be an integral part of our journey. Your feedback shapes our offerings, and your experiences guide our growth. We invite you to share your thoughts, ideas, and suggestions as we continue to evolve and strive to be the best neighborhood grocery store in Kensington. Leave your questions and reviews by clicking on our contact page where one of our colleagues will be there to help or take your message into consideration.</p>

        <h3>Community Enrichment</h3>
        <p>At the heart of Sunny Fields Market is a commitment to community enrichment. Beyond providing exceptional products, we actively engage with our neighbors through events, workshops, and partnerships. We believe that a strong community is built on shared experiences, and we're proud to be a gathering place where friendships flourish, and ideas are exchanged.</p>

        <h3>Sustainable Practices</h3>
        <p>Sustainability isn't just a buzzword for us; it's a way of life. Sunny Fields Market is dedicated to implementing eco-friendly practices, from minimizing packaging waste to supporting local initiatives that promote environmental responsibility. We believe that by caring for our planet, we contribute to a healthier and more vibrant community.</p>

        <h3>Thank You</h3>
        <p>Thank you for being a part of the Sunny Fields Market story. Together, we're building more than just a grocery store; we're cultivating a community that values freshness, quality, and the joy of shared moments around the table.</p>

        <h3>Location</h3>
        <div id="map-container"></div>
        <script>
        function initMap() {
            // Replace with the coordinates of the location you want to display
            var myLocation = { lat: 51.497708, lng: -0.192580};

            var map = new google.maps.Map(document.getElementById('map-container'), {
                center: myLocation,
                zoom: 12 // Adjust the zoom level as needed
            });

            var marker = new google.maps.Marker({
                position: myLocation,
                map: map,
                title: 'My Marker'
            });
        }
    </script>
    

        
        
        <p><i>Address:
            <br>Sunny Fields Market
            <br>57 St Charles's street 
            <br>Kensington
            <br>SW3 5CK
            <br>United Kingdom

        </p></i>
    </section>

</body>
</html>


<hr style="height:2px;border-width:0;color:gray;background-color:white">
<footer>
    <div class="text-only-nav">
        <nav>
        <li style="text-align: right;">© <date>2023</date> Sunny Fields Market ltd. All Rights Reserved</li>
        <li><a style ="text-align: right;" href="http://localhost:81/my-app/privacyPolicy.php">Privacy Policy</a></li>
        </nav>
    </div>
  
</footer>
</body>
</html>
