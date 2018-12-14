<?php
/**
 * Controller
 * User: martijn1815
 * Date: 06-11-18
 * Time: 22:20
 */

$navigation_template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/finalproject/'
    ),
    2 => Array(
        'name' => 'Register',
        'url' => '/finalproject/register/'
    ),
    3 => Array(
        'name' => 'Login',
        'url' => '/finalproject/login/'
    ),
    4 => Array(
        'name' => 'User Profile',
        'url' => '/finalproject/userprofile/'
    ),
    5 => Array(
        'name' => 'Rooms Overview',
        'url' => '/finalproject/roomsoverview/'
    ),
    6 => Array(
        'name' => 'Add Rooms',
        'url' => '/finalproject/addrooms/'
    ),
    7 => Array(
        'name' => 'My Rooms',
        'url' => '/finalproject/myrooms/'
    ),
);

/* Landing page */
if (new_route('/DDWT18/week2/', 'get')) {

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