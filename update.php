<?php
require_once __DIR__ . '/models/Product.php';
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = Product::find($id);
if (!$product) {
  $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Product not found.'];
  header('Location: index.php');
  exit;
}

// Handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $category = $_POST['category'] ?? '';

    if (trim($name) === '' || trim($category) === '' || $price === '' || !is_numeric($price) || (float)$price < 0) {
      throw new InvalidArgumentException("Please provide valid name, price, and category.");
    }

    Product::update($id, $name, (float)$price, $category);
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Product updated successfully.'];
    header('Location: index.php');
    exit;
  } catch (Throwable $e) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Error: ' . $e->getMessage()];
  }
}
?>
<?php include __DIR__ . '/partials/header.php'; ?>

<div class="card">
  <div class="card-header">Edit Product #<?php echo (int)$product['id']; ?></div>
  <div class="card-body">
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Price</label>
        <input class="form-control" type="number" step="0.01" min="0" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <input class="form-control" type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
      </div>
      <button class="btn btn-primary" type="submit">Update</button>
      <a class="btn btn-secondary" href="index.php">Cancel</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
