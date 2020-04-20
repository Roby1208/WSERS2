<?php
session_start();
//we need a boolian verable that thells us if the usder has already logged in or not
if (!issest($_SESSION["UserLogger"])){
    $_SESSION["UserLogger"] = false;    
}

?>