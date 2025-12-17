<?php
require_once __DIR__ . '/models/Product.php';

// Handle flash messages (simple)
session_start();
$flash = $_SESSION['flash'] ?? null; 
unset($_SESSION['flash']);

$products = Product::all();
?>
<?php include __DIR__ . '/partials/header.php'; ?>

<?php if ($flash): ?>
  <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
    <?php echo htmlspecialchars($flash['message']); ?>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-7">
    <div class="card mb-4">
      <div class="card-header">Products</div>
      <div class="card-body">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Category</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><?php echo (int)$p['id']; ?></td>
              <td><?php echo htmlspecialchars($p['name']); ?></td>
              <td><?php echo htmlspecialchars($p['price']); ?></td>
              <td><?php echo htmlspecialchars($p['category']); ?></td>
              <td><?php echo htmlspecialchars($p['created_at']); ?></td>
              <td class="table-actions">
                <a class="btn btn-sm btn-primary" href="update.php?id=<?php echo (int)$p['id']; ?>">Edit</a>
                <form method="post" action="delete.php" style="display:inline" onsubmit="return confirm('Delete this product?');">
                  <input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>">
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <?php if (empty($products)): ?>
          <p class="text-muted">No products found. Add your first product!</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <div class="card mb-4">
      <div class="card-header">Add Product</div>
      <div class="card-body">
        <form method="post" action="create.php" novalidate>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" type="text" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input class="form-control" type="number" step="0.01" min="0" name="price" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <input class="form-control" type="text" name="category" required>
          </div>
          <button class="btn btn-success" type="submit">Create</button>
        </form>
      </div>
    </div>

    <!-- Optional Visualization -->
    <div class="card">
      <div class="card-header">Products by Category</div>
      <div class="card-body">
        <canvas id="categoryChart" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<?php
// Prepare chart data
$byCat = Product::countByCategory();
$labels = array_column($byCat, 'category');
$counts = array_map('intval', array_column($byCat, 'cnt'));
?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('categoryChart').getContext('2d');
const labels = <?php echo json_encode($labels); ?>;
const data = <?php echo json_encode($counts); ?>;

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [{
      label: 'Count',
      data: data,
      backgroundColor: '#0d6efd'
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>


<?php include __DIR__ . '/partials/footer.php'; ?>
