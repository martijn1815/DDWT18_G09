<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Own CSS -->
    <link rel="stylesheet" href="/DDWT18_G09/css/main.css">

    <title><?= $page_title ?></title>
</head>
<body>
<!-- Menu -->
<?= $navigation ?>

<!-- Content -->
<div class="container">
    <!-- Breadcrumbs -->
    <div class="pd-15">&nbsp</div>
    <?= $breadcrumbs ?>

    <div class="row">

        <div class="col-md-12">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;}?>

            <h1><?= $page_title ?></h1>
            <h5><?= $page_subtitle ?></h5>
            <p><?= $page_content ?></p>
        </div>

    </div>

    <div class="pd-15">&nbsp;</div>

    <div class="row">

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Welcome, <?= $user ?> <br/>
                    Your role is "<?= $user_role?>".
                </div>
                <div class="card-body">
                    <p>You're logged in to Rooms Overview.</p>
                    <a href="/DDWT18_G09/logout/" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Manage your user profile
                </div>
                <div class="card-body">
                    <p><a href="/DDWT18_G09/userprofile/update/" class="btn btn-success">Change user information</a></p>
                    <form class="form-inline"  action="/DDWT18_G09/userprofile/remove" method="POST">
                        <input class="form-control mr-sm-2" type="hidden" name="id" value="<?= $_SESSION['user_id'] ?>">
                        <button class="btn btn-danger" type="submit">Delete user account</button>
                    </form>
                </div>
            </div>
        </div>
        <?php if ($user_role == "owner"){echo'
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Add rooms
                </div>
                <div class="card-body">
                    <p>Publish Your room to Rooms Overview.</p>
                    <a href="/DDWT18_G09/addrooms/" class="btn btn-success">Add a room</a>
                </div>
            </div>
        </div>';}
        ?>

        <?php if ($user_role == "tenant"){echo'
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Check the new rooms
                </div>
                <div class="card-body">
                    <p>You can check here the rooms overview </p>
                    <a href="/DDWT18_G09/roomsoverview/" class="btn btn-success">Rooms overview</a>
                </div>
            </div>
        </div>';}
        ?>
        </div>

    </div>
</div>


<!-- Optional JavaScript -->


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>