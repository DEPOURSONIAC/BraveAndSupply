<?php

/**
 * Display the account edit form.
 *
 * @return void
 */
function showAccountEdit(): void
{
    $user = getCurrentUser();

    view('user/account/edit', [
        'user' => $user
    ]);
}


/**
 * Update the user's profile information.
 *
 * The user can update one or more fields at the same time.
 *
 * @param string $name New user name.
 * @param string $email New user email.
 * @param string $address New user address.
 * @param string $new_password New password, or an empty string to keep the current password.
 *
 * @return void
 */
function updateProfile(string $name, string $email, string $address, string $new_password): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    // Keep the current values for fields that are not changed.
    $newName = $user['name'];
    $newEmail = $user['email'];
    $newAddress = $user['address'];

    // Name.
    $name = trim($name);

    if ($name !== '' && $name !== $user['name']) {
        $newName = $name;
    }

    // Email.
    $email = strtolower(trim($email));

    if ($email !== '' && $email !== $user['email'] && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $newEmail = $email;
    }

    // Address.
    $address = trim($address);

    if ($address !== '' && $address !== $user['address']) {
        $newAddress = $address;
    }

    // Password.
    $passwordHash = null;

    if ($new_password !== '') {
        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
    }

    // Update the user in the database.
    $updated = updateUser($user_id, $newName, $newEmail, $newAddress, $passwordHash);

    if ($updated) {
        redirect('accountEdit');
    }

    redirect('accountEdit');
}