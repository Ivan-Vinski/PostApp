<?php
session_start();
if(!isset($_GET["noUser"]) && !isset($_GET["wrongPass"])){
  $_SESSION["username"] = "";
}
if(!isset($_GET["wrongEmail"]) && !isset($_GET["userExists"]) && !isset($_GET["emailExists"])){
  $_SESSION["regusername"] = "";
  $_SESSION["email"] = "";
}
include "databaseHandler.php";

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <title>PostApp</title>
  </head>

  <body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <header>
      <div class="container" id="logoContainer">
        <a href="./index.php"><h1>PostApp</h1></a>
      </div>
      <div class="container" id="navContainer">
        <button type="button" class="tablinks active" name="buttonLogin" onclick="switchLoginRegister(event, 'loginFormContainer')">Login</button>
        <button id="buttonRegister" type="button" class="tablinks" name="buttonRegister" onclick="switchLoginRegister(event, 'registerFormContainer')">Register</button>
      </div>
    </header>

    <section>
      <div class="container tabcontent" id="loginFormContainer" name="login">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input id="username" type="text" name="username" placeholder="Username" class="userInput" onfocus="moveCursorToEnd(this);" autofocus required title="Username" value="<?php if (isset($_SESSION['username'])){echo $_SESSION['username'];}?>"><br><br>
            <input id="passwordInput" type="password" name="password" placeholder="Password" class="userInput" required title="Password"><br><br>
            <button type="submit" name="login" class="buttons" id="buttonLogin">Login</button>
        </form>
      </div>

      <div class="container tabcontent" id="registerFormContainer" name="register">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input id="regusername" type="text" name="username" placeholder="Username" class="userInput" onfocus="moveCursorToEnd(this);" autofocus required title="Username" value="<?php if (isset($_SESSION['regusername'])){echo $_SESSION['regusername'];}?>"><br><br>
            <input id="email" type="text" name="email" placeholder="e-mail" class="userInput" id="emailInput" required title="e-mail" onfocus="moveCursorToEnd(this);" value="<?php if (isset($_SESSION['email'])){echo $_SESSION['email'];}?>"><br><br>
            <input id="regpasswordInput" type="password" name="password" placeholder="Password" class="userInput" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"><br><br>
            <button type="submit" name="register" class="buttons" id="buttonRegister">Register</button>
        </form>
      </div>
    </section>


    <script type="text/javascript">
      function switchLoginRegister(evt, divID){ // FUNCTION TO SWITCH BETWEEN LOGIN AND REGISTER FORMS
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(divID).style.display = "block";
        document.getElementById("username").focus();
        document.getElementById("regusername").focus();
        evt.currentTarget.className += " active";
      }
      function moveCursorToEnd(el) {
          if (typeof el.selectionStart == "number") {
            el.selectionStart = el.selectionEnd = el.value.length;
          } else if (typeof el.createTextRange != "undefined") {
            el.focus();
            var range = el.createTextRange();
            range.collapse(false);
            range.select();
          }
        }
    </script>

    <footer>
      <div class="container">
        <p>Developer: ivinski@foi.hr</p>
      </div>
      <div class="container">
        <img src="./img/facebookIcon.png" alt="facebook"></img>
        <a href="https://hr.linkedin.com/in/ivanvinski"><img src="./img/linkedInIcon.png" alt="linkedIn"></img></a>
        <a href="https://github.com/VinsTheOne"><img src="./img/gitHubIcon.png" alt="gitHub"></img></a>
      </div>
    </footer>



  </body>
</html>

<?php // MESSAGES SENT BY DATABASEHANDLER AS RESPONSES TO POTENTIAL LOGIN OR REGISTER
// USER LOGOUT SUCCESS
  if (isset($_GET["logout"])){
    session_destroy();
      echo "<script>toastr.options = {
        'closeButton': true,
        'positionClass': 'toast-top-center'
        }
    toastr['success']('Logout succesful', 'Logout')</script>";
  }
// USER LOGIN WRONG PASSWORD
  if (isset($_GET["wrongPass"])) {
    echo "<script>
    document.getElementById('passwordInput').focus();
    toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['error']('Incorrect password', 'Password')</script>";
  }
// USER LOGIN NO ACCOUNT WITH GIVEN USERNAME
  if (isset($_GET["noUser"])){
    echo "<script>toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['warning']('Account with given username not found', 'Username')</script>";
  }
// SWITCH FROM LOGIN TO REGISTER FORM IF THERE IS AN ERROR INSIDE REGISTER USER INPUT
  if (isset($_GET["switch"])){
    echo "<script>document.getElementById('buttonRegister').click();</script>";
  }
// REGISTRATION GIVEN USERNAME TAKEN
  if (isset($_GET["userExists"])){
    echo "<script>document.getElementById('buttonRegister').click();</script>";
      echo "<script>toastr.options = {
        'closeButton': true,
        'positionClass': 'toast-top-center'
        }
      toastr['warning']('Account with given username already exists', 'Username')</script>";
  }
// REGISTRATION GIVEN EMAIL TAKEN
  if(isset($_GET["emailExists"])){
    echo "<script>
    document.getElementById('email').focus();
    toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['warning']('Account with given e-mail already exists', 'e-mail')</script>";
  }
// REGISTRATION WRONG EMAIL ADRESS FORMAT
  if (isset($_GET["wrongEmail"])){
    echo "<script>
    document.getElementById('email').focus();
    toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['error']('Invalid e-mail adress', 'e-mail')</script>";
  }
// REGISTRATION SUCCESS
  if (isset($_GET["reg"])){
    echo "<script>toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['success']('...Success!', 'Registration')</script>";
  }

 ?>
