
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

            <form action="/DDWT18_G09/register/" method="POST">
                <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" name="username" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label><br>
                    <i style="font-size: 13px">Your password must contain at least 8 characters, 1 number, 1 capital letter and 1 small letter.</i>
                    <input type="password" class="form-control" id="inputPassword" name="password" required>
                </div>
                <div class="form-group">
                    <label for="inputRole">Role</label>
                    <select class="form-control" id="inputRole" name="role" required>
                        <option value="" disabled selected hidden>Please select</option>
                        <option value="tenant">Tenant</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputUsername">First name</label>
                    <input type="text" class="form-control" id="inputUsername" name="firstname" style="text-transform: capitalize;" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Last name</label>
                    <input type="text" class="form-control" id="inputUsername" name="lastname" style="text-transform: capitalize;" required>
                </div>
                <div class="form-group">
                    <label for="inputMail">Email</label>
                    <input type="email" class="form-control" id="inputMail" name="mail" required>
                </div>
                <div class="form-group">
                    <label for="inputPhone">Phone number</label>
                    <input type="number" class="form-control" id="inputPhone" name="phone" minlength="10" maxlength="15" required>
                </div>
                <div class="form-group">
                    <label for="inputGender">Gender</label>
                    <select class="form-control" id="inputGender" name="gender" required>
                        <option value="" disabled selected hidden>Please select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputDateOfBirth">Date of birth</label>
                    <input type="date" class="form-control" id="inputDateOfBirth" name="date_of_birth" placeholder="dd-mm-yyyy" required>
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
                <div class="form-group">
                    <label for="inputProfession">Study/Profession</label>
                    <input type="text" class="form-control" id="inputProfession" name="profession" style="text-transform: capitalize;" required>
                </div>
                <div class="form-group">
                    <label for="inputLang">What languages do you speak?</label>
                    <select class="form-control" id="inputLang" name="lang[]" multiple="multiple" required>
                        <option value="dutch">Dutch</option>
                        <option value="english">English</option>
                        <option value="french">French</option>
                        <option value="german">German</option>
                        <option value="italian">Italian</option>
                        <option value="spanish">Spanish</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputBiography">Biography; please tell something about yourself</label>
                    <textarea rows="5" class="form-control" id="inputBiography" name="biography" required></textarea>
                </div>

                <!--
                <div class="form-group">
                    <label for="Role">You are</label>
                    <SELECT name="role" onchange="check_role(this);">
                        <option value="" disabled selected hidden>Please Choose...</option>
                        <OPTION value="tenant">Tenant</OPTION>
                        <OPTION value="owner">Room owner</OPTION>
                    </SELECT>
                </div>
                <div class="form-group" id="Owner" style="display: none">
                    <label for="Profession">Profession</label>
                    <input type="text" class="form-control" id="Profession" placeholder="Teacher" name="profession" required>
                </div>
                <div class="form-group" id="Tenant" style="display: none">
                    <label for="Profession_Study">What do you do?</label>
                    <select name = "Profession_Study" onchange="check_study(this);">
                        <option value="" disabled selected hidden>Please Choose...</option>
                        <OPTION value="study">Studying</OPTION>
                        <OPTION value="work">Working</OPTION>
                        <OPTION value="study_work">Studying and working</OPTION>
                    </select>
                </div>
                <div class="form-group" id="Study" style="display: none">
                    <label for="Study">What are you studying</label>
                    <input type="text" class="form-control" id="Study" placeholder="Information science" name="study" required>
                </div>
                <div class="form-group" id="Work" style="display: none">
                    <label for="Study">What is your profession</label>
                    <input type="text" class="form-control" id="Work" placeholder="Seller" name="work" required>
                </div>
                -->

                <button type="submit" class="btn btn-primary"><?= $button_text ?></button>
            </form>
            </br>
        </div>
    </div>
</div>

<!--Check the role of the user and display extra fields-->
<!--
<script>
    function check_role(that) {
        if (that.value == "owner") {
            document.getElementById("Owner").style.display = "block";
            document.getElementById("Tenant").style.display = "none";
            document.getElementById("Work").style.display = "none";
            document.getElementById("Study").style.display = "none";

        } else if (that.value == "tenant"){
            document.getElementById("Tenant").style.display = "block";
            document.getElementById("Owner").style.display = "none";

        } else {
            document.getElementById("Owner").style.display = "none";
            document.getElementById("Tenant").style.display = "none";
        }
    }
    function check_study(that) {
        if (that.value == "study") {
            document.getElementById("Study").style.display = "block";
            document.getElementById("Work").style.display = "none";
        } else if (that.value == "work") {
            document.getElementById("Work").style.display = "block";
            document.getElementById("Study").style.display = "none";
        } else if (that.value == "study_work") {
            document.getElementById("Study").style.display = "block";
            document.getElementById("Work").style.display = "block";
        }
        else{
            document.getElementById("Study").style.display = "none";
            document.getElementById("Work").style.display = "none";
        }
    }
</script>
-->
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
