<?php

/**
 * Register Emma Watson's current PHP session.
 *
 * @param string $session_id The PHP session ID.
 *
 * @return bool True if the session was successfully registered.
 */
function registerEmmaSession(string $session_id): bool
{
    $db = getPDO();

    $sql = " INSERT INTO ctf_sessions (user_id, session_id) VALUES (9, ?)";

    $stmt = $db->prepare($sql);

    return $stmt->execute([$session_id]);
}

/**
 * Get Emma Watson's latest registered PHP session.
 *
 * @return string|null The latest session ID, or null if no session was found.
 */
function getLatestEmmaSession(): ?string
{
    $pdo = getPDO();

    $sql = "SELECT session_id FROM ctf_sessions WHERE user_id = 9 ORDER BY created_at DESC LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $session_id = $stmt->fetchColumn();

    return $session_id !== false ? $session_id : null;
}