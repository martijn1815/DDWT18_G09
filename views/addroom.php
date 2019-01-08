
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
        <!-- Left column -->
        <div class="col-md-12">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;} ?>

            <h1><?= $page_title ?></h1>
            <h5><?= $page_subtitle ?></h5>

            <div class="pd-15">&nbsp;</div>

            <form action="/DDWT18_G09/addrooms/" method="POST">
                <div class="form-group">
                    <label for="inputRoomTitle">Room title</label>
                    <input type="text" class="form-control" id="inputRoomTitle" name="room_title" required>
                </div>
                <div class="form-group">
                    <label for="inputStreet">Street and house number</label>
                    <input type="text" class="form-control" id="inputStreet" name="street" style="text-transform: capitalize;" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="inputZip">Zip code</label>
                        <input type="text" class="form-control" id="inputZip" name="zip" minlength="6" maxlength="6" style="text-transform: uppercase;" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity" name="city" style="text-transform: capitalize;" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="inputType">Room type</label>
                        <select class="form-control" id="inputType" name="type" required>
                            <option value="" disabled selected hidden>Please select</option>
                            <option value="studenthouse">Room in a student house</option>
                            <option value="ownershouse">Room in owner's house</option>
                            <option value="apartment">An apartment</option>
                        </select>
                    </div>
                    <div class="form-group col-sm">
                        <label for="inputPrice">Price room (&euro;)</label>
                        <input type="number" class="form-control" id="inputPrice" name="price" maxlength="11" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="inputSize">Size room (m<sup>2</sup>)</label>
                        <input type="number" class="form-control" id="inputSize" name="size_m2" maxlength="11" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="inputAvailableFrom">Available from</label>
                        <input type="date" class="form-control" id="inputAvailableFrom" name="available_from" placeholder="dd-mm-yyyy" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="inputAvailableTill">Available till</label>
                        <input type="date" class="form-control" id="inputAvailableTill" name="available_till" placeholder="dd-mm-yyyy" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="furnished" value="no">
                    <input type="checkbox" name="furnished" value="yes"> The room is furnished
                </div>
                <div class="form-group">
                    <input type="hidden" name="services_including" value="no">
                    <input type="checkbox" name="services_including" value="yes"> Services are included (Gas/Water/Electricity/Internet)
                </div>
                <div class="form-group">
                    <label for="inputDescription">Room description</label>
                    <textarea rows="5" class="form-control" id="inputDescription" name="description" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </br>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
