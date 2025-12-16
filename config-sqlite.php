<?php
/**
 * SQLite Configuration - NO MySQL needed!
 * Chỉ cần PHP, không cần cài thêm gì
 */

// Database settings
define('DB_FILE', __DIR__ . '/hichina.db');
define('ADMIN_SESSION_NAME', 'hichina_admin');

// Security
session_start();

/**
 * Kết nối SQLite database
 */
function getDBConnection() {
    try {
        // SQLite tự động tạo file nếu chưa có
        $pdo = new PDO('sqlite:' . DB_FILE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Tạo bảng nếu chưa có
        initDatabase($pdo);

        return $pdo;
    } catch (PDOException $e) {
        error_log("Database Connection Error: " . $e->getMessage());
        die("Lỗi kết nối cơ sở dữ liệu.");
    }
}

/**
 * Khởi tạo database (tự động chạy lần đầu)
 */
function initDatabase($pdo) {
    // Bảng contacts
    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT NOT NULL,
        subject TEXT NOT NULL,
        message TEXT NOT NULL,
        status TEXT DEFAULT 'new',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Bảng admin_users
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        email TEXT NOT NULL,
        full_name TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        last_login DATETIME
    )");

    // Thêm admin mặc định nếu chưa có
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM admin_users");
    $result = $stmt->fetch();

    if ($result['count'] == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO admin_users (username, password, email, full_name)
                    VALUES ('admin', '$password', 'admin@hichina.vn', 'Administrator')");
    }

    // Thêm dữ liệu mẫu cho contacts (tùy chọn)
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contacts");
    $result = $stmt->fetch();

    if ($result['count'] == 0) {
        $pdo->exec("INSERT INTO contacts (name, email, phone, subject, message, status) VALUES
            ('Nguyễn Văn A', 'nguyenvana@email.com', '0901234567', 'product', 'Tôi muốn tư vấn về máy lạnh', 'new'),
            ('Trần Thị B', 'tranthib@email.com', '0912345678', 'support', 'Sản phẩm bị lỗi', 'new'),
            ('Lê Văn C', 'levanc@email.com', '0923456789', 'warranty', 'Hỏi về bảo hành', 'read')");
    }
}

/**
 * Kiểm tra đăng nhập admin
 */
function isAdminLoggedIn() {
    return isset($_SESSION[ADMIN_SESSION_NAME]) && !empty($_SESSION[ADMIN_SESSION_NAME]);
}

/**
 * Lấy thông tin admin đang đăng nhập
 */
function getAdminInfo() {
    return $_SESSION[ADMIN_SESSION_NAME] ?? null;
}

/**
 * Redirect với message
 */
function redirect($url, $message = '', $type = 'info') {
    if ($message) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    header("Location: $url");
    exit;
}

/**
 * Lấy và xóa flash message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

/**
 * Làm sạch dữ liệu đầu vào
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate phone
 */
function validatePhone($phone) {
    return preg_match('/^[0-9+\-\s()]+$/', $phone);
}
