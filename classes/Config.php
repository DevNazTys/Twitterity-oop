<?php

require_once __DIR__ . '/Environment.php';

class Config {
    
    public static function getDatabaseInfo() {
        Environment::load();
        
        $dbType = Environment::get('DB_TYPE', 'sqlite');
        
        if ($dbType === 'mysql') {
            return [
                'type' => 'mysql',
                'host' => Environment::get('DB_MYSQL_HOST', 'localhost'),
                'port' => Environment::get('DB_MYSQL_PORT', '3306'),
                'database' => Environment::get('DB_MYSQL_DATABASE', 'twitterity'),
                'username' => Environment::get('DB_MYSQL_USERNAME', 'root'),
                'charset' => Environment::get('DB_MYSQL_CHARSET', 'utf8mb4')
            ];
        } else {
            return [
                'type' => 'sqlite',
                'path' => Environment::get('DB_SQLITE_PATH', 'database.sqlite')
            ];
        }
    }
    
    public static function getAppInfo() {
        Environment::load();
        
        return [
            'name' => Environment::get('APP_NAME', 'Twitterity'),
            'env' => Environment::get('APP_ENV', 'development'),
            'debug' => Environment::get('APP_DEBUG', 'true') === 'true'
        ];
    }
    
    public static function isDebugMode() {
        return self::getAppInfo()['debug'];
    }
    
    public static function getAppName() {
        return self::getAppInfo()['name'];
    }
    
    public static function switchDatabase($type) {
        if (!in_array($type, ['sqlite', 'mysql'])) {
            throw new InvalidArgumentException('Database type must be either "sqlite" or "mysql"');
        }
        
        Environment::set('DB_TYPE', $type);
        
        // Save to .env file
        self::updateEnvFile('DB_TYPE', $type);
    }
    
    private static function updateEnvFile($key, $value) {
        $envFile = '.env';
        $content = '';
        
        if (file_exists($envFile)) {
            $content = file_get_contents($envFile);
        }
        
        // Update existing key or add new one
        if (preg_match("/^{$key}=.*$/m", $content)) {
            $content = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $content);
        } else {
            $content .= "\n{$key}={$value}";
        }
        
        file_put_contents($envFile, $content);
    }
} 