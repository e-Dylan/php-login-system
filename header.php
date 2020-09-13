
<?
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name = "description" content = "This is an example of a meta description. This will often show up in search results."
    <meta name = viewport content = "width = device-width, initial scale = 1">
    <title>User Login Database</title>
    <link rel = "stylesheet" href = "styles.css">
  </head>
  <body>

    <header>
      <nav class = "nav-header-main">
        <a class = "header-logo" href="index.php">
          <img src="images/database_logo.jpg" alt="database-logo">
        </a>

        <ul>
          <li><a class = "current" href="index.php">Home</a></li>
          <li><a href="#">Portfolio</a></li>
          <li><a href="#">About Me</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </nav>
      <div class = "header-login">
        <form action="includes/login.inc.php" method="post"> <!-- when sending sensitive information, post method hides from the url, get method doesn't -->
          <input class = "textbox" type="text" name="mailuid" placeholder = "Email/Username">
          <input class = "textbox" type="password" name="pwd" placeholder = "Password">
          <button class = "darkButton" id = "login-button" type="submit" name="login-submit">Login</button>
          <a class = "lightButton" id = signup-button href="signup.php">Signup</a>
          <form action="includes/logout.inc.php" method="post"> <!-- when sending sensitive information, post method hides from the url, get method doesn't -->
            <button class = "darkButton" id = "logout-button" type="submit" name="logout-submit">Logout</button>
          </form>
        </form>
      </div>
    </header>


  </body>


</html>
