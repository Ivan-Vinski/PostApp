<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="index.css">
    <title>PostApp</title>
  </head>

  <body>

    <header>
      <div class="container" id="logoContainer">
        <h1>PostApp</h1>
      </div>
      <div class="container" id="navContainer">
        <button type="button" name="buttonLogin" onclick="openLoginForm()">Login</button>
        <button type="button" name="buttonRegister" onclick="openRegisterForm()">Register</button>
      </div>
    </header>

    <section>
      <div class="container" id="loginFormContainer">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="username" placeholder="Username" class="userInput" autofocus><br><br>
            <input type="password" name="password" placeholder="Password" class="userInput"><br><br>
            <input type="text" name="email" placeholder="e-mail" class="userInput" id="emailInput"><br><br>
            <button type="submit" name="login" class="buttons" id="buttonLogin">Login</button>
            <button type="submit" name="register" class="buttons" id="buttonRegister">Register</button>
        </form>
      </div>
    </section>

    <footer>
      Footer
    </footer>

    <script type="text/javascript">
      function openLoginForm(){
        document.getElementById("emailInput").style.display="none";
        document.getElementById("buttonLogin").style.display="block";
        document.getElementById("buttonRegister").style.display="none";
        var inputs = document.getElementsByTagName("form");
        inputs[0].style.padding = "35px";
      }
      function openRegisterForm(){
        document.getElementById("emailInput").style.display="block";
        document.getElementById("buttonLogin").style.display="none";
        document.getElementById("buttonRegister").style.display="block";
        var inputs = document.getElementsByTagName("form");
        inputs[0].style.padding = "24px";
      }
    </script>

  </body>
</html>

<?php
  include "databaseHandler.php";
  if (isset($_GET["logout"])){
    session_destroy();
    echo "<body><script>alert('Logut succesfull.')</script></body>";
  }
 ?>
