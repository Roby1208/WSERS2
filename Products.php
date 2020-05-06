<?php
include_once "sessionCheck.php";
include_once "credentials.php";
include_once "userDisplay.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Products</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='cssfile.css'>
</head>

<body>
  <nav id="navigationBar">
    <div id="navigationTittle" class="whiteText">
      <h1>Products</h1>
    </div>
    <div id=navigationLinks>
      <a href="Products.html">
        <h1>Products</h1>
      </a>
      <a href="About.html">
        <h1>About</h1>
      </a>
    </div>

    <div id="login">
      <?php if (isset($_POST["Logout"])) {

        session_unset();
        session_destroy();
        print "You have been logged out successfully";
      ?> <a href="Products.php">Login</a><?php
                                        } elseif ($_SESSION["UserLogged"]) {
                                          print "You have already been logged-in" . "<br>";
                                          displayUserDetails($connection);
                                        } elseif (isset($_POST["Username"]) && isset($_POST["Password"])) {
                                          $userFromMyDatabase = $connection->prepare(
                                            "SELECT * FROM ppl WHERE UserName=?"
                                          );
                                          $userFromMyDatabase->bind_param("s", $_POST["Username"]);
                                          $userFromMyDatabase->execute();
                                          $result = $userFromMyDatabase->get_result();
                                          if ($result->num_rows === 1) {
                                            print "You have been successfully logged-in " . "<br>";
                                            $row = $result->fetch_assoc();
                                            if (password_verify($_POST["Password"], $row["Password"])) {
                                              $_SESSION["UserLogged"] = true;
                                              $_SESSION["CurrentUser"] = $row["PERSON_ID"];
                                              displayUserDetails($connection);
                                            } else {
                                              print "Password mismatched ! Please type your password correctly";
                                            }
                                          } else {
                                            print "The username you typed has not been found in our database !!"; ?>
          <a href="Signup.php">Please register first</a> <br>
          <a href="login.php">Try again to login</a>
        <?php
                                          }
                                        } else {
        ?>
        <form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="post">
          <div>
            <div>Username: <input type="text" name="Username" placeholder="Username" required></div>
            <div>Password: <input type="password" name="Password" placeholder="Password" required></div>
          </div>
          <input type="submit" name="Login" value="Login">
        </form>
      <?php
                                        } ?>
    </div>

    <?php if (isset($_SESSION["UserLogged"])) {
      if (!$_SESSION["UserLogged"]) { ?>
        <div id="Signup"><a href="Signup.php">Signup</a></div>
    <?php }
    } ?>
    <div id="navigationLanguage">
      <a href="">Language</a>
    </div>
  </nav>
  <h1>These are our products</h1>
  <div id="AllProducts">
    <div class="Product">
      <img src="pics/Spagetti.jpg" width="300" height="200">
      <p>Spagetti</p>
      <p>Price &euro;</p>
    </div>


    <div class="Product">
      <img src="pics/Pizza.jpg" width="300" height="200">
      <p>Pizza</p>
      <p>Price &euro;</p>
    </div>

    <div class="Product">
      <img src="pics/Kniddelen.jpg" width="300" height="200">
      <p>Kniddelen</p>
      <p>Price &euro;</p>
    </div>
  </div>
</body>

</html>