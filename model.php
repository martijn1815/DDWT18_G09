<?php
/**
 * Model
 * User: martijn1815
 * Date: 06-11-18
 * Time: 22:20
 */

/* Enable error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Connects to the database using PDO
 * @param string $host database host
 * @param string $db database name
 * @param string $user database user
 * @param string $pass database password
 * @return pdo object
 */
function connect_db($host, $db, $user, $pass){
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        echo sprintf("Failed to connect. %s",$e->getMessage());
    }
    return $pdo;
}
/**
 * Changes the HTTP Header to a given location
 * @param string $location location to be redirected to
 */
function redirect($location){
    header(sprintf('Location: %s', $location));
    die();
}

/**
 * Check if the route exist
 * @param string $route_uri URI to be matched
 * @param string $request_type request method
 * @return bool
 *
 */
function new_route($route_uri, $request_type){
    $route_uri_expl = array_filter(explode('/', $route_uri));
    $current_path_expl = array_filter(explode('/',parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    if ($route_uri_expl == $current_path_expl && $_SERVER['REQUEST_METHOD'] == strtoupper($request_type)) {
        return True;
    }
}

/**
 * Creates breadcrumb HTML code using given array
 * @param array $breadcrumbs Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the breadcrumbs
 */
function get_breadcrumbs($breadcrumbs) {
    $breadcrumbs_exp = '
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">';
    foreach ($breadcrumbs as $name => $info) {
        if ($info[1]){
            $breadcrumbs_exp .= '<li class="breadcrumb-item active" aria-current="page">'.$name.'</li>';
        }else{
            $breadcrumbs_exp .= '<li class="breadcrumb-item"><a href="'.$info[0].'">'.$name.'</a></li>';
        }
    }
    $breadcrumbs_exp .= '
    </ol>
    </nav>';
    return $breadcrumbs_exp;
}

/**
 * Creates a new navigation array item using url and active status
 * @param string $url The url of the navigation item
 * @param bool $active Set the navigation item to active or inactive
 * @return array
 */
function na($url, $active){
    return [$url, $active];
}

/**
 * Creates filename to the template
 * @param string $template filename of the template without extension
 * @return string
 */
function use_template($template){
    $template_doc = sprintf("views/%s.php", $template);
    return $template_doc;
}

/**
 * Creats HTML alert code with information about the success or failure
 * @param bool $type True if success, False if failure
 * @param string $message Error/Success message
 * @return string
 */
function get_error($feedback){
    $feedback = json_decode($feedback, True);
    $error_exp = '
        <div class="alert alert-'.$feedback['type'].'" role="alert">
            '.$feedback['message'].'
        </div>';
    return $error_exp;
}

/**
 * @param PDO $pdo
 * @param $form_data
 * @return array
 */
function register_user($pdo, $form_data){
    /* Check if all fields are set */
    $fields = ['username', 'password', 'firstname', 'lastname', 'street', 'zip', 'city', 'phone', 'mail', 'biography', 'profession', 'date_of_birth', 'role', 'gender', 'lang'];
    foreach ($fields as $value) {
        if (empty($form_data[$value])) {
            return [
                'type' => 'danger',
                'message' => sprintf('Form not complete, please fill in %s.', $value)
            ];
        }
    }
    /*check username special characters*/
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $form_data['username'])){
        return [
            'type' => 'danger',
            'message' => 'The username you entered contains not allowed character!'
        ];
    }else {
        /* Check if user already exists */
        try {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute([$form_data['username']]);
            $user_exists = $stmt->rowCount();
        } catch (\PDOException $e) {
            return [
                'type' => 'danger',
                'message' => sprintf('There was an error: %s', $e->getMessage())
            ];
        }
    }
    if (!empty($user_exists)){
        return [
            'type' => 'danger',
            'message' => 'The username you entered does already exists!'
        ];
    }

    /* Check data types */

    if (strlen($form_data['password']) < 8){
        return [
            'type' => 'danger',
            'message' => 'The password must contain at least 8 characters'
        ];
    }elseif (!preg_match("#[0-9]+#", $form_data['password'])){
        return [
            'type' => 'danger',
            'message' => 'The password must contain at least 1 number!'
        ];

    }elseif (!preg_match("#[A-Z]+#", $form_data['password'])){
        return [
            'type' => 'danger',
            'message' => 'The password must contain at least 1 capital letter!'
        ];

    }elseif (!preg_match("#[a-z]+#", $form_data['password'])) {
        return [
            'type' => 'danger',
            'message' => 'The password must contain at least 1 small letter!'
        ];
    }else{
        $password = password_hash($form_data['password'], PASSWORD_DEFAULT);
    }
    /* ...To be added... */

    /* Hash password */


    /* Save user to the database */
    try {
        $stmt = $pdo->prepare('INSERT INTO users (username, password, first_name, last_name, street, zip, city, phone_number, email, biography, date_of_birth, role, gender, profession) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $form_data['username'],
            $password,
            $form_data['firstname'],
            $form_data['lastname'],
            $form_data['street'],
            $form_data['zip'],
            $form_data['city'],
            $form_data['phone'],
            $form_data['mail'],
            $form_data['biography'],
            date("y-m-d", strtotime($form_data['date_of_birth'])),
            $form_data['role'],
            $form_data['gender'],
            $form_data['profession']
        ]);
        $user_id = $pdo->lastInsertId();
        foreach ($form_data['lang'] as $language) {
            $stmt = $pdo->prepare('INSERT INTO languages (user_id, language) VALUES (?, ?)');
            $stmt->execute([$user_id, $language]);
        }
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }

    /* Login user and redirect */
    session_start();
    $_SESSION['user_id'] = $user_id;
    $feedback = [
        'type' => 'success',
        'message' => sprintf('%s, your account was successfully created!', get_username($pdo, $_SESSION['user_id']))
    ];
    redirect(sprintf('/DDWT18_G09/?error_msg=%s', json_encode($feedback)));
}

