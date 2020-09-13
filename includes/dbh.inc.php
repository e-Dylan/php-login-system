<?

  $servername = "localhost"; // name of server, hosted locally = localhost. online server would require servername, could be found by logging in to the dashboard of online hosted server
  $dBUsername = "root";
  $dBPassword = "";
  $dBName = "user-database";

  $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

  if (!$conn) {

    die("Connection failed: ".mysqli_connect_error())
    console.log(mysqli_connect_error());

  }

?>
