<?php

require_once __DIR__ . '/Environment.php';

class Database {
    private static $instance = null;
    private $connection;
    private $dbType;
    private $config;

    private function __construct() {
        Environment::load();
        $this->dbType = Environment::get('DB_TYPE', 'sqlite');
        $this->loadConfig();
        $this->connect();
        $this->createTables();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadConfig() {
        if ($this->dbType === 'mysql') {
            $this->config = [
                'host' => Environment::get('DB_MYSQL_HOST', 'localhost'),
                'port' => Environment::get('DB_MYSQL_PORT', '3306'),
                'database' => Environment::get('DB_MYSQL_DATABASE', 'twitterity'),
                'username' => Environment::get('DB_MYSQL_USERNAME', 'root'),
                'password' => Environment::get('DB_MYSQL_PASSWORD', ''),
                'charset' => Environment::get('DB_MYSQL_CHARSET', 'utf8mb4')
            ];
        } else {
            $this->config = [
                'path' => Environment::get('DB_SQLITE_PATH', 'database.sqlite')
            ];
        }
    }

    private function connect() {
        try {
            if ($this->dbType === 'mysql') {
                $dsn = "mysql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']};charset={$this->config['charset']}";
                $this->connection = new PDO($dsn, $this->config['username'], $this->config['password']);
            } else {
                // SQLite connection
                $sqlitePath = __DIR__ . '/../' . $this->config['path'];
                $this->connection = new PDO('sqlite:' . $sqlitePath);
            }
            
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: Database connection failed. " . $e->getMessage());
        }
    }

    private function createTables() {
        if ($this->dbType === 'mysql') {
            $this->createMySQLTables();
        } else {
            $this->createSQLiteTables();
        }
    }

    private function createSQLiteTables() {
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                content TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ");
    }

    private function createMySQLTables() {
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function getConnection() {
        return $this->connection;
    }

    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    public function getDbType() {
        return $this->dbType;
    }

    public function getConfig() {
        return $this->config;
    }

    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserialization of the instance
    public function __wakeup() {}
} 