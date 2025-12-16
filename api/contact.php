<?php
/**
 * API xử lý form liên hệ
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once '../config.php';

// Chỉ cho phép POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

// Lấy dữ liệu từ POST
$name = sanitizeInput($_POST['name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$phone = sanitizeInput($_POST['phone'] ?? '');
$subject = sanitizeInput($_POST['subject'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Vui lòng nhập họ tên';
}

if (empty($email)) {
    $errors[] = 'Vui lòng nhập email';
} elseif (!validateEmail($email)) {
    $errors[] = 'Email không hợp lệ';
}

if (empty($phone)) {
    $errors[] = 'Vui lòng nhập số điện thoại';
} elseif (!validatePhone($phone)) {
    $errors[] = 'Số điện thoại không hợp lệ';
}

if (empty($message)) {
    $errors[] = 'Vui lòng nhập nội dung tin nhắn';
}

// Nếu có lỗi
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng kiểm tra lại thông tin',
        'errors' => $errors
    ]);
    exit;
}

// Lưu vào database
try {
    $pdo = getDBConnection();

    $sql = "INSERT INTO contacts (name, email, phone, subject, message, status, created_at)
            VALUES (:name, :email, :phone, :subject, :message, 'new', NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':subject' => $subject,
        ':message' => $message
    ]);

    // Lấy ID vừa insert
    $insertId = $pdo->lastInsertId();

    // Gửi email thông báo (tùy chọn - cần cấu hình mail server)
    // sendNotificationEmail($name, $email, $phone, $subject, $message);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.',
        'id' => $insertId
    ]);

} catch (PDOException $e) {
    error_log("Contact Form Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau.'
    ]);
}

/**
 * Hàm gửi email thông báo (tùy chọn)
 */
function sendNotificationEmail($name, $email, $phone, $subject, $message) {
    $to = "admin@hichina.vn";
    $subject_email = "Liên hệ mới từ website - " . $subject;
    $body = "
    Họ tên: $name
    Email: $email
    Số điện thoại: $phone
    Chủ đề: $subject
    Nội dung: $message
    ";

    $headers = "From: noreply@hichina.vn\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // mail($to, $subject_email, $body, $headers);
}
