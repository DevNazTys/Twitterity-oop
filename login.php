<?php
require_once "controllers/UserController.php";
require_once "classes/Auth.php";
require_once "classes/View.php";

// Redirect if already logged in
Auth::redirectIfLoggedIn();

$error = '';

// Handle login
$loginResult = UserController::handleLogin();
if ($loginResult !== null && !$loginResult['success']) {
    $error = $loginResult['message'];
}

// Render view with layout
View::renderWithLayout('partials/login-content', [
    'error' => $error,
    'pageTitle' => 'Login',
    'includeFontAwesome' => false,
    'includeJQuery' => false,
    'includeScript' => false
]);