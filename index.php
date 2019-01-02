<?php
/**
 * Controller
 * User: martijn1815
 * Date: 06-11-18
 * Time: 22:20
 */
include 'model.php';

$navigation_template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/DDWT18_G09/'
    ),
    2 => Array(
        'name' => 'Register',
        'url' => '/DDWT18_G09/register/'
    ),
    3 => Array(
        'name' => 'Login',
        'url' => '/DDWT18_G09/login/'
    ),
    4 => Array(
        'name' => 'User Profile',
        'url' => '/DDWT18_G09/userprofile/'
    ),
    5 => Array(
        'name' => 'Rooms Overview',
        'url' => '/DDWT18_G09/roomsoverview/'
    ),
    6 => Array(
        'name' => 'Add Rooms',
        'url' => '/DDWT18_G09/addrooms/'
    ),
    7 => Array(
        'name' => 'My Rooms',
        'url' => '/DDWT18_G09/myrooms/'
    ),
);

/* Landing page */
if (new_route('/DDWT18_G09/', 'get')) {

    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'finalproject' => na('/finalproject/', True),
    ]);

    $navigation = get_navigation($navigation_template, 1);

    /* Page content */
    $page_subtitle = 'The online platform to view and offer student rooms';
    $page_content = 'content';

    /* Choose Template */

}