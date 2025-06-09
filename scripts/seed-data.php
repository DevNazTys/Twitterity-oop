<?php
/**
 * Data Seeding Script
 * Generates dummy users and posts for testing the application
 */

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Post.php';

echo "=== Twitterity Data Seeder ===\n\n";

// Sample data arrays for realistic content
$firstNames = [
    'John', 'Jane', 'Mike', 'Sarah', 'David', 'Emma', 'Chris', 'Lisa', 'Ryan', 'Anna',
    'Mark', 'Emily', 'James', 'Jessica', 'Robert', 'Ashley', 'Michael', 'Amanda', 'Daniel', 'Samantha',
    'Alex', 'Maria', 'Kevin', 'Laura', 'Brian', 'Rachel', 'Steven', 'Nicole', 'Thomas', 'Stephanie'
];

$lastNames = [
    'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
    'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin',
    'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson'
];

$postTemplates = [
    "Just had an amazing coffee at the local café! ☕",
    "Working on a new project today. Feeling excited! 💻",
    "Beautiful sunset tonight! Nature never fails to amaze me 🌅",
    "Reading a great book and can't put it down 📚",
    "Trying a new recipe for dinner. Wish me luck! 👨‍🍳",
    "Great workout session at the gym today! 💪",
    "Spending quality time with family this weekend ❤️",
    "Just finished watching an incredible movie! 🎬",
    "Learning something new every day keeps me motivated 🧠",
    "Enjoying a peaceful walk in the park 🌳",
    "Excited about the upcoming weekend plans! 🎉",
    "Technology is advancing so fast these days 🚀",
    "Music is the universal language of mankind 🎵",
    "Traveling opens your mind to new possibilities ✈️",
    "Cooking is my therapy after a long day 🍳",
    "Photography helps me capture beautiful moments 📸",
    "Grateful for all the wonderful people in my life 🙏",
    "Sports teach us valuable life lessons ⚽",
    "Art is the expression of the soul 🎨",
    "Science continues to blow my mind every day 🔬"
];

$techPosts = [
    "Working with PHP and loving the flexibility it offers! #coding",
    "Just deployed my latest web application. Feels great! #webdev",
    "Learning about database optimization techniques today #database",
    "CSS Grid is a game-changer for responsive layouts! #frontend",
    "Debugging can be frustrating but so rewarding when you fix it! #programming",
    "Clean code is not just about functionality, it's about readability #cleancode",
    "Version control with Git has saved me countless times #git",
    "Responsive design is crucial in today's mobile-first world #responsive",
    "APIs are the backbone of modern web applications #api",
    "Security should never be an afterthought in development #security"
];

function generateRandomName($firstNames, $lastNames) {
    $firstName = $firstNames[array_rand($firstNames)];
    $lastName = $lastNames[array_rand($lastNames)];
    return $firstName . ' ' . $lastName;
}

function generateRandomEmail($name) {
    $cleanName = strtolower(str_replace(' ', '.', $name));
    $domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'example.com'];
    $domain = $domains[array_rand($domains)];
    $number = rand(1, 999);
    return $cleanName . $number . '@' . $domain;
}

function generateRandomPost($postTemplates, $techPosts) {
    $allPosts = array_merge($postTemplates, $techPosts);
    return $allPosts[array_rand($allPosts)];
}

function askForNumber($prompt, $min = 1, $max = 1000) {
    do {
        echo $prompt;
        $input = trim(fgets(STDIN));
        
        if (!is_numeric($input)) {
            echo "❌ Please enter a valid number.\n";
            continue;
        }
        
        $number = (int)$input;
        
        if ($number < $min || $number > $max) {
            echo "❌ Please enter a number between $min and $max.\n";
            continue;
        }
        
        return $number;
        
    } while (true);
}

try {
    // Test database connection
    $db = Database::getInstance();
    echo "✅ Database connection successful!\n";
    echo "Connected to: " . $db->getDbType() . "\n\n";
    
    // Get current counts
    $stmt = $db->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $currentUsers = $stmt->fetchColumn();
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM posts");
    $stmt->execute();
    $currentPosts = $stmt->fetchColumn();
    
    echo "📊 Current database status:\n";
    echo "- Users: $currentUsers\n";
    echo "- Posts: $currentPosts\n\n";
    
    // Ask for number of users to create
    $numUsers = askForNumber("👥 How many users would you like to create? (1-100): ", 1, 100);
    
    // Ask for number of posts to create
    $numPosts = askForNumber("📝 How many posts would you like to create? (1-500): ", 1, 500);
    
    echo "\n🚀 Starting data generation...\n\n";
    
    // Generate users
    echo "👥 Creating $numUsers users...\n";
    $userIds = [];
    
    for ($i = 1; $i <= $numUsers; $i++) {
        $name = generateRandomName($firstNames, $lastNames);
        $email = generateRandomEmail($name);
        $password = 'password123'; // Simple password for testing
        
        $user = new User();
        $result = $user->register($name, $email, $password);
        
        if ($result['success']) {
            $userIds[] = $user->getId();
            echo "✅ Created user $i/$numUsers: $name ($email) - ID: " . $user->getId() . "\n";
        } else {
            echo "❌ Failed to create user $i/$numUsers: " . $result['message'] . "\n";
        }
        
        // Small delay to avoid overwhelming the system
        if ($i % 10 == 0) {
            usleep(100000); // 0.1 second
        }
    }
    
    echo "\n📝 Creating $numPosts posts...\n";
    
    if (empty($userIds)) {
        echo "❌ No users available to create posts. Please create users first.\n";
        exit(1);
    }
    
    // Generate posts
    $post = new Post();
    
    for ($i = 1; $i <= $numPosts; $i++) {
        $userId = $userIds[array_rand($userIds)]; // Random user
        $content = generateRandomPost($postTemplates, $techPosts);
        
        $result = $post->create($userId, $content);
        
        if ($result['success']) {
            echo "✅ Created post $i/$numPosts by user ID $userId\n";
        } else {
            echo "❌ Failed to create post $i/$numPosts: " . $result['message'] . "\n";
        }
        
        // Small delay to avoid overwhelming the system
        if ($i % 20 == 0) {
            usleep(100000); // 0.1 second
        }
    }
    
    // Show final statistics
    echo "\n📊 Data generation complete!\n\n";
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $finalUsers = $stmt->fetchColumn();
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM posts");
    $stmt->execute();
    $finalPosts = $stmt->fetchColumn();
    
    echo "📈 Final database statistics:\n";
    echo "- Total users: $finalUsers (+" . ($finalUsers - $currentUsers) . ")\n";
    echo "- Total posts: $finalPosts (+" . ($finalPosts - $currentPosts) . ")\n\n";
    
    echo "🎉 Data seeding completed successfully!\n";
    echo "💡 You can now test the application with realistic data.\n";
    echo "🔑 All test users have the password: 'password123'\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "💡 Make sure your database is properly configured and accessible.\n";
    exit(1);
}
?> 