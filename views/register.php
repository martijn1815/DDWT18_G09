
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Include the plugin's CSS and JS: -->
        <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
        <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>

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

            <form action=<?= $form_action ?> method="POST">
                <div class="form-group" <?php if (isset($user_info)){echo "style='display: none;'";} ?>>
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" name="username" value="<?php if (isset($user_info)){echo $user_info['username'];} ?>" required>
                </div>
                <div class="form-group" <?php if (isset($user_info)){echo "style='display: none;'";} ?>>
                    <label for="inputPassword">Password</label><br>
                    <i style="font-size: 13px">Your password must contain at least 8 characters, 1 number, 1 capital letter and 1 small letter.</i>
                    <input type="password" class="form-control" id="inputPassword" name="password" value="<?php if (isset($user_info)){echo $user_info['password'];} ?>" required>
                </div>
                <div class="form-group" <?php if (isset($user_info)){echo "style='display: none;'";} ?>>
                    <label for="inputRole">Role</label>
                    <select class="form-control" id="inputRole" name="role" required>
                        <option value="" disabled selected hidden>Please select</option>
                        <option value="tenant" <?php if (isset($user_info)){if ($user_info['role']=='tenant'){echo 'selected';}} ?>>Tenant</option>
                        <option value="owner" <?php if (isset($user_info)){if ($user_info['role']=='owner'){echo 'selected';}} ?>>Owner</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputUsername">First name</label>
                    <input type="text" class="form-control" id="inputUsername" name="firstname" style="text-transform: capitalize;" value="<?php if (isset($user_info)){echo $user_info['first_name'];} ?>" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Last name</label>
                    <input type="text" class="form-control" id="inputUsername" name="lastname" style="text-transform: capitalize;" value="<?php if (isset($user_info)){echo $user_info['last_name'];} ?>" required>
                </div>
                <div class="form-group">
                    <label for="inputMail">Email</label>
                    <input type="email" class="form-control" id="inputMail" name="mail" value="<?php if (isset($user_info)){echo $user_info['email'];} ?>" required>
                </div>
                <div class="form-group">
                    <label for="inputPhone">Phone number</label>
                    <input type="number" class="form-control" id="inputPhone" name="phone" minlength="10" maxlength="15" value="<?php if (isset($user_info)){echo $user_info['phone_number'];} ?>" required>
                </div>
                <div class="form-group">
                    <label for="inputGender">Gender</label>
                    <select class="form-control" id="inputGender" name="gender" required>
                        <option value="" disabled selected hidden>Please select</option>
                        <option value="male" <?php if (isset($user_info)){if ($user_info['gender']=='male'){echo 'selected';}} ?>>Male</option>
                        <option value="female" <?php if (isset($user_info)){if ($user_info['gender']=='female'){echo 'selected';}} ?>>Female</option>
                        <option value="other" <?php if (isset($user_info)){if ($user_info['gender']=='other'){echo 'selected';}} ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputDateOfBirth">Date of birth</label>
                    <input type="date" class="form-control" id="inputDateOfBirth" name="date_of_birth" placeholder="dd-mm-yyyy"  value="<?php if (isset($user_info)){echo date("m-d-Y", strtotime($user_info['date_of_birth']));} ?>" required>
                </div>
                <div class="form-group">
                    <label for="inputStreet">Street and house number</label>
                    <input type="text" class="form-control" id="inputStreet" name="street" style="text-transform: capitalize;" value="<?php if (isset($user_info)){echo $user_info['street'];} ?>" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="inputZip">Zip code</label>
                        <input type="text" class="form-control" id="inputZip" name="zip" minlength="6" maxlength="6" style="text-transform: uppercase;" value="<?php if (isset($user_info)){echo $user_info['zip'];} ?>" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity" name="city" style="text-transform: capitalize;" value="<?php if (isset($user_info)){echo $user_info['city'];} ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputProfession">Study/Profession</label>
                    <input type="text" class="form-control" id="inputProfession" name="profession" style="text-transform: capitalize;" value="<?php if (isset($user_info)){echo $user_info['profession'];} ?>" required>
                </div>
                <div class="form-group">
                    <label for="inputLang">What languages do you speak?</label>
                    <select class="form-control" id="inputLang" name="lang[]" multiple="multiple" required>
                        <option value="dutch" <?php if (isset($user_info_language)){if (in_array('dutch', $user_info_language)){echo 'selected';}} ?>>Dutch</option>
                        <option value="english" <?php if (isset($user_info_language)){if (in_array('english', $user_info_language)){echo 'selected';}} ?>>English</option>
                        <option value="french" <?php if (isset($user_info_language)){if (in_array('french', $user_info_language)){echo 'selected';}} ?>>French</option>
                        <option value="german" <?php if (isset($user_info_language)){if (in_array('german', $user_info_language)){echo 'selected';}} ?>>German</option>
                        <option value="italian" <?php if (isset($user_info_language)){if (in_array('italian', $user_info_language)){echo 'selected';}} ?>>Italian</option>
                        <option value="spanish" <?php if (isset($user_info_language)){if (in_array('spanish', $user_info_language)){echo 'selected';}} ?>>Spanish</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputBiography">Biography; please tell something about yourself</label>
                    <textarea rows="5" class="form-control" id="inputBiography" name="biography" required><?php if (isset($user_info)){echo $user_info['biography'];} ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><?= $button_text ?></button>
            </form>
            </br>
        </div>
    </div>
</div>

<!-- Initialize the multiselect-plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#inputLang').multiselect();
    });
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
