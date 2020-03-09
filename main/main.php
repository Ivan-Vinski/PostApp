
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

    <script>
      function switchFeeds(evt, divID) {
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

    <div class="tab">
      <button class="tablinks active" onclick="switchFeeds(event, 'privateFeed')">Private Feed</button>
      <button class="tablinks" onclick="switchFeeds(event, 'publicFeed')">Public Feed</button>
    </div>

    <div id="privateFeed" class="tabcontent">
      <script>
        function validatePostsForm() {
          var x = document.forms["postForm"]["title"].value;
          if (x == null || x == "") {
            alert("Title must be filled out");
            return false;
          }
          var x = document.forms["postForm"]["text"].value;
          if (x == null || x == "") {
            alert("Text must be filled out");
            return false;
          }
          var x = document.forms["postForm"]["bool"].value;
          if (x == null || x == "") {
            alert("Choose if post is public or private");
            return false;
          }
        }
      </script>
      <div id="mainPrivateContainer">
        <section class="formContainer">
          <form name="postForm" action="./main.php" method="post" onsubmit="return validatePostsForm()">
            <textarea type="text" name="title" id="titleInput" placeholder="Title"></textarea><br>
            <textarea type="text" name="text" id="textInput" placeholder="Post"></textarea><br>
            <label for='private' class="bool">Private</label>
            <input type='radio' id='private' name='bool' value='private' class="bool">
            <label for='public' class="bool">Public</label>
            <input type='radio' id='public' name='bool' value='public' class="bool"><br>
            <button type="submit" name="postPost">Post</button>
          </form>
        </section>


        <?php
          include "../databaseHandler.php";
          $conn = connectDB("localhost", "root", "");
          $userID = getUserID($conn, $_SESSION["username"]);
          $postCount = getUserPostsCount($conn, $userID);
          $posts = getUserPosts($conn, $userID);
          for($i = $postCount - 1; $i >= 0; $i--){
            // DISPLAY ALL POSTS// POST title
            echo "<section class='postsContainer'>
              <div class='titleContainer'><h1 class='postTitle'>".$posts[$i][1]."</h1></div>
              <div class='textContainer'><p class='postText'>".$posts[$i][2]."</p></div>
              <div class='timestampContainer'><p class='time'>".$posts[$i][3]."</p>
                <form class='' action='./main.php' method='post'>
                  <input type='hidden' value='".$posts[$i][0]."' name='deleteInput' id='deleteInput'>
                  <button type='submit' name='deleteButton' id='deleteButton'>Delete</button>
                </form>
              </div>
            </section>";
          }
          closeConn($conn);
         ?>

      </div>
    </div>

    <div id="publicFeed" class="tabcontent">
      <div id="mainPublicContainer">
        <?php
          $conn = connectDB("localhost", "root", "");
          $postCount = getPublicPostsCount($conn);
          $posts = getPublicPosts($conn);
          for($i = $postCount - 1; $i >= 0; $i--){
            // DISPLAY ALL POSTS// POST title
            echo "<section class='postsContainer'>
              <div class='userConainer'><h1 class='postUser'>".getUsernameOfPost($conn, $posts[$i][0])."</h1></div>
              <div class='titleContainer'><h1 class='postTitle'>".$posts[$i][1]."</h1></div>
              <div class='textContainer'><p class='postText'>".$posts[$i][2]."</p></div>
              <div class='timestampContainer'><p class='time'>".$posts[$i][3]."</p>
                <form class='' action='./main.php' method='post'>
                  <input type='hidden' value='".$posts[$i][0]."' name='deleteInput' id='deleteInput'>
                  <button type='submit' name='deleteButton' id='deleteButton'>Delete</button>
                </form>
              </div>
            </section>";
          }
          closeConn($conn);
         ?>

      </div>
    </div>



    <footer>
      <div class="container">
        <p>Developer: ivinski@foi.hr</p>
      </div>
      <div class="container">
        <img src="../img/facebookIcon.png" alt="facebook"></img>
        <a href="https://hr.linkedin.com/in/ivanvinski"><img src="../img/linkedInIcon.png" alt="linkedIn"></img></a>
        <a href="https://github.com/VinsTheOne"><img src="../img/gitHubIcon.png" alt="gitHub"></img></a>
      </div>
    </footer>

  </body>
</html>
