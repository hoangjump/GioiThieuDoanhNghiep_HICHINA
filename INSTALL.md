# Hướng dẫn cài đặt HiChina Website

## Yêu cầu hệ thống

- **Web Server**: Apache hoặc Nginx
- **PHP**: Phiên bản 7.4 trở lên
- **MySQL**: Phiên bản 5.7 trở lên hoặc MariaDB 10.2+
- **Extensions PHP cần có**:
  - PDO
  - pdo_mysql
  - mbstring
  - json

## Cách 1: Cài đặt với XAMPP (Windows/Mac/Linux)

### Bước 1: Cài đặt XAMPP

1. Tải XAMPP từ: https://www.apachefriends.org/
2. Cài đặt XAMPP theo hướng dẫn
3. Khởi động Apache và MySQL từ XAMPP Control Panel

### Bước 2: Copy source code

1. Copy thư mục `GioiThieuDoanhNghiep_HICHINA` vào thư mục:
   - **Windows**: `C:\xampp\htdocs\`
   - **Mac**: `/Applications/XAMPP/htdocs/`
   - **Linux**: `/opt/lampp/htdocs/`

### Bước 3: Tạo database

1. Mở trình duyệt, truy cập: http://localhost/phpmyadmin
2. Click tab "SQL"
3. Copy toàn bộ nội dung file `database.sql` và paste vào
4. Click "Go" để thực thi

**Hoặc** import bằng command line:
```bash
mysql -u root -p < database.sql
```

### Bước 4: Cấu hình database

Mở file `config.php` và chỉnh sửa thông tin kết nối database (nếu cần):

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Mật khẩu MySQL của bạn
define('DB_NAME', 'hichina_db');
```

### Bước 5: Truy cập website

- **Website chính**: http://localhost/GioiThieuDoanhNghiep_HICHINA/
- **Trang admin**: http://localhost/GioiThieuDoanhNghiep_HICHINA/admin/login.php

**Thông tin đăng nhập admin mặc định:**
- Username: `admin`
- Password: `admin123`

---

## Cách 2: Cài đặt với WAMP (Windows)

### Bước 1: Cài đặt WAMP

1. Tải WAMP từ: https://www.wampserver.com/
2. Cài đặt và khởi động WAMP
3. Click biểu tượng WAMP ở system tray, chọn "Put Online"

### Bước 2-5: Giống như với XAMPP

Thư mục cài đặt: `C:\wamp64\www\`

---

## Cách 3: Cài đặt trên hosting thực

### Bước 1: Upload file

1. Nén toàn bộ thư mục source code thành file .zip
2. Upload lên hosting qua FTP hoặc File Manager
3. Giải nén vào thư mục `public_html` hoặc `www`

### Bước 2: Tạo database

1. Truy cập cPanel hoặc hosting panel
2. Vào MySQL Database
3. Tạo database mới (ví dụ: `hichina_db`)
4. Tạo user và gán quyền cho database
5. Import file `database.sql` qua phpMyAdmin

### Bước 3: Cấu hình

Sửa file `config.php`:

```php
define('DB_HOST', 'localhost');  // Hoặc IP từ hosting
define('DB_USER', 'ten_user');   // Username database
define('DB_PASS', 'mat_khau');   // Password database
define('DB_NAME', 'ten_database');
define('SITE_URL', 'https://yourdomain.com');
```

### Bước 4: Thiết lập quyền file (nếu dùng Linux)

```bash
chmod 755 -R *
chmod 644 config.php
```

---

## Kiểm tra cài đặt

### 1. Kiểm tra trang chủ
Truy cập: `http://localhost/GioiThieuDoanhNghiep_HICHINA/`

Nếu thấy trang chủ hiển thị bình thường → OK!

### 2. Kiểm tra form liên hệ
1. Vào trang Liên hệ
2. Điền thông tin và gửi
3. Nếu thấy thông báo "Gửi thành công" → OK!

### 3. Kiểm tra admin panel
1. Truy cập: `http://localhost/GioiThieuDoanhNghiep_HICHINA/admin/login.php`
2. Đăng nhập với user: `admin` / pass: `admin123`
3. Kiểm tra danh sách liên hệ

---

## Xử lý lỗi thường gặp

### Lỗi 1: "Access denied for user"
**Nguyên nhân**: Sai thông tin database trong `config.php`

**Giải pháp**: Kiểm tra lại username, password database

### Lỗi 2: "Table doesn't exist"
**Nguyên nhân**: Chưa import database

**Giải pháp**: Import lại file `database.sql`

### Lỗi 3: "404 Not Found"
**Nguyên nhân**: Sai đường dẫn hoặc chưa bật mod_rewrite

**Giải pháp**:
- Kiểm tra lại đường dẫn URL
- Với Apache, enable mod_rewrite:
  ```bash
  sudo a2enmod rewrite
  sudo service apache2 restart
  ```

### Lỗi 4: "Session failed"
**Nguyên nhân**: Lỗi quyền thư mục session

**Giải pháp**:
```bash
# Linux
sudo chmod 777 /var/lib/php/sessions
```

### Lỗi 5: Form không gửi được
**Nguyên nhân**: Đường dẫn API sai

**Giải pháp**: Kiểm tra đường dẫn trong file `contact.html`:
```javascript
fetch('api/contact.php', {  // Đường dẫn tương đối
```

---

## Bảo mật

### 1. Đổi mật khẩu admin
Sau khi cài đặt xong, nên đổi mật khẩu admin:

```sql
UPDATE admin_users
SET password = '$2y$10$hash_moi'
WHERE username = 'admin';
```

Hoặc tạo hash mới bằng PHP:
```php
<?php
echo password_hash('mat_khau_moi', PASSWORD_DEFAULT);
?>
```

### 2. Xóa file INSTALL.md
Sau khi cài đặt xong, nên xóa file `INSTALL.md` và `database.sql` khỏi server thực.

### 3. Bảo vệ thư mục admin
Thêm vào file `.htaccess` trong thư mục `admin/`:

```apache
# Chặn truy cập từ IP không mong muốn
Order Deny,Allow
Deny from all
Allow from 123.456.789.0  # IP của bạn
Allow from localhost
Allow from 127.0.0.1
```

### 4. Enable HTTPS
Nên cài SSL certificate (Let's Encrypt miễn phí) và bắt buộc HTTPS.

---

## Tùy chỉnh

### Thay đổi logo và hình ảnh
1. Thêm logo vào thư mục `images/`
2. Sửa trong các file HTML:
```html
<div class="logo">
    <img src="images/logo.png" alt="HiChina">
    <h1>HiChina</h1>
</div>
```

### Thay đổi màu sắc
Sửa biến CSS trong `css/style.css`:
```css
:root {
    --primary-color: #0066cc;
    --secondary-color: #004a99;
    /* ... */
}
```

### Cấu hình email
Để nhận email khi có liên hệ mới, uncomment code trong `api/contact.php`:

```php
// Gửi email thông báo
sendNotificationEmail($name, $email, $phone, $subject, $message);
```

Và cấu hình SMTP server nếu cần.

---

## Hỗ trợ

Nếu gặp vấn đề, kiểm tra:
1. PHP error log: `xampp/php/logs/php_error_log`
2. Apache error log: `xampp/apache/logs/error.log`
3. MySQL log

Hoặc liên hệ: support@hichina.vn

---

**Chúc bạn cài đặt thành công! 🎉**
