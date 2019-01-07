<?php
/**
 * Controller
 * User: martijn1815
 * Date: 06-11-18
 * Time: 22:20
 */
include 'model.php';

$db = connect_db('localhost', 'ddwt18_g09', 'ddwt18_09','ddwt18_09');
$navigation_template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/DDWT18_G09/'),
    2 => Array(
        'name' => 'Register',
        'url' => '/DDWT18_G09/register/'),
    3 => Array(
        'name' => 'Login',
        'url' => '/DDWT18_G09/login/'),
    4 => Array(
        'name' => 'User Profile',
        'url' => '/DDWT18_G09/userprofile/'),
    5 => Array(
        'name' => 'Rooms Overview',
        'url' => '/DDWT18_G09/roomsoverview/'),
    6 => Array(
        'name' => 'Add Rooms',
        'url' => '/DDWT18_G09/addrooms/'),
    7 => Array(
        'name' => 'My Rooms',
        'url' => '/DDWT18_G09/myrooms/')
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
    $navigation = get_navigation($navigation_template, 6);

    /* Page content */
    $page_subtitle = 'Please register by filling in the following form';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

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

/* Add Rooms get*/
elseif (new_route('/DDWT18_G09/addrooms/', 'get')){
    /* Page info */
    $page_title = 'Add new room';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'Register' => na('/DDWT18_G09/addrooms', True)
    ]);
    $navigation = get_navigation($navigation_template, 2);

    /* Page content */
    $page_subtitle = '';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('addroom');
}

/* Add Rooms post*/
elseif (new_route('/DDWT18_G09/addrooms/', 'post')){
    /* Register user */
    $error_msg = add_room($db, $_POST);
    /* Redirect to homepage */
    redirect(sprintf('/DDWT18_G09/addrooms/?error_msg=%s', json_encode($error_msg)));
}




/* opt-in GET */
elseif (new_route('/DDWT18_G09/opt-in', 'get')) {
    /* Get room info from db */
    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18_G09/login/');
    }
    /* Page info */
    $page_title = 'Opt-in';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18_G09/', False),
        'Week 2' => na('/DDWT18_G09/opt-in/', False),
        sprintf("Opt-in room on %s", $room_info['street']) => na('/DDWT18_G09/opt-in/room_id='.$room_id, True)
    ]);
    $navigation = get_navigation($navigation_template, 0);
    /* Page content */
    $page_subtitle = sprintf("opt-in room on %s", $room_info['street']);
    $page_content = 'Please fill in a message to the owner with your request.';
    $submit_btn = "send";
    $form_action = '/DDWT18_G09/opt-in/';

    /* Choose Template */
    include use_template('opt-in');
}

/* opt-in POST */
elseif (new_route('/DDWT18_G09/opt-in/', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18_G09/login/');
    }
    $room_id = $_POST['room_id'];
    /* Update serie to database */
    $error_msg = opt_in($db,$room_id, $_POST);
    /* Redirect to serie GET route */
    redirect(sprintf('/DDWT18_G09/roomsoverview/?error_msg=%s', json_encode($error_msg)));

}
