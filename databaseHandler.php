<?php
  session_start();
  $username=$email=$password="";
  $conn = connectDB("localhost", "root", "");
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["postPost"])){
      insertPost($conn, $_POST["title"], $_POST["text"], getUserID($conn, $_SESSION["username"]));
      return;
    }
    if (empty($_POST["username"])){
      echo "<body><script>alert('Enter username.')</script></body>";
    }
    else if (empty($_POST["password"])) {
      echo "<body><script>alert('Enter password.')</script></body>";
    }
    else{
      if (isset($_POST["login"])){
        $username = testInput($_POST["username"]);
        $password = testInput($_POST["password"]);
        login($conn, $username, $password);

      }
      else if (isset($_POST["register"])){
        if (empty($_POST["email"])) {
          echo "<body><script>alert('Enter your e-mail.')</script></body>";
        }
        else{
          $username = testInput($_POST["username"]);
          $email = testInput($_POST["email"]);
          $password = testInput($_POST["password"]);
          registerUser($conn, $username, $email, $password);
        }
      }
    }
  }
  closeConn($conn);

  function testInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function connectDB($servername, $username, $password){
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
      echo "<body><script>alert('Connection failed');</script></body>";
    }
    return $conn;
  }

  function closeConn($conn){
    $conn->close();
    return true;
  }

  function getUserID($conn, $username){
    $sql = "SELECT user_id FROM postapp.users WHERE username='".$username."'";
    $result = $conn->query($sql);
    $userID = $result->fetch_all();
    return $userID[0][0];
  }

  function getPostsCount($conn, $userID){
    $sql = "SELECT COUNT(*) FROM postapp.posts WHERE user_id='".$userID."'";
    $result = $conn->query($sql);
    $postCount = $result->fetch_all();
    return $postCount[0][0];
  }

  function getPosts($conn, $userID){
    $sql = "SELECT * FROM postapp.posts WHERE user_id='".$userID."'";
    $result = $conn->query($sql);
    $posts = $result->fetch_all();
    return $posts;
  }

  function getUserCount($conn){
    $sql = "SELECT COUNT(*) FROM postapp.users";
    $result = $conn->query($sql);
    $count = $result->fetch_all();
    return $count[0][0];
  }



  function login($conn, $username, $password){

    $sql = "SELECT * FROM postapp.users WHERE username='".$username."'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0){
      echo "<body><script>alert('Account with given username not found.')</script></body>";
    }
    else{
      $row = $result->fetch_assoc();
      $dbUsername = $row["username"];
      $dbPassword = $row["password"];

      if (password_verify($password, $dbPassword)){
        $_SESSION['username'] = $username;
        header("Location: main/main.php");
      }
      else{
        echo "<body><script>alert('Wrong Password');</script></body>";
      }
    }
  }

  function registerUser($conn, $username, $email, $password){
    $sql = "SELECT * FROM postapp.users";
    $result = $conn->query($sql);
    $row = $result->fetch_all();
    $flag = 0;

    for ($i = 0; $i < getUserCount($conn); $i++){
      if ($username == $row[$i][1]){
        echo "<body><script>alert('Account with given username already exists.')</script></body>";
        $flag = 1;
      }
      else if ($email == $row[$i][2]){
        echo "<body><script>alert('Account with given e-mail already exists.')</script></body>";
        $flag = 1;
      }
    }
    if (!$flag){
      $hadhedPass = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO postapp.users(username, email, password) VALUES ('".$username."', '".$email."', '".$hadhedPass."')";
      $result = $conn->query($sql);
        echo "<body><script>alert('Registration succesfull.')</script></body>";
    }
  }

  function insertPost($conn, $title, $text, $userID){
    $sql = "INSERT INTO postapp.posts(postTitle, postText, time, user_id) VALUES ('".$title."', '".$text."', current_timestamp(), '".$userID."')";
    $result = $conn->query($sql);

  }
?>