/**
 * @param PDO $pdo
 * @param $form_data
 */
function login_user($pdo, $form_data){
    /* Check if all fields are set */
    if (
        empty($form_data['username']) or
        empty($form_data['password'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should enter a username and password.'
        ];
    }

    /* Check if user exists */
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$form_data['username']]);
        $user_exists = $stmt->rowCount();
    } catch (\PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    if (empty($user_exists)){
        return [
            'type' => 'danger',
            'message' => 'The username you entered does not exists!'
        ];
    }

    /* Check password */
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$form_data['username']]);
        $user_info = $stmt->fetch();
    } catch (\PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    if ( !password_verify($form_data['password'], $user_info['password']) ){
        return [
            'type' => 'danger',
            'message' => 'Password is incorrect'
        ];
    }

    /* Login user and redirect */
    session_start();
    $_SESSION['user_id'] = $user_info['id'];
    $feedback = [
        'type' => 'success',
        'message' => sprintf('%s, you were logged in successfully!', get_username($pdo, $_SESSION['user_id']))
    ];
    redirect(sprintf('/DDWT18_G09/userprofile/?error_msg=%s', json_encode($feedback)));
}

/**
 * Get current user id
 * @return bool current user id or False if not logged in
 */
function get_user_id(){
    session_start();
    if (isset($_SESSION['user_id'])){
        return $_SESSION['user_id'];
    } else {
        return False;
    }
}

/**
 * Get current user id, no session_start()
 * @return bool current user id or False if not logged in
 */
function get_user_id2(){
    if (isset($_SESSION['user_id'])){
        return $_SESSION['user_id'];
    } else {
        return False;
    }
}

/**
 * Returns the name of a user based on a specific user id
 * @param PDO $pdo
 * @param $user_id
 * @return string
 */
function get_username($pdo, $user_id){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    return $user['first_name'].' '.$user['last_name'];
}

/**
 * Returns the role of a user based on a specific user id
 * @param PDO $pdo
 * @param $user_id
 * @return string
 */
function get_user_role($pdo){
    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else {
        return False;
    }
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    return $user['role'];
}

/**
 * Check if a user is logged in
 * @return bool
 */
function check_login(){
    if(!isset($_SESSION))
    {
        session_start();
    }
    if (isset($_SESSION['user_id'])){
        return True;
    } else {
        return False;
    }
}

/**
 * Logout current user
 */
function logout_user($pdo){
    session_start();

    $feedback = [
        'type' => 'success',
        'message' => sprintf('%s, you were logged out successfully!',
            get_username($pdo, $_SESSION['user_id']))
    ];
    session_destroy();
    redirect(sprintf('/DDWT18_G09/?error_msg=%s',  json_encode($feedback)));
}

