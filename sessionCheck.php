<?php
session_start();
if (!isset($_SESSION["UserLogger"])){
    $_SESSION["UserLogger"] = false;    
}