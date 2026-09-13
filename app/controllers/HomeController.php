<?php

/**
 * Display the home page.
 *
 * Gets products from the different categories
 * and loads the view.
 *
 * @return void
 */
function showHome(): void
{
    $hommes = getProductsByCategory(CATEGORY_HOMME);
    $femmes = getProductsByCategory(CATEGORY_FEMME);
    $kids = getProductsByCategory(CATEGORY_KIDS);

    $reviews = getAllReviews();

    view('home', [
        'hommes' => $hommes,
        'femmes' => $femmes,
        'kids' => $kids,
        'reviews' => $reviews
    ]);
}


/**
 * Display the contact page.
 *
 * @return void
 */
function showContact(): void
{
    view('annex/contact');
}


/**
 * Display the about page.
 *
 * @return void
 */
function showAbout(): void
{
    view('annex/about');
}