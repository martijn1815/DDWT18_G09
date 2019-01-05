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
 * @param $crud_system
 * @param $input
 * @return array
 */
function crud_add($pdo, $crud_system, $input) {
    /* Check if all fields are set */
    foreach ($crud_system['fields'] as $value) {
        if (
        empty($input[$value])
        ) {
            return [
                'type' => 'danger',
                'message' => 'Error; Not all fields were filled in.'
            ];
        }
    }

    /* Check data type */
    /*
    if (!is_numeric($input['Seasons'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field Seasons.'
        ];
    }
    */

    /* Check if user already exists */
    if ($crud_system['system'] == 'user') {
        $stmt = $pdo->prepare('SELECT * FROM series WHERE name = ?');
        $stmt->execute([$input['Name']]);
        $serie = $stmt->rowCount();
        if ($serie) {
            return [
                'type' => 'danger',
                'message' => 'This series was already added.'
            ];
        }
    }

    /* Get user info */
    if ($crud_system['system'] == 'room') {
        $stmt = $pdo->prepare('SELECT * FROM series WHERE username = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $user_info = $stmt->fetch();
    }

    /* Add Serie */
    /*
    $stmt = $pdo->prepare("INSERT INTO series (name, creator, seasons, abstract, user) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $input['Name'],
        $input['Creator'],
        $input['Seasons'],
        $input['Abstract'],
        $user_info['id']
    ]);
    */
    if ($crud_system['system'] == 'user') {
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
    } elseif ($crud_system['system'] == 'room') {
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
    }
    $inserted = $stmt->rowCount();
    if ($inserted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf('%s added to database.', $crud_system['system'])
        ];
    }
    else {
        return [
            'type' => 'danger',
            'message' => sprintf('Error: %s not added to database. Please try again.', $crud_system['system'])
        ];
    }
}