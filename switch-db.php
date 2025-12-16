<?php
/**
 * Database Switcher
 * Chuyển đổi giữa MySQL và SQLite
 */

$action = $argv[1] ?? 'help';

switch ($action) {
    case 'sqlite':
        switchToSQLite();
        break;

    case 'mysql':
        switchToMySQL();
        break;

    case 'status':
        showStatus();
        break;

    default:
        showHelp();
        break;
}

function switchToSQLite() {
    echo "🔄 Switching to SQLite...\n";

    $files = [
        'api/contact.php',
        'admin/login.php',
        'admin/dashboard.php'
    ];

    foreach ($files as $file) {
        if (!file_exists($file)) {
            echo "❌ File not found: $file\n";
            continue;
        }

        $content = file_get_contents($file);
        $content = str_replace("require_once '../config.php';", "require_once '../config-sqlite.php';", $content);
        file_put_contents($file, $content);

        echo "✅ Updated: $file\n";
    }

    echo "\n✅ Switched to SQLite!\n";
    echo "Run: php start.php\n";
}

function switchToMySQL() {
    echo "🔄 Switching to MySQL...\n";

    $files = [
        'api/contact.php',
        'admin/login.php',
        'admin/dashboard.php'
    ];

    foreach ($files as $file) {
        if (!file_exists($file)) {
            echo "❌ File not found: $file\n";
            continue;
        }

        $content = file_get_contents($file);
        $content = str_replace("require_once '../config-sqlite.php';", "require_once '../config.php';", $content);
        file_put_contents($file, $content);

        echo "✅ Updated: $file\n";
    }

    echo "\n✅ Switched to MySQL!\n";
    echo "Make sure MySQL is running!\n";
}

function showStatus() {
    $file = 'api/contact.php';

    if (!file_exists($file)) {
        echo "❌ Cannot determine status\n";
        return;
    }

    $content = file_get_contents($file);

    if (strpos($content, 'config-sqlite.php') !== false) {
        echo "📊 Current Database: SQLite ✅\n";
        echo "   File: hichina.db\n";
        echo "   Status: " . (file_exists('hichina.db') ? 'Exists' : 'Not created yet') . "\n";
    } else {
        echo "📊 Current Database: MySQL 🗄️\n";
        echo "   Host: localhost\n";
        echo "   Database: hichina_db\n";
    }
}

function showHelp() {
    echo "╔══════════════════════════════════════════════════════╗\n";
    echo "║        Database Switcher - HiChina                   ║\n";
    echo "╚══════════════════════════════════════════════════════╝\n\n";

    echo "Usage: php switch-db.php [command]\n\n";

    echo "Commands:\n";
    echo "  sqlite    Switch to SQLite (no MySQL needed)\n";
    echo "  mysql     Switch back to MySQL\n";
    echo "  status    Show current database type\n";
    echo "  help      Show this help\n\n";

    echo "Examples:\n";
    echo "  php switch-db.php sqlite    # Use SQLite\n";
    echo "  php switch-db.php mysql     # Use MySQL\n";
    echo "  php switch-db.php status    # Check current DB\n";
}
