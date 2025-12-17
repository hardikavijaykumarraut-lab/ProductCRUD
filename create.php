<?php
require_once __DIR__ . '/models/Product.php';
session_start();

try {
  // Basic server-side validation
  $name = $_POST['name'] ?? '';
  $price = $_POST['price'] ?? '';
  $category = $_POST['category'] ?? '';

  if (trim($name) === '' || trim($category) === '' || $price === '' || !is_numeric($price) || (float)$price < 0) {
    throw new InvalidArgumentException("Please provide valid name, price, and category.");
  }

  Product::create($name, (float)$price, $category);

  $_SESSION['flash'] = ['type' => 'success', 'message' => 'Product created successfully.'];
} catch (Throwable $e) {
  $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Error: ' . $e->getMessage()];
}

header('Location: index.php');
exit;
