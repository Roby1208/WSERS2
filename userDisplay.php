<?php
function displayUserDetails($connection)
{
  if (!isset($_SESSION["CurrentUser"])){
    print "You are trying to display a user details witout loggin in";
  }else{
    $userFromMyDatabase = $connection->prepare("SELECT * FROM ppl WHERE PERSON_ID=?");
    $userFromMyDatabase->bind_param("i", $_SESSION["CurrentUser"]);
      $userFromMyDatabase->execute();
      $result = $userFromMyDatabase->get_result();
      $row = $result->fetch_assoc();
      print "First name:" . $row ["First_Name"] . "<br>";
      print "Second name:" . $row ["Second_Name"] . "<br>";
      print "Age:" . $row ["Age"] . "<br>";
      print "Username:" . $row ["UserName"] . "<br>";
      $countrySelect = $connection ->prepare("SELECT COUNTRY_NAME FROM COUNTRIES WHERE COUNTRY_ID=?");
      $countrySelect->bind_param("i", $row["Nationality"]);
      $countrySelect->execute();
      $resultContry= $countrySelect->get_result();
      $rowCountry = $resultContry->fetch_assoc();
      print "country: " . $rowCountry["COUNTRY_NAME"] . "<br>";
  }  
  ?>
<form action="login.php" method="post">
  <input type="submit" name="Logout" value="Logout">
</form>
<?php
  
}
?>