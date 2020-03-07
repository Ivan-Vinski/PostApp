<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main.css">
    <title>PostApp</title>
  </head>
  <body>

    <header>
      <div class="container" id="logoContainer">
        <h1>PostApp</h1>
      </div>
      <div class="container" id="navContainer">
        <a href="../index.php?logout=true">Logout</a>
      </div>
    </header>

    <section class="formContainer">
      <form action="./main.php" method="post">
        <textarea type="text" name="title" id="titleInput" placeholder="Title"></textarea><br>
        <textarea type="text" name="text" id="textInput" placeholder="Post"></textarea><br>
        <button type="submit" name="postPost">Post</button>
      </form>
    </section>

    <?php
      include "../databaseHandler.php";
      $conn = connectDB("localhost", "root", "");
      $userID = getUserID($conn, $_SESSION["username"]);
      $postCount = getPostsCount($conn, $userID);
      $posts = getPosts($conn, $userID);
      for($i = $postCount - 1; $i >= 0; $i--){
        // DISPLAY ALL POSTS// POST title
        echo "<section class='postsContainer'>
          <div class='titleContainer'><h1 class='postTitle'>".$posts[$i][1]."</h1></div>
          <div class='textContainer'><p class='postText'>".$posts[$i][2]."</p></div>
          <div class='timestampContainer'><p class='time'>".$posts[$i][3]."</p></div>
        </section>";
      }
      echo "<br><br>";
      closeConn($conn);
     ?>
    <footer>
      <div class="">
        nes
      </div>
    </footer>

  </body>
</html>
