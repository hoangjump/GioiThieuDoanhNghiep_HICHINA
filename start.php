<?php
/**
 * Start Script - Giống "npm start" của React
 * Chạy lệnh: php start.php
 */

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    die("❌ Cần PHP 7.4 trở lên. Phiên bản hiện tại: " . PHP_VERSION . "\n");
}

// Check SQLite extension
if (!extension_loaded('pdo_sqlite')) {
    die("❌ SQLite extension chưa được bật. Vui lòng enable pdo_sqlite trong php.ini\n");
}

echo "🚀 Starting HiChina Website...\n\n";

// Initialize SQLite database
echo "📦 Initializing database...\n";
require_once 'config-sqlite.php';
$pdo = getDBConnection();
echo "✅ Database ready!\n\n";

// Get port from command line or use default
$host = 'localhost';
$port = isset($argv[1]) ? intval($argv[1]) : 8000;

echo "╔══════════════════════════════════════════════════════╗\n";
echo "║                                                      ║\n";
echo "║         🎉 HiChina Website is running!              ║\n";
echo "║                                                      ║\n";
echo "╚══════════════════════════════════════════════════════╝\n\n";

echo "📍 Access URLs:\n";
echo "   ➜ Frontend:  http://{$host}:{$port}\n";
echo "   ➜ Admin:     http://{$host}:{$port}/admin/login.php\n";
echo "   ➜ API:       http://{$host}:{$port}/api/contact.php\n\n";

echo "🔐 Admin Login:\n";
echo "   Username: admin\n";
echo "   Password: admin123\n\n";

echo "💾 Database: SQLite (hichina.db)\n";
echo "   - No MySQL needed!\n";
echo "   - Auto-created on first run\n\n";

echo "⚡ Press Ctrl+C to stop\n";
echo "───────────────────────────────────────────────────────\n\n";

// Start PHP built-in server
$command = "php -S {$host}:{$port}";
passthru($command);
