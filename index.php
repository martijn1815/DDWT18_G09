<?php
/**
 * Controller
 * User: martijn1815
 * Date: 06-11-18
 * Time: 22:20
 */
include 'model.php';
$db = connect_db('localhost', 'ddwt18_g09', 'ddwt18_g09','finalproject09');
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
        'DDWT18_G09' => na('/DDWT18_G09/', True),
    ]);

    $navigation = get_navigation($navigation_template, 1);

    /* Page content */
    $page_subtitle = 'The online platform to view and offer student rooms';
    $page_content = 'content';

    /* Choose Template */
    include use_template('main');
}

/* Register get*/
elseif (new_route('/DDWT18_G09/register/', 'get')){
    /* Page info */
    $page_title = 'New user';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'Register' => na('/DDWT18_G09/register', True)
    ]);
    $navigation = get_navigation($navigation_template, 2);

    /* Page content */
    $page_subtitle = 'Please fill in the following form';

    /* Choose Template */
    include use_template('register');
}

/* Register post*/
elseif (new_route('/DDWT18_G09/register/', 'post')){
    /* Register user */
    $error_msg = register_user($db, $_POST);
    /* Redirect to homepage */
    redirect(sprintf('/DDWT18_G09/register/?error_msg=%s', json_encode($error_msg)));

}
