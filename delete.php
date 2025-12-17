<?php
require_once __DIR__ . '/models/Product.php';
session_start();

try {
  $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
  if ($id <= 0) {
    throw new InvalidArgumentException("Invalid product id.");
  }
  Product::delete($id);
  $_SESSION['flash'] = ['type' => 'success', 'message' => 'Product deleted successfully.'];
} catch (Throwable $e) {
  $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Error: ' . $e->getMessage()];
}

header('Location: index.php');
exit;
