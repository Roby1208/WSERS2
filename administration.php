<?php
//only admins!!!!
include_once "sessionCheck.php";
include_once "credentials.php";

if($_SESSION["UserLogged"])
{
    die("You are not logged in an not an administrator!");
}
 