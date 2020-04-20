<?php
session_start();
if (!issest($_SESSION["UserLogger"])){
    $_SESSION["UserLogger"] = false;    
}

?>