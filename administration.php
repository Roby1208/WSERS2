<?php
//only admins!!!!
include_once "sessionCheck.php";
include_once "credentials.php";

if(!$_SESSION["UserLogged"])
{
    die("You are not logged in an not an administrator!");
}
$UserSelect = $connection ->prepare("SELECT UsrType FROM PPL WHERE PERSON_ID=?");
$UserSelect->bind_param("i", $_SESSION["CurrentUser"]);
$UserSelect->execute();
$resultUser= $UserSelect->get_result();
$rowUser = $resultUser->fetch_assoc();
if($rowUser["UsrType"]!== 1){
die ("You are not an admin");
}
