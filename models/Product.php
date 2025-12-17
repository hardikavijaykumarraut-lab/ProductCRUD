<?php
require_once __DIR__ . '/../db.php';

class Product {
  public static function all(): array {
    $stmt = getPDO()->query("SELECT * FROM products ORDER BY id DESC");
    return $stmt->fetchAll();
  }

  public static function find(int $id): ?array {
    $stmt = getPDO()->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  public static function create(string $name, float $price, string $category): int {
    // Server-side validation
    if (trim($name) === '' || $price < 0 || trim($category) === '') {
      throw new InvalidArgumentException("Invalid input for product.");
    }
    $stmt = getPDO()->prepare("INSERT INTO products (name, price, category) VALUES (?, ?, ?)");
    $stmt->execute([$name, $price, $category]);
    return (int)getPDO()->lastInsertId();
  }

  public static function update(int $id, string $name, float $price, string $category): bool {
    if ($id <= 0 || trim($name) === '' || $price < 0 || trim($category) === '') {
      throw new InvalidArgumentException("Invalid input for product.");
    }
    $stmt = getPDO()->prepare("UPDATE products SET name = ?, price = ?, category = ? WHERE id = ?");
    return $stmt->execute([$name, $price, $category, $id]);
  }

  public static function delete(int $id): bool {
    if ($id <= 0) {
      throw new InvalidArgumentException("Invalid product id.");
    }
    $stmt = getPDO()->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public static function countByCategory(): array {
    $stmt = getPDO()->query("SELECT category, COUNT(*) AS cnt FROM products GROUP BY category ORDER BY category");
    return $stmt->fetchAll();
  }
}
