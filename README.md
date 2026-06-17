# Sunny Fields Market

Sunny Fields Market is a web-based food ordering website built with PHP, MySQL, HTML, and CSS. It allows customers to browse groceries, add items to a basket, checkout securely, and view previous orders. Staff members can manage inventory, view and delete orders, and manage customer accounts.

## Features

- Home page with searchable grocery products
- User registration and login
- Shopping cart and basket management
- Checkout workflow with order creation
- Customer order history
- Contact form and feedback submission
- Staff dashboard for managing stock, orders, customers, and feedback
- Admin pages for customer accounts and staff management

## Key Files

- `Home.php` — main storefront, search, add to basket
- `Account.php` — login page for customers and staff
- `Registerpage.php` — new customer registration
- `basket.php` — shopping cart page
- `Checkout.php` — checkout and order submission
- `Order_process.php` — order success confirmation
- `PreviousOrders.php` — customer order history
- `Contact.php` — customer contact form
- `CustomerFeedback.php` — admin feedback management
- `staffPage.php` — staff dashboard
- `StockTable.php` — staff inventory management
- `OrdersTable.php` — staff order management
- `CustomerAccounts.php` — staff customer account view
- `databaseSetUp.php` — database initialization and sample data
- `privacyPolicy.php` — privacy policy page
- `AboutUs.php` — about page

## Technologies

- PHP
- MySQL / MariaDB
- HTML / CSS
- `password_hash()` for password security
- Prepared statements for database inserts and updates
- `$_SESSION` for authentication and cart state

## Setup

1. Install a local web server stack such as XAMPP, WAMP, or similar.
2. Copy the project into your web server document root.
3. Start Apache and MySQL.
4. Open `databaseSetUp.php` in your browser once to create the `sunnyfielddata` database and seed tables.
5. Open `Home.php` in the browser:
   - `http://localhost:81/my-app/Home.php`

## Database

The app uses the `sunnyfielddata` database and expects these tables:

- `staff`
- `customers`
- `feedback`
- `orders`
- `order_product`
- `groceries`

Default MySQL credentials in the project are:
- user: `root`
- password: `root`

Update the connection settings in files if your local database credentials differ.

## Notes

- The app uses session-based login and cookies for user persistence.
- Staff login redirects to `staffPage.php`, where inventory and orders can be managed.
- Customer orders are stored in `orders` and `order_product`.
- `databaseSetUp.php` also seeds sample grocery and account data.

## License

This project is a personal school project for Sunny Fields Market.