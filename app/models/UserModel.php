<?php

/**
 * Get a user by their ID.
 *
 * @param int $user_id User ID.
 *
 * @return array|null User data if found, otherwise null.
 */
function getUserById(int $user_id): ?array
{
    $db = getPDO();
    $user = null;

    try {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = $result;
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $user;
}


/**
 * Get all users.
 *
 * @return array List of all users.
 */
function getAllUsers(): array
{
    $db = getPDO();
    $users = [];

    try {
        $sql = "SELECT * FROM users ORDER BY id DESC";

        $stmt = $db->query($sql);

        if ($stmt) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $users;
}


/**
 * Update a user's information.
 *
 * The password must already be hashed before being passed to this function.
 *
 * @param int $user_id User ID.
 * @param string $name User name.
 * @param string $email User email.
 * @param string $address User address.
 * @param string|null $passwordHash Hashed password, or null to keep the current password.
 *
 * @return bool True if the user was updated successfully.
 */
function updateUser(int $user_id, string $name, string $email, string $address, ?string $passwordHash = null): bool
{
    $db = getPDO();
    $updated = false;

    try {
        $name = trim($name);
        $email = strtolower(trim($email));
        $address = trim($address);

        if ($user_id > 0 && $name !== '' && $email !== '' && $address !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($passwordHash !== null) {
                $sql = "UPDATE users SET name = ?, email = ?, address = ?, password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

                $stmt = $db->prepare($sql);

                $updated = $stmt->execute([$name, $email, $address, $passwordHash, $user_id]);
            } else {
                $sql = "UPDATE users SET name = ?, email = ?, address = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

                $stmt = $db->prepare($sql);

                $updated = $stmt->execute([$name, $email, $address, $user_id]);
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $updated;
}


/**
 * Delete a user.
 *
 * @param int $user_id User ID.
 *
 * @return bool True if the user was deleted successfully.
 */
function deleteUser(int $user_id): bool
{
    $db = getPDO();
    $deleted = false;

    try {
        if ($user_id > 0) {
            $sql = "DELETE FROM users WHERE id = ?";

            $stmt = $db->prepare($sql);

            $deleted = $stmt->execute([$user_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $deleted;
}