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
      print "First name:" . $row ["First_name"] . "<br>";
      print "Second name:" . $row ["Second_name"] . "<br>";
      print "Age:" . $row ["Age"] . "<br>";
      print "Username:" . $row ["Username"] . "<br>";
      $countrySelect = $connection ->prepare("SELECT COUONTRY_NAME FROM countries WHERE COUNTRY_ID=?");
      $countrySelect->bind_param("i", $row["Nationality"]);
      $countrySelect->execute();
      $resultContry= $countrySelect->get_result();
      $rowCountry = $resultContry->fetch_assoc();
      print "country: " . $rowCountry["COUNTRY_NAME"] . "<br>"
  }    
}
?>