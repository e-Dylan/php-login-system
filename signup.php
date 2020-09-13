<?php
  require "header.php";
?>

  <main>
    <div class = "wrapper-main">
      <section class = "section-default">
        <h1>Signup</h1>

        <?php

      

        ?>

        <form class="form-signup" action="includes/signup.inc.php" method="post">
          <input class = "textbox" type="text" name="uid" placeholder = "Username">
          <input class = "textbox" type="text" name="mail" placeholder = "Email">
          <input class = "textbox" type="password" name="pwd" placeholder = "Password">
          <input class = "textbox" type="password" name="pwd-confirm" placeholder = "Confirm Password">
          <button class = "darkButton" id = "signup-form-button" type="submit" name="signup-submit">Signup</button>
        </form>
      </section>
    </div>
  </main>

<?php
  require "footer.php";
?>
