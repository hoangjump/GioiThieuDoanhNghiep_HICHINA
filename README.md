# HiChina - Website Thiết bị Gia dụng

Website giới thiệu doanh nghiệp chuyên phân phối thiết bị gia dụng chất lượng cao, lấy cảm hứng từ website Apeco.

## Giới thiệu

HiChina là website doanh nghiệp chuyên cung cấp các thiết bị gia dụng hiện đại, chất lượng cao cho thị trường Việt Nam và khu vực Châu Á Thái Bình Dương.

## Tính năng chính

- **Giao diện hiện đại**: Thiết kế chuyên nghiệp với màu xanh dương chủ đạo
- **Đa ngôn ngữ**: Hỗ trợ Tiếng Việt và Tiếng Anh
- **Responsive**: Tương thích với mọi thiết bị (Desktop, Tablet, Mobile)
- **SEO Friendly**: Cấu trúc HTML semantic chuẩn SEO

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

- **HTML5**: Cấu trúc trang web
- **CSS3**: Styling và animations
- **JavaScript (ES6+)**: Tính năng tương tác
- **Font Awesome 6**: Icons
- **Google Maps**: Bản đồ địa chỉ

## Cài đặt và chạy

1. Clone repository:
```bash
git clone <repository-url>
```

2. Mở file `index.html` bằng trình duyệt web hoặc sử dụng Live Server

3. Không cần cài đặt thêm dependencies vì đây là static website

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
├── images/                # Thư mục chứa hình ảnh
├── assets/                # Thư mục chứa tài nguyên khác
│
├── index.html             # Trang chủ
├── about.html             # Trang giới thiệu
├── products.html          # Trang sản phẩm
├── services.html          # Trang dịch vụ
├── news.html              # Trang tin tức
├── contact.html           # Trang liên hệ
└── README.md              # File hướng dẫn
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

## Liên hệ

- Email: info@hichina.vn
- Phone: +84 123 456 789
- Website: www.hichina.vn

---

Phát triển bởi Claude với cảm hứng từ thiết kế website Apeco.
