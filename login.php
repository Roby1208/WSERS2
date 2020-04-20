<?php
include_once "sessionCheck.php";

if($_SESSION["UserLogged"]){
    print "you already have logged in". "<br>";

}
    elseif (isset($_POST["Username"]) && isset($_POST["Password"])) {
    include_once "credentials.php";
    // Create connection
    $connection = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $userFromMyDatabase = $connection->prepare("SELECT * FROM ppl WHERE UserName=?"
    );
    $userFromMyDatabase->bind_param("s", $_POST["Username"]);
    $userFromMyDatabase->execute();
    $result = $userFromMyDatabase->get_result();
    if ($result->num_rows === 1) {
        print "We are checking your password <BR>";
        $row = $result->fetch_assoc();

        if (password_verify($_POST["Password"], $row["Password"])) {
            print "First name:" . $row ["First_name"] . "<br>";
            print "Second name:" . $row ["Second_name"] . "<br>";
            print "Age:" . $row ["Age"] . "<br>";
            print "Username:" . $row ["Username"] . "<br>";
            $countrySelect = $connect ->prepare("SELECT COUONTRY_NAME FROM countries WHERE");
            $countrySelect->bind_param("i", $row["Nationality"]);
            $countrySelect->execute();
            $resultContry= $countrySelect->get_result();
            $rowCountry = $resultContry->fetch_assoc();
            print "Country: " . $rowCountry["COUNTRY_NAME"] . "<br>";
            $_SESSION["UserLogger"] = true;
        } else {
            print "Wrong password !";
        }
    } else {
        print "Your username is not in our database !! Please consider registering !"; ?> <a href="Signup.php">Go to the signup page</a>
            <a href="Login.php">Try again</a>
        <?php
    }
} else {
     ?>
<form action="Login.php" method="post">
    Username: <input type="text" name="Username" required><br>
    Password: <input type="text" name="Password" required><br>    
    <input type="submit" name="Login" value="Login">
</form>
<?php
}
?>