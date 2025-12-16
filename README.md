# HiChina - Website Thiết bị Gia dụng

Website giới thiệu doanh nghiệp chuyên phân phối thiết bị gia dụng chất lượng cao, lấy cảm hứng từ website Apeco.

## Giới thiệu

HiChina là website doanh nghiệp chuyên cung cấp các thiết bị gia dụng hiện đại, chất lượng cao cho thị trường Việt Nam và khu vực Châu Á Thái Bình Dương.

## Tính năng chính

- **Giao diện hiện đại**: Thiết kế chuyên nghiệp với màu xanh dương chủ đạo
- **Đa ngôn ngữ**: Hỗ trợ Tiếng Việt và Tiếng Anh
- **Responsive**: Tương thích với mọi thiết bị (Desktop, Tablet, Mobile)
- **SEO Friendly**: Cấu trúc HTML semantic chuẩn SEO
- **Form liên hệ**: Lưu trữ thông tin liên hệ vào database MySQL
- **Admin Panel**: Quản lý danh sách liên hệ với đầy đủ chức năng CRUD
- **Authentication**: Hệ thống đăng nhập bảo mật cho admin

## Cấu trúc trang

1. **Trang chủ (index.html)**
   - Hero section với slogan nổi bật
   - Giới thiệu ngắn về công ty
   - Danh mục sản phẩm chính
   - Lý do chọn HiChina
   - Tin tức mới nhất

2. **Giới thiệu (about.html)**
   - Câu chuyện công ty
   - Sứ mệnh & Tầm nhìn
   - Giá trị cốt lõi
   - Hành trình phát triển

3. **Sản phẩm (products.html)**
   - Danh sách sản phẩm đa dạng
   - Phân loại theo danh mục (Nhà bếp, Làm mát, Điện tử, Giặt giũ)
   - Bộ lọc sản phẩm
   - Chi tiết sản phẩm với giá cả

4. **Dịch vụ (services.html)**
   - Bán sản phẩm chính hãng
   - Lắp đặt & Vận hành
   - Bảo hành & Sửa chữa
   - Tư vấn miễn phí
   - Giao hàng & Lắp đặt
   - Thu cũ đổi mới

5. **Tin tức (news.html)**
   - Tin tức nổi bật
   - Sản phẩm mới
   - Khuyến mãi
   - Sự kiện
   - Mẹo hay

6. **Liên hệ (contact.html)**
   - Form liên hệ
   - Thông tin liên hệ
   - Bản đồ văn phòng
   - Hệ thống showroom

## Công nghệ sử dụng

### Frontend
- **HTML5**: Cấu trúc trang web
- **CSS3**: Styling và animations
- **JavaScript (ES6+)**: Tính năng tương tác
- **Font Awesome 6**: Icons
- **Google Maps**: Bản đồ địa chỉ

### Backend
- **PHP 7.4+**: Server-side scripting
- **MySQL 5.7+**: Cơ sở dữ liệu
- **PDO**: Database connection và prepared statements
- **Session**: Quản lý đăng nhập admin

## Cài đặt và chạy

### Yêu cầu
- PHP 7.4+
- MySQL 5.7+ hoặc MariaDB 10.2+
- Apache hoặc Nginx web server
- XAMPP/WAMP (cho môi trường development)

### Hướng dẫn cài đặt chi tiết

**Xem file [INSTALL.md](INSTALL.md) để có hướng dẫn chi tiết từng bước.**

### Cài đặt nhanh với XAMPP

1. Clone repository vào thư mục `htdocs`:
```bash
cd C:\xampp\htdocs\
git clone <repository-url>
```

2. Tạo database:
   - Mở http://localhost/phpmyadmin
   - Import file `database.sql`

3. Cấu hình database trong `config.php` (nếu cần)

4. Truy cập website:
   - Frontend: http://localhost/GioiThieuDoanhNghiep_HICHINA/
   - Admin: http://localhost/GioiThieuDoanhNghiep_HICHINA/admin/login.php

## Cấu trúc thư mục

```
GioiThieuDoanhNghiep_HICHINA/
│
├── css/
│   └── style.css          # File CSS chính
│
├── js/
│   └── main.js            # File JavaScript chính
│
├── api/
│   └── contact.php        # API xử lý form liên hệ
│
├── admin/
│   ├── login.php          # Trang đăng nhập admin
│   ├── dashboard.php      # Dashboard quản lý liên hệ
│   └── logout.php         # Xử lý đăng xuất
│
├── images/                # Thư mục chứa hình ảnh
├── assets/                # Thư mục chứa tài nguyên khác
│
├── index.html             # Trang chủ
├── about.html             # Trang giới thiệu
├── products.html          # Trang sản phẩm
├── services.html          # Trang dịch vụ
├── news.html              # Trang tin tức
├── contact.html           # Trang liên hệ
│
├── config.php             # Cấu hình database
├── database.sql           # Schema database
├── README.md              # File hướng dẫn
└── INSTALL.md             # Hướng dẫn cài đặt chi tiết
```

