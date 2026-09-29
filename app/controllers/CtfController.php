<?php

/**
 * Display Emma Watson's CTF session information.
 *
 * @return void
 */
function showSession(): void
{
    $session_id = getLatestEmmaSession();

    view('annex/session', [
        'session_id' => $session_id
    ]);
}