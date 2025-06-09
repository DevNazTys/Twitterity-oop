<?php
require_once "controllers/UserController.php";
require_once "classes/Auth.php";

// Redirect if already logged in
Auth::redirectIfLoggedIn();

$error = '';
$result = '';

// Handle registration
$registrationResult = UserController::handleRegistration();
if ($registrationResult !== null) {
    if ($registrationResult['success']) {
        $result = $registrationResult['message'];
    } else {
        $error = $registrationResult['message'];
    }
}

// Include the view
include 'views/register.php';