## Tính năng nổi bật

### 1. Chuyển đổi ngôn ngữ
- Hỗ trợ Tiếng Việt và Tiếng Anh
- Lưu lựa chọn ngôn ngữ vào localStorage
- Tự động cập nhật toàn bộ nội dung

### 2. Animations
- Hiệu ứng cuộn mượt mà
- Animation khi hover
- Counter animation cho thống kê
- Fade-in khi scroll

### 3. Responsive Design
- Mobile-first approach
- Breakpoints: 480px, 768px, 1024px
- Touch-friendly navigation

### 4. Form Validation
- Kiểm tra dữ liệu đầu vào
- Thông báo lỗi trực quan
- Xác nhận gửi form thành công

## Tùy chỉnh

### Màu sắc
Chỉnh sửa biến CSS trong file `css/style.css`:

```css
:root {
    --primary-color: #0066cc;
    --secondary-color: #004a99;
    --accent-color: #00a8ff;
    --text-dark: #333;
    --text-light: #666;
    --bg-light: #f8f9fa;
    --white: #ffffff;
    --border-color: #e0e0e0;
}
```

### Nội dung
Chỉnh sửa trực tiếp trong các file HTML hoặc thêm thuộc tính `data-vi` và `data-en` cho các phần tử cần đa ngôn ngữ.

## Trình duyệt hỗ trợ

- Chrome (phiên bản mới nhất)
- Firefox (phiên bản mới nhất)
- Safari (phiên bản mới nhất)
- Edge (phiên bản mới nhất)
- Opera (phiên bản mới nhất)

## License

© 2025 HiChina. All rights reserved.

## Admin Panel

### Truy cập
- URL: `http://localhost/GioiThieuDoanhNghiep_HICHINA/admin/login.php`
- Username mặc định: `admin`
- Password mặc định: `admin123`

### Tính năng
- **Dashboard**: Thống kê tổng quan (tổng liên hệ, mới, đã đọc, đã trả lời)
- **Danh sách liên hệ**: Hiển thị tất cả liên hệ với phân trang
- **Tìm kiếm & Lọc**: Tìm kiếm theo tên/email/phone, lọc theo trạng thái
- **Xem chi tiết**: Xem đầy đủ thông tin liên hệ trong modal
- **Cập nhật trạng thái**: Đổi trạng thái liên hệ (Mới → Đã đọc → Đã trả lời)
- **Xóa liên hệ**: Xóa các liên hệ không cần thiết
- **Tự động đánh dấu đã đọc**: Khi xem chi tiết, tự động chuyển từ "Mới" sang "Đã đọc"

### Bảo mật
- Mã hóa mật khẩu bằng bcrypt
- Session-based authentication
- CSRF protection
- SQL injection prevention với PDO Prepared Statements
- XSS protection với htmlspecialchars

## Database Schema

### Bảng: contacts
Lưu trữ thông tin liên hệ từ form

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | INT | Primary key, auto increment |
| name | VARCHAR(255) | Họ tên người liên hệ |
| email | VARCHAR(255) | Email |
| phone | VARCHAR(50) | Số điện thoại |
| subject | VARCHAR(255) | Chủ đề (support, product, warranty, complaint, other) |
| message | TEXT | Nội dung tin nhắn |
| status | ENUM | Trạng thái: new, read, replied |
| created_at | TIMESTAMP | Thời gian gửi |
| updated_at | TIMESTAMP | Thời gian cập nhật |

### Bảng: admin_users
Lưu trữ tài khoản admin

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | INT | Primary key, auto increment |
| username | VARCHAR(100) | Tên đăng nhập (unique) |
| password | VARCHAR(255) | Mật khẩu đã hash (bcrypt) |
| email | VARCHAR(255) | Email admin |
| full_name | VARCHAR(255) | Họ tên đầy đủ |
| created_at | TIMESTAMP | Ngày tạo tài khoản |
| last_login | TIMESTAMP | Lần đăng nhập cuối |

## API Endpoints

### POST /api/contact.php
Xử lý form liên hệ

**Request Body:**
```json
{
  "name": "Nguyễn Văn A",
  "email": "example@email.com",
  "phone": "0901234567",
  "subject": "product",
  "message": "Nội dung tin nhắn"
}
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Cảm ơn bạn đã liên hệ!...",
  "id": 123
}
```

**Response Error (400):**
```json
{
  "success": false,
  "message": "Vui lòng kiểm tra lại thông tin",
  "errors": ["Email không hợp lệ", "..."]
}
```

## Liên hệ

- Email: info@hichina.vn
- Phone: +84 123 456 789
- Website: www.hichina.vn

---

Phát triển bởi Claude với cảm hứng từ thiết kế website Apeco.
