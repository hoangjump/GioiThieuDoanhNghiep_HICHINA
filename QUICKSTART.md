# ⚡ Quick Start - Chạy NGAY không cần cài gì!

## 🎯 Cách 1: SQLite Version (GIỐNG REACT)

### Chỉ cần PHP (có sẵn trên Mac/Linux)

```bash
# 1. Clone code
git clone <repo-url>
cd GioiThieuDoanhNghiep_HICHINA

# 2. Chạy (1 lệnh duy nhất!)
php start.php

# 3. Mở trình duyệt
http://localhost:8000
```

✅ **VẬY THÔI!** Không cần MySQL, không cần XAMPP, không cần cài gì!

### Windows (nếu chưa có PHP)

**Tải PHP portable** (không cần install):
1. Download: https://windows.php.net/download/ (Thread Safe ZIP)
2. Giải nén vào `C:\php`
3. Chạy: `C:\php\php.exe start.php`

---

## 🌐 Cách 2: JSON Version (CHỈ CẦN BROWSER)

### Không cần backend, chỉ HTML/JS

```bash
# 1. Clone code
git clone <repo-url>
cd GioiThieuDoanhNghiep_HICHINA

# 2. Mở file
# Double-click index.html

# HOẶC dùng Live Server (VS Code)
# Right click > Open with Live Server
```

✅ **Không cần PHP, không cần database!**
❌ Nhược điểm: Không có admin panel, data lưu trong LocalStorage

---

## ☁️ Cách 3: Online Hosting (DEPLOY 1 LẦN)

### Deploy lên InfinityFree (Miễn phí mãi mãi)

1. Đăng ký: https://www.infinityfree.net/
2. Tạo account (1 phút)
3. Upload code qua File Manager
4. Import `database.sql` qua phpMyAdmin
5. Done! Có domain miễn phí

**Ví dụ**: `hichina.great-site.net`

✅ **Không cần cài gì trên máy!**
✅ **Có SSL + Domain miễn phí**
✅ **Truy cập từ mọi nơi**

---

## 📊 So sánh:

| Phương án | Cài đặt | Thời gian | Admin Panel | Điểm |
|-----------|---------|-----------|-------------|------|
| **SQLite** | PHP only | 10s | ✅ Full | ⭐⭐⭐⭐⭐ |
| **JSON** | None | 5s | ❌ Không | ⭐⭐⭐⭐ |
| **Hosting** | None | 5 phút | ✅ Full | ⭐⭐⭐⭐⭐ |
| Docker | Docker Desktop | 2 phút | ✅ Full | ⭐⭐⭐⭐ |
| XAMPP | 150MB | 10 phút | ✅ Full | ⭐⭐⭐ |

---

## 🚀 Khuyến nghị:

### Bạn muốn:
- **Chạy ngay lập tức?** → SQLite (php start.php)
- **Không có PHP?** → JSON version
- **Share cho người khác?** → Deploy lên hosting
- **Làm việc team?** → Docker

---

## 🔧 Chi tiết SQLite Version

### Ưu điểm:
✅ Database là 1 file (`hichina.db`)
✅ Tự động tạo bảng lần đầu
✅ Tự động thêm admin account
✅ Không cần config gì
✅ Cross-platform (Windows/Mac/Linux)

### File liên quan:
- `config-sqlite.php` - Config SQLite thay vì MySQL
- `start.php` - Script khởi động (giống npm start)
- `hichina.db` - Database file (tự động tạo)

### API và Admin vẫn hoạt động bình thường!
- ✅ Form contact lưu vào DB
- ✅ Admin dashboard đầy đủ tính năng
- ✅ Login/logout
- ✅ CRUD operations

---

## 🆚 SQLite vs MySQL

| Tính năng | SQLite | MySQL |
|-----------|--------|-------|
| Server | ❌ Không cần | ✅ Cần chạy service |
| File | ✅ 1 file .db | ✅ Nhiều file |
| Setup | ⚡ Tự động | 🐢 Thủ công |
| Performance | ✅ Nhanh cho small app | ✅ Tốt cho large app |
| Concurrent writes | ⚠️ Limited | ✅ Excellent |

**Kết luận**: SQLite **hoàn hảo** cho demo, development, small projects!

---

## ❓ Troubleshooting

### Lỗi: "pdo_sqlite extension not found"
**Windows**: Mở `php.ini`, uncomment:
```ini
extension=pdo_sqlite
```

**Mac/Linux**: SQLite enabled mặc định

### Lỗi: Port 8000 đã dùng
```bash
# Đổi port
php -S localhost:9000
```

### Muốn reset database
```bash
# Xóa file database
rm hichina.db

# Chạy lại, tự động tạo mới
php start.php
```

---

## 📁 Files mới:

```
✨ config-sqlite.php  - SQLite config
✨ start.php          - Start script
✨ QUICKSTART.md      - File này
✨ hichina.db         - Database (auto-created)
```

---

**Happy Coding! ⚡**

P/S: Thích SQLite thì đổi `require 'config.php'` → `require 'config-sqlite.php'` trong các file PHP!
