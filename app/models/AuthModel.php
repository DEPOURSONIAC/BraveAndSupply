<?php

/**
 * Create a new user.
 *
 * @param string $name User's name.
 * @param string $email User's email address.
 * @param string $address User's address.
 * @param string $hashed_password Hashed user password.
 *
 * @return bool True if the user was created successfully.
 */
function createUser(string $name, string $email, string $address, string $hashed_password): bool {
    $db = getPDO();

    $created = false;

    try {
        if (!emailExists($email)) {
            $sql = "INSERT INTO users (name, email, password, address) VALUES (?, ?, ?, ?)";

            $stmt = $db->prepare($sql);
            $created = $stmt->execute([
                $name,
                $email,
                $hashed_password,
                $address,
            ]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $created;
}


/**
 * Check if an email address already exists.
 *
 * @param string $email Email address to check.
 *
 * @return bool True if the email already exists.
 */
function emailExists(string $email): bool
{
    $db = getPDO();

    $exists = false;

    try {
        $sql = "SELECT 1 FROM users WHERE email = ? LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);

        $exists = $stmt->fetch() !== false;
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $exists;
}


/**
 * Get a user by email address.
 *
 * @param string $email User's email address.
 *
 * @return array|null User data if found, otherwise null.
 */
function getUserByEmail(string $email): ?array
{
    $db = getPDO();

    $user = null;

    try {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute([$email]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $user = $result;
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $user;
}