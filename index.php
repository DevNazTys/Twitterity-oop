<?php
session_start();

if (isset($_SESSION["userid"])) {
    header("location: homepage.php");
    exit;
} else {
    header("location: login.php");
    exit;
}