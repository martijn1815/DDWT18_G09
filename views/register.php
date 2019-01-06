
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


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
                    <input type="text" class="form-control" id="inputUsername" placeholder="j.jansen" name="username" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="******" name="password" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">First name</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="Jan" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Last name</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="Jansen" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="Zip">Zip code</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="1234AB" name="zip" required>
                </div>
                <div class="form-group">
                    <label for="Street">Street and house number</label>
                    <input type="text" class="form-control" id="Street" placeholder="Hoofdstraat 10" name="street" required>
                </div>
                <div class="form-group">
                    <label for="City">City</label>
                    <input type="text" class="form-control" id="City" placeholder="Groningen" name="city" required>
                </div>
                <div class="form-group">
                    <label for="Phone">Phone number</label>
                    <input type="number" class="form-control" id="Phone" placeholder="0612345678" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="email" class="form-control" id="Mail" placeholder="example@domain.com" name="mail" required>
                </div>
                <div class="form-group">
                    <label for="Date_of_birth">Date of birth</label>
                    <input type="date" class="form-control" id="Date_of_birth" placeholder="01-03-1980" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label for="Gender">Gender</label>
                        <SELECT name="gender">
                            <option value="" disabled selected hidden>Please Choose...</option>
                            <OPTION name="gender">Male</OPTION>
                            <OPTION name="gender">Female</OPTION>
                            <OPTION name="gender">Other</OPTION>
                        </SELECT>
                </div>
                <div class="form-group">
                    <label for="Lang">What languages do you speak?</label><br>
                    <input type="checkbox" name= "lang" value="AF">Afrikanns
                    <br><input type="checkbox" name= "lang" value="SQ">Albanian
                    <br><input type="checkbox" name= "lang" value="AR">Arabic
                    <br><input type="checkbox" name= "lang" value="HY">Armenian
                    <br><input type="checkbox" name= "lang" value="EU">Basque
                    <br><input type="checkbox" name= "lang" value="BN">Bengali
                    <br><input type="checkbox" name= "lang" value="BG">Bulgarian
                    <br><input type="checkbox" name= "lang" value="CA">Catalan
                    <br><input type="checkbox" name= "lang" value="KM">Cambodian
                    <br><input type="checkbox" name= "lang" value="ZH">Chinese (Mandarin)
                    <br><input type="checkbox" name= "lang" value="HR">Croation
                    <br><input type="checkbox" name= "lang" value="CS">Czech
                    <br><input type="checkbox" name= "lang" value="DA">Danish
                    <br><input type="checkbox" name= "lang" value="NL">Dutch
                    <br><input type="checkbox" name= "lang" value="EN">English
                    <br><input type="checkbox" name= "lang" value="ET">Estonian
                    <br><input type="checkbox" name= "lang" value="FJ">Fiji
                    <br><input type="checkbox" name= "lang" value="FI">Finnish
                    <br><input type="checkbox" name= "lang" value="FR">French
                    <br><input type="checkbox" name= "lang" value="KA">Georgian
                    <br><input type="checkbox" name= "lang" value="DE">German
                    <br><input type="checkbox" name= "lang" value="EL">Greek
                    <br><input type="checkbox" name= "lang" value="GU">Gujarati
                    <br><input type="checkbox" name= "lang" value="HE">Hebrew
                    <br><input type="checkbox" name= "lang" value="HI">Hindi
                    <br><input type="checkbox" name= "lang" value="HU">Hungarian
                    <br><input type="checkbox" name= "lang" value="IS">Icelandic
                    <br><input type="checkbox" name= "lang" value="ID">Indonesian
                    <br><input type="checkbox" name= "lang" value="GA">Irish
                    <br><input type="checkbox" name= "lang" value="IT">Italian
                    <br><input type="checkbox" name= "lang" value="JA">Japanese
                    <br><input type="checkbox" name= "lang" value="JW">Javanese
                    <br><input type="checkbox" name= "lang" value="KO">Korean
                    <br><input type="checkbox" name= "lang" value="LA">Latin
                    <br><input type="checkbox" name= "lang" value="LV">Latvian
                    <br><input type="checkbox" name= "lang" value="LT">Lithuanian
                    <br><input type="checkbox" name= "lang" value="MK">Macedonian
                    <br><input type="checkbox" name= "lang" value="MS">Malay
                    <br><input type="checkbox" name= "lang" value="ML">Malayalam
                    <br><input type="checkbox" name= "lang" value="MT">Maltese
                    <br><input type="checkbox" name= "lang" value="MI">Maori
                    <br><input type="checkbox" name= "lang" value="MR">Marathi
                    <br><input type="checkbox" name= "lang" value="MN">Mongolian
                    <br><input type="checkbox" name= "lang" value="NE">Nepali
                    <br><input type="checkbox" name= "lang" value="NO">Norwegian
                    <br><input type="checkbox" name= "lang" value="FA">Persian
                    <br><input type="checkbox" name= "lang" value="PL">Polish
                    <br><input type="checkbox" name= "lang" value="PT">Portuguese
                    <br><input type="checkbox" name= "lang" value="PA">Punjabi
                    <br><input type="checkbox" name= "lang" value="QU">Quechua
                    <br><input type="checkbox" name= "lang" value="RO">Romanian
                    <br><input type="checkbox" name= "lang" value="RU">Russian
                    <br><input type="checkbox" name= "lang" value="SM">Samoan
                    <br><input type="checkbox" name= "lang" value="SR">Serbian
                    <br><input type="checkbox" name= "lang" value="SK">Slovak
                    <br><input type="checkbox" name= "lang" value="SL">Slovenian
                    <br><input type="checkbox" name= "lang" value="ES">Spanish
                    <br><input type="checkbox" name= "lang" value="SW">Swahili
                    <br><input type="checkbox" name= "lang" value="SV">Swedish
                    <br><input type="checkbox" name= "lang" value="TA">Tamil
                    <br><input type="checkbox" name= "lang" value="TT">Tatar
                    <br><input type="checkbox" name= "lang" value="TE">Telugu
                    <br><input type="checkbox" name= "lang" value="TH">Thai
                    <br><input type="checkbox" name= "lang" value="BO">Tibetan
                    <br><input type="checkbox" name= "lang" value="TO">Tonga
                    <br><input type="checkbox" name= "lang" value="TR">Turkish
                    <br><input type="checkbox" name= "lang" value="UK">Ukranian
                    <br><input type="checkbox" name= "lang" value="UR">Urdu
                    <br><input type="checkbox" name= "lang" value="UZ">Uzbek
                    <br><input type="checkbox" name= "lang" value="VI">Vietnamese
                    <br><input type="checkbox" name= "lang" value="CY">Welsh
                    <br><input type="checkbox" name= "lang" value="XH">Xhosa

                </div>
                <div class="form-group" id="Biography">
                    <label for="Biography">Biography</label>
                    <textarea rows="5" class="form-control" id="Biography" placeholder="Your Biography here.." name="biography" required></textarea>
                </div>
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


                <button type="submit" class="btn btn-primary">Register now</button>
            </form>

        </div>

    </div>
</div>

<!--Check the role of the user and display extra fields-->
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
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