/**
 * Add a room to database
 * @param PDO $pdo
 * @param $form_data
 * @return array
 */
function add_room($pdo, $form_data){
    /* Check if all fields are set */
    $fields = ['room_title', 'type', 'size_m2', 'price', 'services_including', 'furnished', 'street', 'zip', 'city', 'description', 'available_from', 'available_till', 'description'];
    foreach ($fields as $value) {
        if (empty($form_data[$value])) {
            return [
                'type' => 'danger',
                'message' => sprintf('Form not complete, please fill in %s.', $value)
            ];
        }
    }

    /* Check data type */
    /* ...to be added */

    /* Check if room already exists */
    /*
    $stmt = $pdo->prepare('SELECT * FROM series WHERE name = ?');
    $stmt->execute([$serie_info['Name']]);
    $serie = $stmt->rowCount();
    if ($serie){
        return [
            'type' => 'danger',
            'message' => 'This series was already added.'
        ];
    }
    */

    /* Get user info */
    session_start();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user_info = $stmt->fetch();

    /* Add Room */
    $stmt = $pdo->prepare("INSERT INTO rooms (owner_id, room_title, size_m2, zip, street, city, description, type, available_from, available_till, furnished, price, services_including) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_info['id'],
        $form_data['room_title'],
        $form_data['size_m2'],
        $form_data['zip'],
        $form_data['street'],
        $form_data['city'],
        $form_data['description'],
        $form_data['type'],
        date("y-m-d", strtotime($form_data['available_from'])),
        date("y-m-d", strtotime($form_data['available_till'])),
        $form_data['furnished'],
        $form_data['price'],
        $form_data['services_including']
    ]);
    $inserted = $stmt->rowCount();
    if ($inserted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf('Room %s added to database.', $form_data['room_title'])
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The room was not added. Try it again.'
        ];
    }
}

function update_room($pdo, $form_data){
    /* Check if all fields are set */
    $fields = ['room_title', 'type', 'size_m2', 'price', 'services_including', 'furnished', 'street', 'zip', 'city', 'description', 'available_from', 'available_till', 'description'];
    foreach ($fields as $value) {
        if (empty($form_data[$value])) {
            return [
                'type' => 'danger',
                'message' => sprintf('Form not complete, please fill in %s.', $value)
            ];
        }
    }

    /* Check data type */
    /* ...to be added */

    /* Check if user is creator */
    if ( !isset($_SESSION['user_id']) and $_SESSION['user_id'] != $form_data['owner_id']) {
        return [
            'type' => 'danger',
            'message' => 'User is not creator of this serie'
        ];
    }

    /* Check if room already exists */
    /*
    $stmt = $pdo->prepare('SELECT * FROM series WHERE name = ?');
    $stmt->execute([$serie_info['Name']]);
    $serie = $stmt->rowCount();
    if ($serie){
        return [
            'type' => 'danger',
            'message' => 'This series was already added.'
        ];
    }
    */

    /* Get user info */
    session_start();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user_info = $stmt->fetch();

    /* Add Room */
    $stmt = $pdo->prepare("UPDATE rooms SET owner_id = ?, room_title = ?, size_m2 = ?, zip = ?, street = ?, city = ?, description = ?, type = ?, available_from = ?, available_till = ?, furnished = ?, price = ?, services_including = ? WHERE id = ?");
    $stmt->execute([
        $user_info['id'],
        $form_data['room_title'],
        $form_data['size_m2'],
        $form_data['zip'],
        $form_data['street'],
        $form_data['city'],
        $form_data['description'],
        $form_data['type'],
        date("y-m-d", strtotime($form_data['available_from'])),
        date("y-m-d", strtotime($form_data['available_till'])),
        $form_data['furnished'],
        $form_data['price'],
        $form_data['services_including'],
        $form_data['id']
    ]);
    $updated = $stmt->rowCount();
    if ($updated ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf('Room %s updated in the database.', $form_data['room_title'])
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The room was not updated. Try it again.'
        ];
    }
}

/**
 * Get array with all listed rooms from the database
 * @param object $pdo database object
 * @return array Associative array with all rooms
 */
function get_rooms($pdo){
    $stmt = $pdo->prepare('SELECT * FROM rooms');
    $stmt->execute();
    $rooms = $stmt->fetchAll();
    $rooms_exp = Array();

    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $rooms_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $rooms_exp;
}

