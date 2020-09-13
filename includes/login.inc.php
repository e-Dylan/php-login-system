<?php

  if (isset($_POST["login-submit"])) {

    require "dbh.inc.php";
    $servername = "localhost"; // name of server, hosted locally = localhost. online server would require servername, could be found by logging in to the dashboard of online hosted server
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "user-database";
    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

    $mailuid = $_POST["mailuid"];
    $password = $_POST["pwd"];

    if (empty($mailuid) || empty($password)) {

      header("Location: ../index.php?error = emptyfields&mailuid".$mailuid);
      exit();

    } else {

      $sql = "SELECT * FROM users WHERE uidUsers = ? OR emailUsers = ?;"; // checking username and email columns in database
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)) { // if cant prepare, if cant communicate, return connect error data

        header("Location: ../index.php?error = sqlerror1");
        print("SQL Error:".mysqli_connect_error());
        exit();

      } else {

        mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) { // putting returned data into assoc array - form of data that can be worked with in php

          $pwdCheck = password_verify($password, $row["pwdUsers"]); // takes input password, hashes it, and compares to correlating hashed password in database to check if matching
          if ($pwdCheck == false) { // if password doesnt match database

            header("Location: ../index.php?error = incorrectpassword&".$username);
            exit();

          } else if ($pwdCheck == true) { // if password matches password of result user/mail array

            session_start();
            $_SESSION["userId"] = $row["idUsers"];
            $_SESSION["userUid"] = $row["uidUsers"];
            //$_SESSION["userEmail"] = $row["emailUsers"];

            header("Location: ../index.php?login-success");
            exit();

          } else { // if $pwdCheck isnt a boolean

            header("Location: ../index.php?error = incorrectpwd");
            exit();

          }

        } else {

          header("Location: ../index.php?error = nouser");
          exit();

        }

      }

    }

  } else {

    header("Location: index.php"); // send home if not accessing login script from signup button (type = login-submit)
    exit();

  }

?>
