<?php

function showAccountEdit(): void
{
    /*
        Affiche le formulaire de modification
        des informations du compte.
    */

    $user = getCurrentUser();

    view('user/account/edit', [
        'user' => $user,
    ]);
}


function updateProfile(string $name, string $email, string $address, string $new_password): void 
{
    /*
        Modifie les informations du profil.

        L'utilisateur peut modifier une ou plusieurs
        informations en même temps.
    */

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    /*
        On conserve les anciennes valeurs
        pour les champs qui ne sont pas modifiés.
    */

    $newName = $user['name'];
    $newEmail = $user['email'];
    $newAddress = $user['address'];

    /*
        Nom
    */

    $name = trim($name);

    if ($name !== '' && $name !== $user['name']) {
        $newName = $name;
    }

    /*
        Email
    */

    $email = strtolower(trim($email));

    if ($email !== '' && $email !== $user['email'] &&filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $newEmail = $email;
    }

    /*
        Adresse
    */

    $address = trim($address);

    if ($address !== '' && $address !== $user['address']) {
        $newAddress = $address;
    }

    /*
        Mot de passe

        null = aucun changement de mot de passe.
        Sinon, on hash le nouveau mot de passe
        avant de l'envoyer au Model.
    */

    $passwordHash = null;

    if ($new_password !== '') {
        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
    }

    /*
        Mise à jour en base.
    */

    $updated = updateUser($user_id, $newName, $newEmail, $newAddress, $passwordHash);

    if ($updated) {
        redirect('accountEdit');
    }

    redirect('accountEdit');
}
