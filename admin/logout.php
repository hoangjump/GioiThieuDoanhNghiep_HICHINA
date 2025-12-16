<?php
require_once '../config.php';

// Xóa session
unset($_SESSION[ADMIN_SESSION_NAME]);
session_destroy();

// Redirect về trang login
redirect('login.php', 'Đăng xuất thành công!', 'success');
