<?php
/**
 * Simple SCSS compilation script
 * This script provides a basic way to compile SCSS to CSS
 * For production use, consider using Sass CLI or build tools
 */

echo "=== SCSS Compilation Script ===\n";

// Check if required directories exist
$scssDir = __DIR__ . '/../scss';
$cssDir = __DIR__ . '/../css';

if (!is_dir($scssDir)) {
    echo "❌ SCSS directory not found: $scssDir\n";
    exit(1);
}

if (!is_dir($cssDir)) {
    echo "📁 Creating CSS directory: $cssDir\n";
    mkdir($cssDir, 0755, true);
}

echo "📂 SCSS source: $scssDir\n";
echo "📂 CSS output: $cssDir\n\n";

// Instructions for compilation
echo "To compile SCSS to CSS, you have several options:\n\n";

echo "🔧 Option 1: Using Sass CLI (Recommended)\n";
echo "   1. Install Sass globally: npm install -g sass\n";
echo "   2. Compile once: sass scss/main.scss css/style.css\n";
echo "   3. Watch for changes: sass --watch scss/main.scss css/style.css\n";
echo "   4. Build compressed: sass scss/main.scss css/style.css --style compressed\n\n";

echo "🔧 Option 2: Using npm scripts\n";
echo "   1. Install dependencies: npm install\n";
echo "   2. Compile once: npm run scss\n";
echo "   3. Watch for changes: npm run scss:watch\n";
echo "   4. Build for production: npm run scss:build\n\n";

echo "🔧 Option 3: Online SCSS compiler\n";
echo "   1. Copy content from scss/main.scss\n";
echo "   2. Use online tool like sassmeister.com\n";
echo "   3. Save compiled CSS to css/style.css\n\n";

echo "📋 Current SCSS structure:\n";
showDirectoryTree($scssDir, '');

function showDirectoryTree($dir, $prefix = '') {
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $path = $dir . '/' . $item;
        echo $prefix . '├── ' . $item . "\n";
        
        if (is_dir($path)) {
            showDirectoryTree($path, $prefix . '│   ');
        }
    }
}

echo "\n✅ SCSS files are ready for compilation!\n";
echo "📝 Main entry point: scss/main.scss\n";
echo "🎯 Output target: css/style.css\n";
?> 