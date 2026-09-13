<?php

/**
 * Create a new review for the current user.
 *
 * @param string $comment Review comment.
 *
 * @return void
 */
function createReview(string $comment): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $comment = trim($comment);
    $success = false;

    if ($comment !== '') {
        $added = addReview($user_id, $comment);

        if ($added) {
            $success = true;
        }
    }

    redirect('account');
}


/**
 * Delete a review from the current user.
 *
 * @param int $review_id Review ID.
 *
 * @return void
 */
function removeReview(int $review_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $success = false;

    if ($review_id > 0) {
        $deleted = deleteReview($review_id, $user_id);

        if ($deleted) {
            $success = true;
        }
    }

    redirect('account');
}
