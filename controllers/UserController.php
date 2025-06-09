<?php

require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Auth.php';

class UserController {
    
    public static function handleRegistration() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return null;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST["confirm_password"] ?? '');

        // Basic validation
        if ($password !== $confirmPassword) {
            return ['success' => false, 'message' => 'Паролі не співпадають.'];
        }

        $user = new User();
        $result = $user->register($name, $email, $password);
        
        if ($result['success']) {
            // Optionally auto-login after registration
            // Auth::login($user);
        }
        
        return $result;
    }

    public static function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['submit'])) {
            return null;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = new User();
        $result = $user->login($email, $password);
        
        if ($result['success']) {
            Auth::login($result['user']);
            header("Location: /dashboard");
            exit;
        }
        
        return $result;
    }

    public static function logout() {
        Auth::logout();
        header("Location: /login");
        exit;
    }
} 