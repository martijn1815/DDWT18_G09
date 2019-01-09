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
        'show' => ['owner']),
    4 => Array(
        'name' => 'Add Room',
        'url' => '/DDWT18_G09/addrooms/',
        'show' => ['owner']),
    5 => Array(
        'name' => 'Messages',
        'url' => '/DDWT18_G09/messagesoverview/',
        'show' => ['tenant', 'owner']),
    6 => Array(
        'name' => 'User Profile',
        'url' => '/DDWT18_G09/userprofile/',
        'show' => ['tenant', 'owner']),
    7 => Array(
        'name' => 'Login',
        'url' => '/DDWT18_G09/login/',
        'show' => ['logedout']),
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
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Page content */
    $page_subtitle = 'The online platform to view and offer student rooms';
    $page_content = 'content';
    /* Choose Template */
    include use_template('main');
}
/* Rooms Overview */
if (new_route('/DDWT18_G09/roomsoverview', 'get')) {
    /* Page info */
    $page_title = 'Rooms Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'Rooms Overview' => na('/DDWT18_G09/roomsoverview', True)
    ]);
    /* Check if logged in */
    if ( check_login() ) {
        $user_status = get_user_role($db);
    } else {
        $user_status = 'logedout';
    }
    $navigation = get_navigation($navigation_template, 2, $user_status);
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Page content */
    $rooms_table = get_rooms_table(get_rooms($db),$db);
    /* Choose Template */
    include use_template('rooms');
}
/* My Rooms GET*/
if (new_route('/DDWT18_G09/myrooms', 'get')) {
    /* Page info */
    $page_title = 'My Rooms';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'My Rooms' => na('/DDWT18_G09/myrooms', True)
    ]);
    /* Check if logged in */
    if ( check_login() ) {
        $user_status = get_user_role($db);
    } else {
        $user_status = 'logedout';
    }
    $navigation = get_navigation($navigation_template, 3, $user_status);
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Page content */
    $rooms_table = get_myrooms_table(get_rooms($db));
    /* Choose Template */
    include use_template('rooms');
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
    $form_action = '/DDWT18_G09/register/';
    $button_text = 'Register';
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
/* Add Rooms GET*/
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
        'Add Room' => na('/DDWT18_G09/addrooms', True)
    ]);
    $navigation = get_navigation($navigation_template, 4, $user_status);
    /* Page content */
    $page_subtitle = '';
    $form_action = "/DDWT18_G09/addrooms/";
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose Template */
    include use_template('addroom');
}
/* Add Rooms POST*/
elseif (new_route('/DDWT18_G09/addrooms/', 'post')){
    /* Add user */
    $error_msg = add_room($db, $_POST);
    /* Redirect to Add Room page */
    redirect(sprintf('/DDWT18_G09/myrooms/?error_msg=%s', json_encode($error_msg)));
}
/* Edit Rooms GET*/
elseif (new_route('/DDWT18_G09/myrooms/edit', 'get')){
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
        redirect(sprintf('/DDWT18_G09/myrooms/?error_msg=%s',  json_encode($feedback)));
    }
    /* Get room info from db */
    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    /* Page info */
    $page_title = 'Edit room';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'My Rooms' => na('/DDWT18_G09/myrooms', False),
        'Edit Room' => na('/DDWT18_G09/myrooms/edit', True)
    ]);
    $navigation = get_navigation($navigation_template, 3, $user_status);
    /* Page content */
    $page_subtitle = '';
    $form_action = "/DDWT18_G09/myrooms/edit";
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose Template */
    include use_template('addroom');
}
/* Edit Room POST*/
elseif (new_route('/DDWT18_G09/myrooms/edit', 'post')){
    /* Add user */
    $error_msg = update_room($db, $_POST);
    /* Redirect to Add Room page */
    redirect(sprintf('/DDWT18_G09/myrooms/?error_msg=%s', json_encode($error_msg)));
}
/* Remove Room POST */
elseif (new_route('/DDWT18_G09/myrooms/remove', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18_G09/login/');
    }
    /* Remove serie in database */
    $feedback = remove_room($db, $_POST['id']);
    /* Redirect to serie GET route */
    redirect(sprintf('/DDWT18_G09/myrooms/?error_msg=%s', json_encode($feedback)));
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
    $navigation = get_navigation($navigation_template, 7, $user_status);
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
    $navigation = get_navigation($navigation_template, 6, $user_status);
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
//* Single room */
elseif (new_route('/DDWT18_G09/roomsoverview/room', 'get')) {
    /* Get rooms from db */
    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    if (check_login()){
        $user_status = get_user_role($db);
    }else{
        $user_status = "logedout";
    }
    /* Page info */
    $page_title = $room_info['room_title'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18_G09/', False),
        'roomsoverview' => na('/DDWT18_G09/roomsoverview/', False),
        $room_info['room_title'] => na('/DDWT18_G09/roomsoverview/room/?room_id='.$room_id, True)
    ]);
    $navigation = get_navigation($navigation_template, 2, $user_status);
    /* Page content */
    $description = $room_info['description'];
    $room_table = get_room_table($db, $room_info);
    /*check if the user logged in*/
    if (check_login()) {
        $user = get_username($db, $_SESSION['user_id']);
        $user_role = get_user_info($db, $_SESSION['user_id'])["role"];
    };
    $page_subtitle = sprintf("Information about %s", $room_info['room_title']);
    /* Check if the correct user logged in to edit or remove the room*/
    if ( check_login() ) {
        $display_buttons = ($room_info['owner_id'] == $_SESSION['user_id'])? true : false;
    } else {
        $display_buttons = false;
    }
    /* Choose Template */
    include use_template('single_room');
}
/* opt-in GET */
elseif (new_route('/DDWT18_G09/roomsoverview/room/opt-in', 'get')) {
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
        'roomsoverview' => na('/DDWT18_G09/roomsoverview/', False),
        'opt-in' => na('/DDWT18_G09/roomsoverview/room/opt-in/', False),
        sprintf("Opt-in room %s", $room_info['room_title']) => na('/DDWT18_G09/roomsoverview/room/opt-in/?room_id='.$room_id, True)
    ]);
    $navigation = get_navigation($navigation_template, 0, $user_status);
    /* Page content */
    $page_subtitle = sprintf("opt-in room %s", $room_info['room_title']);
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
elseif (new_route('/DDWT18_G09/roomsoverview/room/opt-in', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        $user_status = 'logedout';
        redirect('/DDWT18_G09/login/');
    } else {
        $user_status = get_user_role($db);
    }
    $error_msg = opt_in($db, $_POST);
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18_G09/roomsoverview/?error_msg=%s', json_encode($error_msg)));
}

