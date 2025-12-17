ProductCRUD – PHP + MySQL CRUD Application

Overview:
This project is a simple CRUD (Create, Read, Update, Delete)** application built with PHP and MySQL.  
It demonstrates how to manage products with fields like id, name, price, category, and includes data visualization using Chart.js.

Features:

- Create: Add new products via a form.
- Read: Display all products in a styled table.
- Update: Edit product details using a form.
- Delete: Remove products from the database.
- Optional Visualization: Bar chart showing product counts per category (Chart.js).
- Secure & Modular:
  - Uses PDO for database access.
  - Includes server-side validation.
  - Modularized code (models, partials, config).


Requirements
- PHP 7.4+ (recommended PHP 8.x for modern syntax)
- MySQL 5.7+
- XAMPP/WAMP/LAMPP or any local server
- Browser with JavaScript enabled


Setup Instructions:

1. Clone or copy the project into your server’s root directory (e.g., `htdocs/ProductCRUD` for XAMPP).
2. Create the database:

   CREATE DATABASE product_crud;
   USE product_crud;

   CREATE TABLE products (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(255) NOT NULL,
     price DECIMAL(10,2) NOT NULL,
     category VARCHAR(100) NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

3.Configure database connection:

Open config.php and update:

define('DB_HOST', 'localhost');
define('DB_NAME', 'product_crud');
define('DB_USER', 'root');
define('DB_PASS', '');
Adjust DB_USER and DB_PASS if your MySQL setup requires it.

4.Start Apache and MySQL in XAMPP.

5.Open the app in your browser: http://localhost/ProductCRUD/index.php

