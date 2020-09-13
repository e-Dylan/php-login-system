<?php

// (!mysqli_stmt_prepare($stmt, $sql) is failing to connect, throwing sql errors.
// when !conn such as this, supposed to be recieving errors displaying mysqli_connect_error(),
// however die is not producing.

// ALL BUGS FIXED, for some reason $conn var wasn't being defined when required from dbh.inc.php script
// was using wrong argument for header() function, not Location:, causing wrong page

  if (isset($_POST["signup-submit"])) {

      require "dbh.inc.php"; // links database to singup script, allows signup script to communicate with database
      $servername = "localhost"; // name of server, hosted locally = localhost. online server would require servername, could be found by logging in to the dashboard of online hosted server
      $dBUsername = "root";
      $dBPassword = "";
      $dBName = "user-database";

      $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

      $username = $_POST["uid"];
      $email = $_POST["mail"];
      $password = $_POST["pwd"];
      $passwordConfirm = $_POST["pwd-confirm"];

      if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)) {

        header("Location: ../signup.php?error = emptyfields&uid = ".$username."&mail".$email);
        exit(); // same as return() end. stops script if any errors in input form

      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {

        header("Location: ../signup/php?error = invalidmailuid");
        exit();

      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // filter_validate_email - php function

        header("Location: ../signup.php?error = invalidmail&uid".$username); // if email is invalid, return only username data
        exit();

      } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {

        header("Location: ../signup.php?error = invaliduid&mail".$email); // . links strings and vars, &mail is in string url, $email is var returning user email data
        exit();

      } else if ($password !== $passwordConfirm) {

        header("Location: ../signup.php?error = passwordcheck&uid = ".$username."&mail".$email);
        exit();

      } else {

        // checking if username is already taken
        // if entered username data matches a username within user-database uidUsers column
        $sql = "SELECT uidUsers FROM users WHERE uidUsers = ?"; // ? is a placeholder, for prepared statement. stops users from entering code input input to be run when fetched
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { // if prepare of connection init and userid column in database fails

          header("Location: ../signup.php?error = sqlerror"); // sql error
          exit();

        } else {

          mysqli_stmt_bind_param($stmt, "s", $username); // 2 strings, 2 s's
          mysqli_stmt_execute($stmt); // executes userdata to database
          mysqli_stmt_store_result($stmt); // stores returned data from database in $stmt var
          $resultCheck = mysqli_stmt_num_rows($stmt); // checks number of rows given in returned data from database, to check if more than one row is returned (username was already in database, making 2 when added)
          if ($resultCheck > 0) {

            header("Location: ../signup.php?error = usertaken&mail = ".$email);
            exit();

          } else {

            $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)"; // insert data into users table, in 3 columns, giving placeholder values to remain secure
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) { // if $sql and $stmt can actually function together, if not run error and send user back

                header("Location: ../signup.php?error = sqlerror2");
                exit();

            } else { // when stmts work

              $hashedPwd = password_hash($password, PASSWORD_DEFAULT); // md5 and shai256 are outdated hashing methods, bcrypt is updated constantly

              mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd); // insert userdata into database
              mysqli_stmt_execute($stmt);                                          // this is when passwords are hashed, hashed password gets inserted
              header("Location: ../index.php?signup=success");
              exit();

            }

          }

        }

      }

      mysqli_stmt_close($stmt);
      mysqli_close($conn);

  } else {

    header("Location ../signup.php");
    exit();

  }

?>