/* Messages Overview GET */
elseif (new_route('/DDWT18_G09/messagesoverview/', 'get')) {
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

    /* Page info */
    $page_title = 'Messages Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18_G09/', False),
        'Messages' => na('/DDWT18_G09/messsagesoverview/', True),
    ]);
    $navigation = get_navigation($navigation_template, 5, $user_status);
    /* Page content */
    $page_subtitle = '';
    $page_content = get_messages_view($db, get_messages($db));
    $submit_btn = '';
    $form_action = '';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose Template */
    include use_template('messages');
}
/* Remove Message POST */
elseif (new_route('/DDWT18_G09/messsagesoverview/remove', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18_G09/login/');
    }
    /* Remove serie in database */
    $feedback = remove_message($db, $_POST['id']);
    /* Redirect to serie GET route */
    redirect(sprintf('/DDWT18_G09/messagesoverview/?error_msg=%s', json_encode($feedback)));
}
/* Update Profile get*/
elseif (new_route('/DDWT18_G09/userprofile/update/', 'get')){
    /* Check if logged in */
    if ( !check_login() ) {
        $user_status = 'logedout';
        $feedback = [
            'type' => 'danger',
            'message' => sprintf('You have to be logged in! Please login or register as new user.')
        ];
        redirect(sprintf('/DDWT18_G09/login/?error_msg=%s',  json_encode($feedback)));
    } else {
        $user_status = get_user_role($db);
    }
    /* Page info */
    $page_title = 'Update user information';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18_G09' => na('/DDWT18_G09/', False),
        'My Profile' => na('/DDWT18_G09/userprofile/', False),
        'Update Profile' => na('/DDWT18_G09/userprofile/update/', True)
    ]);
    $navigation = get_navigation($navigation_template, 6, $user_status);
    /* Page content */
    $page_subtitle = '';
    $form_action = '/DDWT18_G09/userprofile/update/';
    $user_info = get_user_info($db, get_user_id2());
    $user_info_language = get_user_info_languages($db, get_user_id2());
    $button_text = 'Update';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose Template */
    include use_template('register');
}
/* Update Profile post*/
elseif (new_route('/DDWT18_G09/userprofile/update/', 'post')){
    /* Register user */
    $error_msg = update_user($db, $_POST);
    /* Redirect to homepage */
    redirect(sprintf('/DDWT18_G09/userprofile/?error_msg=%s', json_encode($error_msg)));
}
/* Remove Profile post*/
elseif (new_route('/DDWT18_G09/userprofile/remove/', 'post')){
    /* Register user */
    $error_msg = remove_user($db, $_POST['id']);
    /* Redirect to homepage */
    redirect(sprintf('/DDWT18_G09/login/?error_msg=%s', json_encode($error_msg)));
}

/* User table GET */
elseif (new_route('/DDWT18_G09/messagesoverview/userinformation', 'get')) {
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

    /* Page info */
    $page_title = 'User information';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18_G09/', False),
        'Messages' => na('/DDWT18_G09/messsagesoverview/', False),
        'User Information' => na('/DDWT18_G09/messsagesoverview/userinformation', True),
    ]);
    $navigation = get_navigation($navigation_template, 5, $user_status);
    /* Page content */
    $page_subtitle = '';
    $user_table = get_user_table(get_user_info($db, $_GET['user_id']));
    $submit_btn = '';
    $form_action = '';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose Template */
    include use_template('user_info');
}