<?php
include_once "sessionCheck.php";
include_once "credentials.php";

function displayUserDetails($connection)
{
    $userFromMyDatabase = $connection->prepare("SELECT * FROM ppl WHERE UserName=?");
}
$userFromMyDatabase->bind_param("i", $_SESSION["CurrentUser"]);
  $userFromMyDatabase->execute();
  $result = $userFromMyDatabase->get_result();
  $row = $result->fetch_assoc();
  print "First name:" . $row ["First_name"] . "<br>";
  print "Second name:" . $row ["Second_name"] . "<br>";
  print "Age:" . $row ["Age"] . "<br>";
  print "Username:" . $row ["Username"] . "<br>";
  $countrySelect = $connect ->prepare("SELECT COUONTRY_NAME FROM countries WHERE COUNTRY_ID=?");
  $countrySelect->bind_param("i", $row["Nationality"]);
  $countrySelect->execute();
  $resultContry= $countrySelect->get_result();
  $rowCountry = $resultContry->fetch_assoc();
?>

  <form action="login_page.php" method="post">
  <input type="submit" name="Logout" value="Logout">
</form>
<?php
if (isset($_POST["Logout"])) {

  session_unset();
  session_destroy();
  print "You have been successfully logged-out";
  ?>
<a href="login_page.php"> Click here to loggin again </a>
<?php
} elseif ($_SESSION["UserLogged"]) {
  print "You have already been logge-in" . "<br>";
  displayUserDetails($connection);
} elseif (isset($_POST["Username"]) && isset($_POST["Password"])) {
  //include_once "credentials.php"; // Create connection
  // Check connection
  $userFromMyDatabase = $connection->prepare(
    "SELECT * FROM ppl WHERE UserName=?"
  );
  $userFromMyDatabase->bind_param("s", $_POST["Username"]);
  $userFromMyDatabase->execute();
  $result = $userFromMyDatabase->get_result();
  if ($result->num_rows === 1) {
    print "Your password is being verified <BR>";
    $row = $result->fetch_assoc();
    if (password_verify($_POST["Password"], $row["Password"])) {
      $_SESSION["UserLogged"] = true;
      $_SESSION["CurrentUser"] = $row["PERSON_ID"];
      displayUserDetails($connection);
    } else {
      print "Wrong password ! Please type your password correctly";
    }
  } else {
    print "The username you typed has not been found in our database !! Please register first !"; ?> <a href="Signup.php">Click here to register</a> <br>
        <a href="login_page.php">Try again loggin-in</a>
    <?php
  }
} else {
   ?>
    <form action="login_page.php" method="post">
        Username: <input type="text" name="Username" placeholder="Your name.." required><br>
        Password: <input type="password" name="Password" placeholder="Password" required><br>
        <input type="submit" name="Login" value="Login">
    </form>
<?php
} ?>
