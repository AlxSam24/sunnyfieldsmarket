<?php
//connects to the server 
$servername = "localhost";
$dbusername = $dbpassword = "root";

// Create connection 
$conn = mysqli_connect($servername, $dbusername, $dbpassword);

// Check connection 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo '<script>console.log("Connected to SQL server");</script>';

$DBCreate = "CREATE DATABASE IF NOT EXISTS sunnyfielddata";//creates the database
if (mysqli_query($conn, $DBCreate)) {
    mysqli_select_db($conn, "sunnyfielddata");

    $Staffpassword= "Brian";//sets the staff password as 'brian'
    $hashedStaffPassword = password_hash($Staffpassword, PASSWORD_DEFAULT);//hashes the staff password before it's stored in the table 

    $CustomerPassword="Alex@2006";//sets the customer password as 'Alex@2006'
    $hashedCustomerPassword= password_hash($CustomerPassword, PASSWORD_DEFAULT);//hashes the customer password before its stored in the table 
    // the sql code to create all the database contents and tables this will code will only run if the tables don't exist 
    $dbSetUp = "
        CREATE TABLE IF NOT EXISTS staff (
            staffID int(11) NOT NULL AUTO_INCREMENT,
            Name varchar(255) DEFAULT NULL,
            Address varchar(255) DEFAULT NULL,
            DateOfBirth date DEFAULT NULL,
            Staff_Password varchar(255) NOT NULL,
            Email varchar(255) DEFAULT NULL,
            Postcode varchar(255) DEFAULT NULL,
            PRIMARY KEY (staffID)
        );

        INSERT INTO staff (Name, Address, DateOfBirth, Staff_Password, Email, Postcode) VALUES
        ('Brian Foster', '123 George Street', '1994-05-17', '$hashedStaffPassword', 'brianfoster@sunnyfieldsmarket.co.uk', 'NP14 6JQ');

        CREATE TABLE IF NOT EXISTS customers (
            email varchar(255) NOT NULL,
            birthdate date DEFAULT NULL,
            password_hash varchar(500) DEFAULT NULL,
            fullname varchar(30) DEFAULT NULL,
            user_id int(11) NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (user_id),
            UNIQUE KEY email (email)
        );

        INSERT INTO customers (email, birthdate, password_hash, fullname) VALUES
        ('alexanderdsamuel@gmail.com', '2006-06-24', '$hashedCustomerPassword', 'Alex Samuel');

        CREATE TABLE IF NOT EXISTS feedback (
            FeedbackEntryID int(11) NOT NULL AUTO_INCREMENT,
            CustomerID int(11) DEFAULT NULL,
            Contents text,
            FeedbackDate date DEFAULT NULL,
            PRIMARY KEY (FeedbackEntryID)
        );

        INSERT INTO feedback (CustomerID, Contents, FeedbackDate) VALUES
        (1, 'How do you collect order from store?', '2024-02-07'),
        (1, 'vxcvxcvxvxcvvbnvjxnmvbxncbv bnxcv', '2024-02-07'),
        (1, 'This is another test', '2024-02-18'),
        (2, 'What is your store opening times ?', '2024-02-27');

        CREATE TABLE IF NOT EXISTS orders (
            order_date date DEFAULT NULL,
            order_total decimal(10,2) DEFAULT NULL,
            customer_id int(11) DEFAULT NULL,
            address varchar(255) DEFAULT NULL,
            card_number varchar(255) DEFAULT NULL,
            expiry_month varchar(10) DEFAULT NULL,
            expiry_year varchar(10) DEFAULT NULL,
            cvv varchar(10) DEFAULT NULL,
            postcode varchar(10) DEFAULT NULL,
            orderID int(11) NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (orderID)
        );

        CREATE TABLE IF NOT EXISTS order_product (
            grocery_id int(11) DEFAULT NULL,
            quantity int(11) DEFAULT NULL,
            order_id int(11) DEFAULT NULL
        );

        CREATE TABLE IF NOT EXISTS groceries (
            name varchar(255) NOT NULL,
            price decimal(10,2) NOT NULL,
            quantity int(11) NOT NULL,
            image_path varchar(255) DEFAULT NULL,
            grocery_id int(11) NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(grocery_id)
        );

        INSERT INTO groceries (name, price, quantity, image_path) VALUES
        ('Carrots', '1.50', 0, 'carrots.jpg'),
        ('Broccoli', '0.70', 2, 'broccoli.jpg'),
        ('Tomato', '2.00', 1, 'tomato.jfif'),
        ('Cauliflower', '1.10', 8, 'cauliflower.jpg'),
        ('Eggs', '1.20', 0, 'eggs.jpg'),
        ('Bananas', '1.00', 3, 'bananas.jpg'),
        ('Apples', '1.99', 20, 'apples.jpg'),
        ('Oranges', '2.49', 12, 'oranges.jpg'),
        ('Grapes (Red)', '3.99', 5, 'grapes.jpg'),
        ('Strawberries', '4.99', 4, 'strawberries.jpg'),
        ('Blueberries', '5.99', 10, 'blueberries.jpg'),
        ('Avocados', '1.49', 10, 'avocados.jpg'),
        ('Cucumbers', '0.99', 12, 'cucumbers.jpg'),
        ('Lettuce', '2.29', 11, 'lettuce.jpg'),
        ('Spinach', '2.99', 8, 'spinach.jpg'),
        ('Bell peppers', '1.69', 11, 'bell_peppers.jpg'),
        ('Onions', '0.89', 12, 'onions.jpg'),
        ('Potatoes', '1.19', 10, 'potatoes.jpg'),
        ('Sweet potatoes', '1.49', 19, 'sweet_potatoes.jpg'),
        ('Garlic', '0.69', 12, 'garlic.jpg'),
        ('Ginger', '1.29', 7, 'ginger.jpg'),
        ('Lemons', '0.99', 10, 'lemons.jpg'),
        ('Limes', '0.79', 12, 'limes.jpg'),
        ('Watermelon', '4.99', 20, 'watermelon.jpg'),
        ('Cantaloupe', '3.49', 8, 'cantaloupe.jpg'),
        ('Pineapple', '2.99', 9, 'pineapple.jpg'),
        ('Mangoes', '1.79', 9, 'mangoes.jpg'),
        ('Peaches', '2.29', 8, 'peaches.jpg'),
        ('Plums', '1.99', 9, 'plums.jpg'),
        ('Nectarines', '2.49', 20, 'nectarines.jpg'),
        ('Cherries', '3.99', 5, 'cherries.jpg'),
        ('Kiwi', '0.99', 12, 'kiwi.jpg'),
        ('Papaya', '3.29', 8, 'papaya.jpg'),
        ('Pears', '1.79', 10, 'pears.jpg'),
        ('Peppers (assorted)', '2.99', 15, 'peppers_assorted.jpg'),
        ('Zucchini', '1.29', 12, 'zucchini.jpg'),
        ('Eggplant', '1.49', 10, 'eggplant.jpg'),
        ('Radishes', '0.89', 14, 'radishes.jpg'),
        ('Celery', '1.29', 12, 'celery.jpg'),
        ('Asparagus', '2.99', 8, 'asparagus.jpg'),
        ('Green beans', '1.79', 12, 'green_beans.jpg'),
        ('Brussels sprouts', '2.49', 10, 'brussels_sprouts.jpg'),
        ('Artichokes', '3.99', 4, 'artichokes.jpg'),
        ('Mushrooms', '2.29', 10, 'mushrooms.jpg'),
        ('Squash (varieties)', '1.99', 12, 'squash_varieties.jpg'),
        ('Beets', '1.49', 15, 'beets.jpg'),
        ('Sweet corn', '0.79', 16, 'sweet_corn.jpg'),
        ('Red cabbage', '1.29', 10, 'red_cabbage.jpg'),
        ('Iceberg lettuce', '1.49', 10, 'iceberg_lettuce.jpg'),
        ('Romaine lettuce', '1.79', 7, 'romaine_lettuce.jpg'),
        ('Arugula', '2.29', 8, 'arugula.jpg'),
        ('Baby spinach', '2.99', 10, 'baby_spinach.jpg'),
        ('Kale', '2.49', 10, 'kale.jpg'),
        ('Swiss chard', '2.79', 8, 'swiss_chard.jpg'),
        ('Red onions', '0.89', 14, 'red_onions.jpg'),
        ('Shallots', '1.49', 10, 'shallots.jpg'),
        ('Scallions', '0.99', 12, 'scallions.jpg'),
        ('Leeks', '1.29', 9, 'leeks.jpg'),
        ('Cilantro', '0.69', 15, 'cilantro.jpg'),
        ('Parsley', '0.69', 15, 'parsley.jpg'),
        ('Basil', '0.79', 12, 'basil.jpg'),
        ('Mint', '0.79', 12, 'mint.jpg'),
        ('Thyme', '0.89', 10, 'thyme.jpg'),
        ('Rosemary', '0.89', 10, 'rosemary.jpg'),
        ('Dill', '0.79', 8, 'dill.jpg'),
        ('Chives', '0.69', 15, 'chives.jpg'),
        ('Oregano', '0.79', 12, 'oregano.jpg'),
        ('Sage', '0.89', 10, 'sage.jpg'),
        ('Bay leaves', '0.79', 12, 'bay_leaves.jpg'),
        ('Coriander', '0.50', 12, 'coriander.jpg'),
        ('Ground cinnamon', '1.99', 10, 'ground_cinnamon.jpg'),
        ('Vanilla extract', '4.99', 5, 'vanilla_extract.jpg'),
        ('Nutmeg', '2.49', 10, 'nutmeg.jpg'),
        ('Cloves', '2.99', 8, 'cloves.jpg'),
        ('Milk (Whole)', '2.50', 16, 'whole_milk.jpg'),
        ('Milk (Semi-skimmed)', '2.00', 10, 'semiskimmed_milk.jpg'),
        ('Milk (skimmed)', '2.00', 4, 'skimmed_milk.jpg'),
        ('Steak', '15.00', 8, 'steak.jpg'),
        ('Whole Chicken ', '12.00', 7, 'chicken.jpg'),
        ('Pork ', '12.00', 9, 'pork.jpg'),
        ('Beef', '14.99', 13, 'beef.jpg'),
        ('Bread', '1.50', 4, 'bread.jpg'),
        ('Dragon Fruit ', '3.50', 11, 'dragonfruit.jpg'),
        ('Honeycomb ', '5.00', 19, 'honeycomb.jfif'),
        ('Bacon', '5.00', 10, 'bacon.jpg');

    );

        
    ";

    if (mysqli_multi_query($conn, $dbSetUp)) {
        echo '<script>console.log("DB tables setup");</script>';
    } else {
        echo mysqli_error($conn);
    }
} else {
    echo mysqli_error($conn);
}

mysqli_close($conn);//closes the databse connection 
?>