/**
 * Creats a Bootstrap table with a list of rooms
 * @param array $rooms with rooms from the db
 * @param $pdo
 * @return string
 */
function get_rooms_table($rooms,$pdo){
    $table_exp = '
    <table class="table table-hover">
    <thead class="thead-dark">
    <tr>
        <th scope="col" style="width: 30%">Room</th>
        <th scope="col" style="width: 15%; text-align: center;">Size</th>
        <th scope="col" style="width: 15%; text-align: center;">Price</th>
        <th scope="col" style="width: 30%; text-align: center;">Already opted in</th>
    </tr>
    </thead>
    <tbody>';
    foreach($rooms as $key => $value){
        $table_exp .= '
        <tr class="clickable-row" data-href="/DDWT18_G09/roomsoverview/room/?room_id='.$value['id'].'">
            <td style="width: 30%">'.$value['room_title'].'</td>
            <td style="width: 15%; text-align: center;">'.$value['size_m2'].'m<sup>2</sup></td>
            <td style="width: 15%; text-align: center;">&euro;'.number_format($value['price'], 2).'</td>
            <td style="width: 30%; text-align: center;">'.count_opt_in($pdo, $value['id']).'</td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Creats a Bootstrap table with a list of rooms
 * @param object $db pdo object
 * @param array $rooms with rooms from the db
 * @return string
 */
function get_myrooms_table($rooms){

    $user_id = $_SESSION['user_id'];
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col" style="width: 50%">Room</th>
        <th scope="col" style="width: 15">Size</th>
        <th scope="col" style="width: 15%">Price</th>
        <th scope="col" style="width: 10%"></th>
        <th scope="col" style="width: 10%"></th>
    </tr>
    </thead>
    <tbody>';
    foreach($rooms as $key => $value){
        if ($value['owner_id'] == $user_id) {
            $table_exp .= '
            <tr class="clickable-row" data-href="/DDWT18_G09/roomsoverview/room/?room_id='.$value['id'].'">
                <td style="width: 50%">' . $value['room_title'] . '</td>
                <td style="width: 15%">' . $value['size_m2'] . 'm<sup>2</sup></td>
                <td style="width: 15%">&euro;' . number_format($value['price'], 2) . '</td>
                <td style="width: 10%"><a href="/DDWT18_G09/myrooms/edit/?room_id=' . $value['id'] . '" role="button" class="btn btn-primary">Edit</a></td>
                <td style="width: 10%">
                    <form action="/DDWT18_G09/myrooms/remove/" method="POST">
                        <input type="hidden" value="'.$value['id'].'" name="id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            ';
        }
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Generates an array with room information
 * @param object $pdo db object
 * @param int $room_id id from the room
 * @return mixed
 */
function get_room_info($pdo, $room_id){
    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
    $stmt->execute([$room_id]);
    $room_info = $stmt->fetch();
    $room_info_exp = Array();

    /* Create array with htmlspecialchars */
    foreach ($room_info as $key => $value){
        $room_info_exp[$key] = htmlspecialchars($value);
    }
    return $room_info_exp;
}

function get_room_table($pdo, $room_info){
    $owner_id = $room_info["owner_id"];
    $owner = get_username($pdo, $owner_id);
        $table_exp = '<table class="table table-striped">
                <tbody>
                <tr>
                    <th scope="row">Address</th>
                    <td>' . $room_info['street'] . ', ' . $room_info['zip'] . ', ' . $room_info['city'] . '.</td>
                </tr>
                <tr>
                    <th scope="row">Owner</th><td>' . $owner . '</td>
                </tr>
                <tr>
                    <th scope="row">Type</th>
                    <td>' . $room_info['type'] . '</td>
                </tr>
                <tr>
                    <th scope="row">Size</th> <td>' . $room_info['size_m2'] . ' m&sup2</td>
                </tr>
                <tr>
                    <th scope="row">Available from</th><td>' . $room_info['available_from'] . '</td>
                </tr>
                <tr>
                    <th scope="row">Available till</th> <td>' . $room_info['available_till'] . '</td>
                </tr>
                <tr>
                    <th scope="row">Furnished</th> <td>' . $room_info['furnished'] . '</td>
                </tr>
                <tr>
                    <th scope="row">Services are included (Gas/Water/Electricity/Internet)</th><td> ' . $room_info['services_including'] . '</td>
                </tr>
                <tr>
                    <th scope="row">Price per month</th> <td>€ ' . $room_info['price'] . '</td>
                </tr>

                </tbody>
            </table>';
    return $table_exp;
}

function remove_room($pdo, $room_id){
    /* Get room info */
    $room_info = get_room_info($pdo, $room_id);

    /* Check if user is creator */
    if ( !isset($_SESSION['user_id']) and $_SESSION['user_id'] != $room_info['owner_id']) {
        return [
            'type' => 'danger',
            'message' => 'User is not creator of this room'
        ];
    }

    /* Delete room */
    $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->execute([$room_id]);
    $deleted = $stmt->rowCount();
    if ($deleted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room '%s' was removed!", $room_info['room_title'])
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The room was not removed.'
        ];
    }
}


/**
 * Generates an array with user information
 * @param object $pdo db object
 * @param int $user_id id from the user
 * @return mixed
 */
function get_user_info($pdo, $user_id ){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user_info = $stmt->fetch();
    $user_info_exp = Array();

    /* Create array with htmlspecialchars */
    foreach ($user_info as $key => $value){
        $user_info_exp[$key] = htmlspecialchars($value);
    }
    return $user_info_exp;
}
/**
 * saves opt_in data to database
 * @param object $pdo db object
 * @param int $room_id id from the room
 * @param $form_data array with the message
 */
function opt_in($pdo, $form_data){
    $room_info = get_room_info($pdo, $form_data['room_id']);
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare('INSERT INTO opt_in(tenant_id, owner_id, room_id, message, date) VALUES (?,?,?,?,?)');
    $stmt-> execute([
        $user_id,
        $room_info['owner_id'],
        $room_info['id'],
        $form_data["message"],
        date('Y-m-d H:i:s')
    ]);
    $success = $stmt->rowCount();
    if ($success ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Your request on the room '%s', is successfully sent.", $room_info['room_title'])
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. Your request was not sent correctly, please try it again!'
        ];
    }
}
/*
 *      $fields = ['type', 'size', 'price', 'serviceIncluding', 'furnished', 'street', 'zip', 'city', 'description', 'availableFrom', 'availableTill', 'description']
 *
        $stmt = $pdo->prepare("INSERT INTO rooms (owner_id, size_m2, zip, street, city, description, type, available_from, available_till, furnished, price, service_including) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $user_info['id'],
            $input['Size'],
            $input['Zip'],
            $input['Street'],
            $input['City'],
            $input['Description'],
            $input['Type'],
            $input['AvailableFrom'],
            $input['AvailableTill'],
            $input['Furnished'],
            $input['Price'],
            $input['ServiceIncluding']
        ]);
*/
function count_opt_in ($pdo, $room_id){
    $stmt = $pdo-> prepare('SELECT *  FROM opt_in WHERE room_id = ? ');
    $stmt-> execute([$room_id]);
    $nr_opt_in = $stmt-> rowCount();
    return $nr_opt_in;
}

/**
 * Get array with all listed messages from the database
 * @param object $pdo database object
 * @return array Associative array with all rooms
 */
function get_messages($pdo){
    $stmt = $pdo->prepare('SELECT * FROM opt_in');
    $stmt->execute();
    $messages = $stmt->fetchAll();
    $messages_exp = Array();
    /* Create array with htmlspecialchars */
    foreach ($messages as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $messages_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $messages_exp;
}
/**
 * Creats a Bootstrap table with a list of messages for the user
 * @param object $db pdo object
 * @param array $rooms with rooms from the db
 * @return string
 */
function get_messages_view($pdo, $messages){
    $content_exp = '<div class="container">';
    $user_id = $_SESSION['user_id'];
    $user_role = get_user_role($pdo);
    foreach ($messages as $key => $value) {
        if ($user_role == 'owner') {
            if ($value['owner_id'] == $user_id) {
                $tennant = get_user_info($pdo, $value["tenant_id"]);
                $content_exp .= '
                <div>
                    <div class="row">
                        <div class="col"><h5><a href="/DDWT18_G09/">' . $tennant["first_name"] . ' ' . $tennant["last_name"] . '</a></h5></div>
                        <div class="col" align="right">' . $value["date"] . '</div>
                    </div>
                    <div class="row">
                        <div class="col">' . $value["message"] . '</div>
                    </div>
                    </br>
                </div>';
            }
        } elseif ($user_role == 'tenant') {
            if ($value['tenant_id'] == $user_id) {
                $owner = get_user_info($pdo, $value["owner_id"]);
                $content_exp .= '
                <div>
                    <div class="row">
                        <div class="col"><h5>Send to: <a href="/DDWT18_G09/">' . $owner["first_name"] . ' ' . $owner["last_name"] . '</a></h5></div>
                        <div class="col" align="right">' . $value["date"] . '</div>
                    </div>
                    <div class="row">
                        <div class="col">' . $value["message"] . '</div>
                    </div>
                    </br>
                </div>';
            }
        }
    }
    $content_exp .= '</div>';
    return $content_exp;
}

function room_count($pdo){
    /* Get users */
    $stmt = $pdo->prepare('SELECT * FROM rooms');
    $stmt->execute();
    $rooms = $stmt->rowCount();
    return $rooms;
}

function student_count($pdo){
    /* Get users */
    $stmt = $pdo->prepare('SELECT * FROM users WHERE role = tenant');
    $stmt->execute();
    $tenants = $stmt->rowCount();
    return $tenants;
}

/**
 * Creates navigation HTML code using given array
 * @param array $navigation Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the navigation
 */
function get_navigation($template, $active_id, $user_status){
    $navigation_exp = '
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" style="color: aliceblue">Rooms Overview</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
    foreach ($template as $id => $info) {
        if (in_array($user_status, $info['show'])) {
            if ($active_id == $id) {
                $navigation_exp .= '<li class="nav-item active">';
                $navigation_exp .= '<a class="nav-link" href="' . $info['url'] . '">' . $info['name'] . '</a>';
            } else {
                $navigation_exp .= '<li class="nav-item">';
                $navigation_exp .= '<a class="nav-link" href="' . $info['url'] . '">' . $info['name'] . '</a>';
            }
        }
        $navigation_exp .= '</li>';
    }
    $navigation_exp .= '
    </ul>';
        if (!check_login()){$navigation_exp.='
    <form class="form-inline"  action="/DDWT18_G09/login/" method="POST">
    <input class="form-control mr-sm-2" type="text" placeholder="Username" name="username">
    <input class="form-control mr-sm-2" type="password" placeholder="Password" name="password">
    <button class="btn btn-success" type="submit">Login</button>
  </form>';}else{
            $navigation_exp.='<a href="/DDWT18_G09/logout/" class="btn btn-danger">Logout</a>';
        }
    $navigation_exp.= '</div>
    </nav>';
    return $navigation_exp;
}
/**
 * @param PDO $pdo
 * @param $form_data
 * @return array
 */
function update_user($pdo, $form_data){
    /* Check if all fields are set */
    $fields = ['firstname', 'lastname', 'street', 'zip', 'city', 'phone', 'mail', 'biography', 'profession', 'date_of_birth', 'gender', 'lang'];
    foreach ($fields as $value) {
        if (empty($form_data[$value])) {
            return [
                'type' => 'danger',
                'message' => sprintf('Form not complete, please fill in %s.', $value)
            ];
        }
    }

    /* Get user info */
    session_start();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user_info = $stmt->fetch();

    /* Save user to the database */
    $stmt = $pdo->prepare('UPDATE users SET first_name = ?, last_name = ?, street = ?, zip = ?, city = ?, phone_number = ?, email = ?, biography = ?, date_of_birth = ?, gender = ?, profession = ? WHERE id = ?');
    $stmt->execute([
        $form_data['firstname'],
        $form_data['lastname'],
        $form_data['street'],
        $form_data['zip'],
        $form_data['city'],
        $form_data['phone'],
        $form_data['mail'],
        $form_data['biography'],
        date("y-m-d", strtotime($form_data['date_of_birth'])),
        $form_data['gender'],
        $form_data['profession'],
        $user_info['id']
    ]);
    $updated = $stmt->rowCount();
    /*
    $user_id = $pdo->lastInsertId();
    foreach ($form_data['lang'] as $language) {
        $stmt = $pdo->prepare('INSERT INTO languages (user_id, language) VALUES (?, ?)');
        $stmt->execute([$user_id, $language]);
    }*/
    if ($updated ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf('User %s updated in the database.', $form_data['username'])
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The user was not updated. Try it again.'
        ];
    }
}