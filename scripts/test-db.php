<?php

require_once __DIR__ . '/../classes/Environment.php';
require_once __DIR__ . '/../classes/Config.php';
require_once __DIR__ . '/../classes/Database.php';

echo "=== Database Configuration Test ===\n\n";

// Load current configuration
$dbInfo = Config::getDatabaseInfo();
$appInfo = Config::getAppInfo();

echo "Current Application Settings:\n";
echo "- App Name: " . $appInfo['name'] . "\n";
echo "- Environment: " . $appInfo['env'] . "\n";
echo "- Debug Mode: " . ($appInfo['debug'] ? 'ON' : 'OFF') . "\n\n";

echo "Current Database Configuration:\n";
echo "- Type: " . $dbInfo['type'] . "\n";

if ($dbInfo['type'] === 'mysql') {
    echo "- Host: " . $dbInfo['host'] . ":" . $dbInfo['port'] . "\n";
    echo "- Database: " . $dbInfo['database'] . "\n";
    echo "- Username: " . $dbInfo['username'] . "\n";
    echo "- Charset: " . $dbInfo['charset'] . "\n";
} else {
    echo "- Path: " . $dbInfo['path'] . "\n";
}

echo "\n=== Testing Database Connection ===\n";

try {
    $db = Database::getInstance();
    echo "✅ Database connection successful!\n";
    echo "Connected to: " . $db->getDbType() . "\n";
    
    // Test a simple query
    $stmt = $db->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $userCount = $stmt->fetchColumn();
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM posts");
    $stmt->execute();
    $postCount = $stmt->fetchColumn();
    
    echo "Database Statistics:\n";
    echo "- Users: " . $userCount . "\n";
    echo "- Posts: " . $postCount . "\n";
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n=== Instructions ===\n";
echo "To switch to MySQL:\n";
echo "1. Update .env file: DB_TYPE=mysql\n";
echo "2. Configure MySQL settings in .env file\n";
echo "3. Make sure MySQL server is running\n";
echo "4. Create database 'twitterity' in MySQL\n\n";

echo "To switch back to SQLite:\n";
echo "1. Update .env file: DB_TYPE=sqlite\n";
echo "2. Make sure SQLite database file exists\n\n";

echo "Current .env file content:\n";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo file_get_contents($envPath);
} else {
    echo "No .env file found!\n";
}
?> 