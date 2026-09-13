<?php

/**
 * Get all categories.
 *
 * @return array List of all categories.
 */
function getAllCategories(): array
{
    $db = getPDO();
    $categories = [];

    try {
        $sql = "SELECT * FROM categories ORDER BY id ASC";

        $stmt = $db->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $categories;
}


/**
 * Get a category by its ID.
 *
 * @param int $category_id Category ID.
 *
 * @return array|null Category data if found, otherwise null.
 */
function getCategoryById(int $category_id): ?array
{
    $db = getPDO();
    $category = null;

    try {
        $sql = "SELECT * FROM categories WHERE id = ? LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$category_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $category = $result ?: null;
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $category;
}


/**
 * Create a new category.
 *
 * @param string $name Category name.
 *
 * @return bool True if the category was created successfully.
 */
function createCategory(string $name): bool
{
    $db = getPDO();
    $created = false;

    try {
        if (!empty($name)) {
            $sql = "INSERT INTO categories (name) VALUES (?)";

            $stmt = $db->prepare($sql);
            $created = $stmt->execute([$name]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $created;
}


/**
 * Update a category.
 *
 * @param int $category_id Category ID.
 * @param string $name New category name.
 *
 * @return bool True if the category was updated successfully.
 */
function updateCategory(int $category_id, string $name): bool
{
    $db = getPDO();
    $updated = false;

    try {
        if (!empty($name)) {
            $sql = "UPDATE categories SET name = ? WHERE id = ?";

            $stmt = $db->prepare($sql);
            $updated = $stmt->execute([$name, $category_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $updated;
}


/**
 * Delete a category.
 *
 * @param int $category_id Category ID.
 *
 * @return bool True if the category was deleted successfully.
 */
function deleteCategory(int $category_id): bool
{
    $db = getPDO();
    $deleted = false;

    try {
        $sql = "DELETE FROM categories WHERE id = ?";

        $stmt = $db->prepare($sql);
        $deleted = $stmt->execute([$category_id]);
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $deleted;
}


/**
 * Get all products from a category.
 *
 * @param int $category_id Category ID.
 *
 * @return array List of products in the category.
 */
function getProductsByCategory(int $category_id): array
{
    $db = getPDO();
    $products = [];

    try {
        $sql = "SELECT * FROM products WHERE category_id = ? ORDER BY id DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([$category_id]);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $products;
}