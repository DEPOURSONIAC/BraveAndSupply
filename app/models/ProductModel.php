<?php

/**
 * Get all products.
 *
 * @return array List of all products.
 */
function getAllProducts(): array
{
    $db = getPDO();
    $products = [];

    try {
        $sql = "SELECT * FROM products ORDER BY id DESC";

        $stmt = $db->query($sql);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $products;
}


/**
 * Get a product by its ID.
 *
 * @param int $product_id Product ID.
 *
 * @return array|null Product data if found, otherwise null.
 */
function getProductById(int $product_id): ?array
{
    $db = getPDO();
    $product = null;

    try {
        $sql = "SELECT * FROM products WHERE id = ? LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$product_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $product = $result ?: null;
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $product;
}


/**
 * Create a new product.
 *
 * @param int $category_id Category ID.
 * @param string $name Product name.
 * @param string $description Product description.
 * @param float $price Product price.
 * @param float $stock Product stock.
 * @param string $image Product image.
 *
 * @return bool True if the product was created successfully.
 */
function createProduct(int $category_id, string $name, string $description, float $price, float $stock, string $image): bool
{
    $db = getPDO();
    $created = false;

    try {
        if ($category_id > 0 && !empty($name) && !empty($description) && $price > 0 && $stock > 0 && !empty($image)) {
            $sql = "INSERT INTO products (category_id, name, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $db->prepare($sql);

            $created = $stmt->execute([$category_id, $name, $description, $price, $stock, $image]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $created;
}


/**
 * Update an existing product.
 *
 * @param int $product_id Product ID.
 * @param int $category_id Category ID.
 * @param string $name Product name.
 * @param string $description Product description.
 * @param float $price Product price.
 * @param float $stock Product stock.
 * @param string $image Product image.
 *
 * @return bool True if the product was updated successfully.
 */
function updateProduct(int $product_id, int $category_id, string $name, string $description, float $price, float $stock, string $image): bool
{
    $db = getPDO();
    $updated = false;

    try {
        if ($product_id > 0 && $category_id > 0 && !empty($name) && !empty($description) && $price > 0 && $stock > 0 && !empty($image)) {
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ?, category_id = ? WHERE id = ?";

            $stmt = $db->prepare($sql);

            $updated = $stmt->execute([$name, $description, $price, $stock, $image, $category_id, $product_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $updated;
}


/**
 * Delete a product.
 *
 * @param int $product_id Product ID.
 *
 * @return bool True if the product was deleted successfully.
 */
function deleteProduct(int $product_id): bool
{
    $db = getPDO();
    $deleted = false;

    try {
        if ($product_id > 0) {
            $sql = "DELETE FROM products WHERE id = ?";

            $stmt = $db->prepare($sql);

            $deleted = $stmt->execute([$product_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $deleted;
}