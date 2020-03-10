<?php include "databaseHandler.php"; ?>

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


    <script>
      function warnmebruh(){

        toastr['error']('e-mail is not valid', 'e-mail');
      }
    </script>

    <header>
      <div class="container" id="logoContainer">
        <h1>PostApp</h1>
      </div>
      <div class="container" id="navContainer">
        <button type="button" class="tablinks active" name="buttonLogin" onclick="switchLoginRegister(event, 'loginFormContainer')">Login</button>
        <button type="button" class="tablinks" name="buttonRegister" onclick="switchLoginRegister(event, 'registerFormContainer')">Register</button>
      </div>
    </header>

    <section>
      <div class="container tabcontent" id="loginFormContainer" name="login">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input id="username" type="text" name="username" placeholder="Username" class="userInput" autofocus required title="Username" value="<?php if (isset($_GET['username'])){echo $_GET['username'];}?>"><br><br>
            <input id="passwordInput" type="password" name="password" placeholder="Password" class="userInput" required title="Password"><br><br>
            <button type="submit" name="login" class="buttons" id="buttonLogin">Login</button>
        </form>
      </div>

      <div class="container tabcontent" id="registerFormContainer" name="register">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="username" placeholder="Username" class="userInput" autofocus required title="Username"><br><br>
            <input type="password" name="password" placeholder="Password" class="userInput" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"><br><br>
            <input type="text" name="email" placeholder="e-mail" class="userInput" id="emailInput" required title="e-mail"><br><br>
            <button type="submit" name="register" class="buttons" id="buttonRegister">Register</button>
        </form>
      </div>
    </section>

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

    <script type="text/javascript">

      function switchLoginRegister(evt, divID){
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
        evt.currentTarget.className += " active";
      }
    </script>

  </body>
</html>

<?php

  if (isset($_GET["logout"])){
    session_destroy();
      echo "<script>toastr.options = {
        'closeButton': true,
        'positionClass': 'toast-top-center'
        }
    toastr['success']('Logout succesfull', 'Logout')</script>";
  }

  if (isset($_GET["wp"])) {
    echo "<script>toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['error']('Incorrect password', 'Password')</script>";
  }

  if (isset($_GET["noUser"])){
    echo "<script>toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['warning']('Account with given username not found', 'Username')</script>";
  }

  if (isset($_GET["userExists"])){
      echo "<script>toastr.options = {
        'closeButton': true,
        'positionClass': 'toast-top-center'
        }
      toastr['warning']('Account with given username already exists', 'Username')</script>";
  }

  if(isset($_GET["emailExists"])){
    echo "<script>toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['warning']('Account with given e-mail already exists', 'e-mail')</script>";
  }

  if (isset($_GET["reg"])){
    echo "<script>toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['success']('...Success!', 'Registration')</script>";
  }

  if (isset($_GET["xmail"])){
    echo "<script>toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-center'
      }
    toastr['error']('Invalid e-mail adress', 'e-mail')</script>";
  }
 ?>
