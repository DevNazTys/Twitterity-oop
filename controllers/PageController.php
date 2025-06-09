<?php

require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/View.php';
require_once __DIR__ . '/UserController.php';
require_once __DIR__ . '/PostController.php';

class PageController {
    
    public static function home() {
        // Redirect to login if not authenticated
        if (!Auth::isLoggedIn()) {
            Router::redirect('/login');
            return;
        }
        
        // Redirect to dashboard if authenticated
        Router::redirect('/dashboard');
    }
    
    public static function login() {
        // Redirect if already logged in
        Auth::redirectIfLoggedIn('/dashboard');

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
    }
    
    public static function register() {
        // Redirect if already logged in
        Auth::redirectIfLoggedIn('/dashboard');

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

        // Render view with layout
        View::renderWithLayout('partials/register-content', [
            'error' => $error,
            'result' => $result,
            'pageTitle' => 'Register',
            'includeFontAwesome' => false,
            'includeJQuery' => false,
            'includeScript' => false
        ]);
    }
    
    public static function dashboard() {
        // Require login
        Auth::requireLogin();

        // Get user posts
        $userId = Auth::getCurrentUserId();
        $posts = PostController::getUserPosts($userId);

        // Render view with layout
        View::renderWithLayout('partials/dashboard-content', [
            'posts' => $posts,
            'pageTitle' => 'My Posts',
            'includeFontAwesome' => true,
            'includeJQuery' => true,
            'includeScript' => true
        ]);
    }
    
    public static function posts() {
        // Require login
        Auth::requireLogin();

        // Getting all posts
        $posts = PostController::getAllPosts();
        $userId = Auth::getCurrentUserId();

        // Render view with layout
        View::renderWithLayout('partials/posts-content', [
            'posts' => $posts,
            'userId' => $userId,
            'pageTitle' => 'All Posts',
            'includeFontAwesome' => true,
            'includeJQuery' => true,
            'includeScript' => true
        ]);
    }
    
    public static function logout() {
        UserController::logout();
    }
} 