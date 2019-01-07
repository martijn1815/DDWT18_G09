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
 * Creates navigation HTML code using given array
 * @param array $navigation Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the navigation
 */
function get_navigation($template, $active_id){
    $navigation_exp = '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">Series Overview</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
    foreach ($template as $id => $info) {
        if ($active_id == $id){
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="'.$info['url'].'">'.$info['name'].'</a>';
        }else{
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="'.$info['url'].'">'.$info['name'].'</a>';
        }

        $navigation_exp .= '</li>';
    }
    $navigation_exp .= '
    </ul>
    </div>
    </nav>';
    return $navigation_exp;
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
    if (!empty($user_exists)){
        return [
            'type' => 'danger',
            'message' => 'The username you entered does already exists!'
        ];
    }

    /* Check data types */
    /* ...To be added... */

    /* Hash password */
    $password = password_hash($form_data['password'], PASSWORD_DEFAULT);
    $date = date('Y-m-d', strtotime($form_data['date_of_birth']));

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
            $date,
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
    redirect(sprintf('/DDWT18_G09/myaccount/?error_msg=%s', json_encode($feedback)));
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
 * Returns the name of a user based on a specific user id
 * @param PDO $pdo
 * @param $user_id
 * @return string
 */
function get_username($pdo, $user_id){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    return $user['firstname'].' '.$user['lastname'];
}

function check_login(){
    session_start();
    if (isset($_SESSION['user_id'])){
        return True;
    } else {
        return False;
    }
}

function logout_user(){
    session_start();
    session_unset();
    session_destroy();
    $feedback = [
        'type' => 'success',
        'message' => 'You successfully logged out.'
    ];
    redirect(sprintf('/DDWT18_G09/?logout_msg=%s', json_encode($feedback)));
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
/**
 * saves opt_in data to database
 * @param object $pdo db object
 * @param int $room_id id from the room
 * @param $form_data array with the message
 */
function opt_in($pdo, $room_id, $form_data){
    $room_ifo = get_room_info($pdo, $room_id);
    $user_id = get_user_id();
    $stmt = $pdo->prepare('INSERT INTO opt_in(room_id, tenant_id, message, date) VALUES (?,?,?,?)');
    $stmt-> execute([$room_id, $user_id,$form_data["message"],date('Y-m-d H:i:s') ]);
    $success = $stmt->rowCount();
    if ($success ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Your request on the room '%s', is successfully sent.", $room_ifo['street'])
        ];
    }
    else {
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