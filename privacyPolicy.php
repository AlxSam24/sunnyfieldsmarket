<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="PrivacyPolicyCss.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
<title>Privacy Policy</title>
</head>
<body> 
<a target="_self" href="http://localhost:81/my-app/Home.php" title="Sunny Fields"><img src="Logo.jpg" alt="Sunny Fields" width="100" height="100" class="ccm-image-block img-responsive bID-215" title="Sunny Fields"></a>
<header>
  <hr style="height:2px;border-width:0;color:gray;background-color:white">
  <nav>
    <li title="Home"  ><b><a href="http://localhost:81/my-app/Home.php">Home</b></a></li>
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
<h1>Privacy Policy</h1>
<p>Effective Date: 10/11/2023<br>
Sunny Fields Market is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose,<br>
and safeguard your personal information. By using our website you consent to the practices described in this Privacy Policy.
<h2>Information We Collect</h2>
<p> We may collect the following types of personal information when you visit our website:</p>
<p>1. <b>Contact Information:</b> When you sign up for our website or contact us through our website, we may collect your name, email address, and phone number.
<p>2. <b>Browsing Information:</b> We may collect non-personal information, such as your IP address, browser type, and operating system.
<h2>How We Use Your Information</h2>
<p>We use the information we collect for the following purposes:</p>
<p>1. <b>Communication:</b> We may use your contact information to respond to your inquiries or send you information about our products, promotions, and events.</p>
<p> 2. <b>Improvement:</b> We may use your browsing information to improve our website and tailor our content to better serve you.
<h2>Cookies and Tracking Technologies</h2>
<p>We may use cookies and other tracking technologies to collect and store information about your interactions with our website.<br> You can manage your cookie preferences through your web browser settings.</p>
<h2>Disclosure of Your Information</h2>
<p>We will not sell, rent, or trade your personal information to third parties.<br> However, we may share your information with service providers or partners who help us operate our website or deliver services to you.
<h2>Data Security</h2>
<p>We take reasonable steps to protect your personal information from unauthorized access, disclosure, alteration, or destruction.<br> However, please be aware that no method of transmission over the internet is entirely secure, and we cannot guarantee the absolute security of your data.
<h2>Your Choices</h2>
<p>You have the right to:</p>
<p>-Access the personal information we hold about you.<br>
-Correct inaccuracies in your personal information.<br>
-Opt out of receiving marketing communications from us.
</p>
<h2>Children's Privacy</h2>
<p>Our website is not intended for individuals under the age of 13,<br> and we do not knowingly collect personal information from children.</p>
<h2>Changes to this Privacy Policy</h2>
<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page,<br> and the effective date will be revised accordingly.</p>
<h2>Contact Us</h2>
<p>If you have any questions, concerns, or requests regarding this Privacy Policy,<br> please contact us at 07781480524 or email at customer.queries@sunnyfieldsmarket.co.uk.</p>



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
