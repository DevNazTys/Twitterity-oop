<?php

require_once 'Database.php';

class User {
    private $db;
    private $id;
    private $name;
    private $email;
    private $password;
    private $createdAt;

    public function __construct($id = null) {
        $this->db = Database::getInstance();
        if ($id) {
            $this->loadUser($id);
        }
    }

    private function loadUser($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        
        if ($user) {
            $this->id = $user['id'];
            $this->name = $user['name'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->createdAt = $user['created_at'];
        }
    }

    public function register($name, $email, $password) {
        // Validate input
        if (empty($name) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Будь ласка, заповніть всі поля.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Некоректний формат електронної пошти.'];
        }

        if (strlen($password) < 8) {
            return ['success' => false, 'message' => 'Пароль має бути не менше 8 символів.'];
        }

        // Check if user already exists
        if ($this->emailExists($email)) {
            return ['success' => false, 'message' => 'Користувач з такою електронною поштою вже існує.'];
        }

        // Hash password and create user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashedPassword])) {
                $this->id = $this->db->lastInsertId();
                $this->name = $name;
                $this->email = $email;
                $this->password = $hashedPassword;
                return ['success' => true, 'message' => 'Ви успішно зареєстровані!'];
            } else {
                return ['success' => false, 'message' => 'Помилка реєстрації'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Помилка підготовки запиту: ' . $e->getMessage()];
        }
    }

    private function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Please enter email and password.'];
        }

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->name = $user['name'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->createdAt = $user['created_at'];
            return ['success' => true, 'user' => $this];
        } else {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }
    }

    public static function findByEmail($email) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userData = $stmt->fetch();
        
        if ($userData) {
            $user = new self();
            $user->id = $userData['id'];
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = $userData['password'];
            $user->createdAt = $userData['created_at'];
            return $user;
        }
        return null;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function update() {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$this->name, $this->email, $this->id]);
    }
} 