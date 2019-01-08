<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Own CSS -->
    <link rel="stylesheet" href="/DDWT18/week2/css/main.css">

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

        <!-- Left column -->
        <div class="col-md-8">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;} ?>

            <h1><?= $page_title ?></h1>
            <h5><?= $page_subtitle ?></h5>
            <p><?= $description ?></p>
            <table class="table">
                <tbody>
                <tr>
                    <th scope="row">Address</th>
                    <td><?= $street ?>, <?= $zip?>, <?= $city?>.</td>
                </tr>
                <tr>
                    <th scope="row">Owner</th><td><?= $owner ?></td>
                </tr>
                <tr>
                    <th scope="row">Type</th>
                    <td><?= $type ?></td>
                </tr>
                <tr>
                    <th scope="row">Size</th> <td><?= $size ?></td>
                </tr>
                <tr>
                    <th scope="row">Available from</th> <td><?= $available_from ?></td>
                </tr>
                <tr>
                    <th scope="row">Available till</th> <td><?= $available_till ?></td>
                </tr>
                <tr>
                    <th scope="row">Furnished</th> <td><?= $furnished ?></td>
                </tr>
                <tr>
                    <th scope="row">Services are included (Gas/Water/Electricity/Internet)</th> <td><?= $services_including ?></td>
                </tr>
                <tr>
                    <th scope="row">Price per month</th> <td><?= $price ?></td>
                </tr>

                </tbody>
            </table>


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