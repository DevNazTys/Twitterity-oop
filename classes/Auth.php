<?php

require_once 'User.php';

class Auth {
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(User $user) {
        self::startSession();
        $_SESSION['userid'] = $user->getId();
        $_SESSION['name'] = $user->getName();
        $_SESSION['email'] = $user->getEmail();
    }

    public static function logout() {
        self::startSession();
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['userid']) && !empty($_SESSION['userid']);
    }

    public static function getCurrentUser() {
        self::startSession();
        if (self::isLoggedIn()) {
            return new User($_SESSION['userid']);
        }
        return null;
    }

    public static function getCurrentUserId() {
        self::startSession();
        return $_SESSION['userid'] ?? null;
    }

    public static function getCurrentUserName() {
        self::startSession();
        return $_SESSION['name'] ?? null;
    }

    public static function getCurrentUserEmail() {
        self::startSession();
        return $_SESSION['email'] ?? null;
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("Location: /login");
            exit;
        }
    }

    public static function redirectIfLoggedIn($redirectTo = '/dashboard') {
        if (self::isLoggedIn()) {
            header("Location: $redirectTo");
            exit;
        }
    }
} 