<?php

class Environment {
    private static $env = [];
    private static $loaded = false;

    public static function load($filePath = '.env') {
        if (self::$loaded) {
            return;
        }

        if (!file_exists($filePath)) {
            // Set default values if .env file doesn't exist
            self::setDefaults();
            self::$loaded = true;
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes if present
                if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                    (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                
                self::$env[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    private static function setDefaults() {
        self::$env = [
            'DB_TYPE' => 'sqlite',
            'DB_SQLITE_PATH' => 'databases/database.sqlite',
            'DB_MYSQL_HOST' => 'localhost',
            'DB_MYSQL_PORT' => '3306',
            'DB_MYSQL_DATABASE' => 'twitterity',
            'DB_MYSQL_USERNAME' => 'root',
            'DB_MYSQL_PASSWORD' => '',
            'DB_MYSQL_CHARSET' => 'utf8mb4',
            'APP_NAME' => 'Twitterity',
            'APP_ENV' => 'development',
            'APP_DEBUG' => 'true'
        ];
    }

    public static function get($key, $default = null) {
        if (!self::$loaded) {
            self::load();
        }
        
        return self::$env[$key] ?? $default;
    }

    public static function set($key, $value) {
        self::$env[$key] = $value;
    }

    public static function all() {
        if (!self::$loaded) {
            self::load();
        }
        
        return self::$env;
    }
} 