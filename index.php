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
        'url' => '/DDWT18_G09/',
        'show' => ['logedout', 'tenant', 'owner']),
    2 => Array(
        'name' => 'Rooms Overview',
        'url' => '/DDWT18_G09/roomsoverview/',
        'show' => ['logedout', 'tenant', 'owner']),
    3 => Array(
        'name' => 'My Rooms',
        'url' => '/DDWT18_G09/myrooms/',
        'show' => ['tenant', 'owner']),
    4 => Array(
        'name' => 'User Profile',
        'url' => '/DDWT18_G09/userprofile/',
        'show' => ['tenant', 'owner']),
    5 => Array(
        'name' => 'Add Rooms',
        'url' => '/DDWT18_G09/addrooms/',
        'show' => ['owner']),
    6 => Array(
        'name' => 'Login',
        'url' => '/DDWT18_G09/login/',
        'show' => ['logedout']),
    7 => Array(
        'name' => 'Logout',
        'url' => '/DDWT18_G09/logout/',
        'show' => ['tenant', 'owner']),
    8 => Array(
        'name' => 'Register',
        'url' => '/DDWT18_G09/register/',
        'show' => ['logedout'])
);

/* Landing page */
if (new_route('/DDWT18_G09/', 'get')) {

    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', True),
    ]);

    /* Check if logged in */
    if ( check_login() ) {
        $user_status = get_user_role($db);
    } else {
        $user_status = 'logedout';
    }
    $navigation = get_navigation($navigation_template, 1, $user_status);

    /* Page content */
    $page_subtitle = 'The online platform to view and offer student rooms';
    $page_content = 'content';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('main');
}

/* Register get*/
elseif (new_route('/DDWT18_G09/register/', 'get')){
    /* Check if logged in */
    if ( check_login() ) {
        $user_status = get_user_role($db);
        $feedback = [
            'type' => 'success',
            'message' => sprintf('You are already a user.')
        ];
        redirect(sprintf('/DDWT18_G09/userprofile/?error_msg=%s',  json_encode($feedback)));
    } else {
        $user_status = 'logedout';
    }
    /* Page info */
    $page_title = 'New user';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'Register' => na('/DDWT18_G09/register', True)
    ]);
    $navigation = get_navigation($navigation_template, 8, $user_status);

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
    /* Check if logged in */
    if ( !check_login() ) {
        $user_status = 'logedout';
        $feedback = [
            'type' => 'danger',
            'message' => sprintf('You have to login to add rooms!! Please login or register as new user.')
        ];
        redirect(sprintf('/DDWT18_G09/login/?error_msg=%s',  json_encode($feedback)));
    } else {
        $user_status = get_user_role($db);
    }
    /* chech if the user is an owner*/
    if (get_user_info($db,$_SESSION['user_id'])["role"]!= "owner"){
        $feedback = [
            'type' => 'danger',
            'message' => sprintf('%s, you do not have the permission to add rooms!',
                get_username($db, $_SESSION['user_id']))
        ];
        redirect(sprintf('/DDWT18_G09/userprofile/?error_msg=%s',  json_encode($feedback)));



    }
    /* Page info */
    $page_title = 'Add new room';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'Register' => na('/DDWT18_G09/addrooms', True)
    ]);
    $navigation = get_navigation($navigation_template, 5);

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
    /* Add user */
    $error_msg = add_room($db, $_POST);

    /* Redirect to Add Room page */
    redirect(sprintf('/DDWT18_G09/addrooms/?error_msg=%s', json_encode($error_msg)));
}

/*login get*/
elseif (new_route('/DDWT18_G09/login/', 'get')){
    /* Check if logged in */
    if ( check_login() ) {
        $user_status = get_user_role($db);
        $feedback = [
            'type' => 'success',
            'message' => sprintf('You are already logged in.')
        ];
        redirect(sprintf('/DDWT18_G09/userprofile/?error_msg=%s',  json_encode($feedback)));
    } else {
        $user_status = 'logedout';
    }

    /* Page info */
    $page_title = 'Login';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18_G09/', False),
        'Login' => na('/DDWT18_G09/login', True)
    ]);
    $navigation = get_navigation($navigation_template, 6, $user_status);

    /* Page content */
    $page_subtitle = 'Please enter your username and password ';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('login');
}

/* Login post*/
elseif (new_route('/DDWT18_G09/login/', 'post')){
    /* User Login */
    $error_msg = login_user($db, $_POST);
    redirect(sprintf('/DDWT18_G09/login/?error_msg=%s', json_encode($error_msg)));

}

/* User Profile get */
elseif (new_route('/DDWT18_G09/userprofile/', 'get')){
    /* Check if logged in */
    if ( !check_login() ) {
        $user_status = 'logedout';
        $feedback = [
            'type' => 'danger',
            'message' => sprintf('You have to login first to see your profile. Please login or register as new user.')
        ];
        redirect(sprintf('/DDWT18_G09/login/?error_msg=%s',  json_encode($feedback)));
    } else {
        $user_status = get_user_role($db);
    }
    /* Page info */
    $page_title = 'My profile';
    $user = get_username($db, $_SESSION['user_id']);
    $user_role = get_user_info($db,$_SESSION['user_id'])["role"];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18_G09/', False),
        'My profile' => na('/DDWT18_G09/userprofile/', True)
    ]);
    $navigation = get_navigation($navigation_template, 4, $user_status);

    /* Page content */
    $page_subtitle = 'The overview of your profile';
    $page_content = 'Here you can manage your profile.';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('profile');
}

/* Logout get*/
elseif (new_route('/DDWT18_G09/logout/', 'get')){
    /* Page info */
    $error_msg = logout_user($db);
    redirect(sprintf('/DDWT18_G09/logout/?error_msg=%s', json_encode($error_msg)));

}

/* opt-in GET */
elseif (new_route('/DDWT18_G09/opt-in', 'get')) {
    /* Get room info from db */
    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    /* Check if logged in */
    if ( !check_login() ) {
        $user_status = 'logedout';
        redirect('/DDWT18_G09/login/');
    } else {
        $user_status = get_user_role($db);
    }
    /* Page info */
    $page_title = 'Opt-in';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18_G09/', False),
        'opt-in' => na('/DDWT18_G09/opt-in/', False),
        sprintf("Opt-in room on %s", $room_info['street']) => na('/DDWT18_G09/opt-in/room_id='.$room_id, True)
    ]);
    $navigation = get_navigation($navigation_template, 0, $user_status);
    /* Page content */
    $page_subtitle = sprintf("opt-in room on %s", $room_info['street']);
    $page_content = 'Please fill in a message to the owner with your request.';
    $submit_btn = "send";
    $form_action = '/DDWT18_G09/opt-in/';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('opt-in');
}

/* opt-in POST */
elseif (new_route('/DDWT18_G09/opt-in/', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        $user_status = 'logedout';
        redirect('/DDWT18_G09/login/');
    } else {
        $user_status = get_user_role($db);
    }
    $room_id = $_POST['room_id'];
    /* Update serie to database */
    $error_msg = opt_in($db,$room_id, $_POST);
    /* Redirect to serie GET route */
    redirect(sprintf('/DDWT18_G09/roomsoverview/?error_msg=%s', json_encode($error_msg)));

}
