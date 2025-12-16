# 🐳 Chạy HiChina với Docker (KHÔNG CẦN XAMPP)

## Yêu cầu

- Cài Docker Desktop: https://www.docker.com/products/docker-desktop/
- Chỉ cần 1 lần cài, sau đó mọi thứ tự động!

---

## 🚀 Cách chạy (3 lệnh)

### Bước 1: Clone code
```bash
git clone <repository-url>
cd GioiThieuDoanhNghiep_HICHINA
```

### Bước 2: Chạy Docker
```bash
docker-compose up -d
```

### Bước 3: Truy cập
- **Website**: http://localhost:8080
- **Admin**: http://localhost:8080/admin/login.php
- **phpMyAdmin**: http://localhost:8081
  - Username: `root`
  - Password: `root`

✅ **Xong!** Database tự động import, không cần config gì thêm!

---

## 📋 Các lệnh hữu ích

### Dừng website
```bash
docker-compose down
```

### Khởi động lại
```bash
docker-compose up -d
```

### Xem logs (nếu lỗi)
```bash
docker-compose logs -f web
```

### Xóa hết và chạy lại từ đầu
```bash
docker-compose down -v
docker-compose up -d --build
```

### Vào MySQL console
```bash
docker exec -it hichina_db mysql -u root -proot hichina_db
```

---

## 🔧 Cấu trúc Docker

File `docker-compose.yml` bao gồm 3 services:

1. **web** (PHP 8.1 + Apache)
   - Port: 8080
   - Chứa source code website

2. **db** (MySQL 8.0)
   - Port: 3306
   - Auto import `database.sql`
   - Username: root / Password: root

3. **phpmyadmin**
   - Port: 8081
   - Quản lý database qua web

---

## ❓ Troubleshooting

### Lỗi: Port đã được sử dụng
Sửa port trong `docker-compose.yml`:
```yaml
ports:
  - "9000:80"  # Đổi từ 8080 sang 9000
```

### Database không import
```bash
# Xóa và tạo lại
docker-compose down -v
docker-compose up -d
```

### Muốn thay đổi mật khẩu MySQL
Sửa trong `docker-compose.yml`:
```yaml
environment:
  MYSQL_ROOT_PASSWORD: password_moi
```

---

## 💡 Ưu điểm của Docker

✅ **Không cần XAMPP/WAMP**
✅ **Tự động cài PHP, MySQL, Apache**
✅ **Database tự động import**
✅ **Dễ chia sẻ cho team**
✅ **Môi trường giống production**
✅ **Xóa sạch khi không dùng**

---

## 🎯 So sánh với XAMPP

| Tiêu chí | XAMPP | Docker |
|----------|-------|--------|
| Cài đặt | ~150MB | ~1GB (lần đầu) |
| Khởi động | Thủ công | 1 lệnh |
| Import DB | Thủ công | Tự động |
| Cấu hình | Phức tạp | Không cần |
| Xóa clean | Khó | 1 lệnh |
| Team work | Khó sync | Dễ (share compose file) |

---

## 📦 File liên quan

- `docker-compose.yml`: Cấu hình các services
- `Dockerfile`: Cấu hình PHP + Apache
- `database.sql`: Tự động import khi khởi động

---

**Happy Coding with Docker! 🐳**
