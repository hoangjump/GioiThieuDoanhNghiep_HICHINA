-- Tạo database
CREATE DATABASE IF NOT EXISTS hichina_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE hichina_db;

-- Bảng lưu thông tin liên hệ
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng admin users
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo tài khoản admin mặc định (username: admin, password: admin123)
INSERT INTO admin_users (username, password, email, full_name)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@hichina.vn', 'Administrator')
ON DUPLICATE KEY UPDATE username=username;

-- Chèn dữ liệu mẫu cho contacts (tùy chọn)
INSERT INTO contacts (name, email, phone, subject, message, status) VALUES
('Nguyễn Văn A', 'nguyenvana@email.com', '0901234567', 'product', 'Tôi muốn tư vấn về máy lạnh Inverter', 'new'),
('Trần Thị B', 'tranthib@email.com', '0912345678', 'support', 'Sản phẩm của tôi bị lỗi, cần hỗ trợ', 'new'),
('Lê Văn C', 'levanc@email.com', '0923456789', 'warranty', 'Hỏi về thời gian bảo hành máy giặt', 'read');
