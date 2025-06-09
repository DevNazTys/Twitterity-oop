<?php
require_once "classes/Auth.php";

if (Auth::isLoggedIn()) {
    header("location: homepage.php");
    exit;
} else {
    header("location: login.php");
    exit;
}