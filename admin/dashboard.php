<?php
require_once '../config.php';

// Kiểm tra đăng nhập
if (!isAdminLoggedIn()) {
    redirect('login.php', 'Vui lòng đăng nhập', 'error');
}

$admin = getAdminInfo();

// Lấy tham số tìm kiếm và lọc
$search = sanitizeInput($_GET['search'] ?? '');
$status = sanitizeInput($_GET['status'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

// Xử lý cập nhật trạng thái
if (isset($_POST['update_status'])) {
    $contactId = intval($_POST['contact_id']);
    $newStatus = sanitizeInput($_POST['new_status']);

    try {
        $pdo = getDBConnection();
        $sql = "UPDATE contacts SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':status' => $newStatus, ':id' => $contactId]);
        redirect('dashboard.php', 'Cập nhật trạng thái thành công', 'success');
    } catch (PDOException $e) {
        error_log("Update Status Error: " . $e->getMessage());
    }
}

// Xử lý xóa
if (isset($_POST['delete_contact'])) {
    $contactId = intval($_POST['contact_id']);

    try {
        $pdo = getDBConnection();
        $sql = "DELETE FROM contacts WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $contactId]);
        redirect('dashboard.php', 'Xóa thành công', 'success');
    } catch (PDOException $e) {
        error_log("Delete Contact Error: " . $e->getMessage());
    }
}

// Lấy danh sách contacts
try {
    $pdo = getDBConnection();

    // Build query
    $whereClauses = [];
    $params = [];

    if ($search) {
        $whereClauses[] = "(name LIKE :search OR email LIKE :search OR phone LIKE :search OR message LIKE :search)";
        $params[':search'] = "%$search%";
    }

    if ($status) {
        $whereClauses[] = "status = :status";
        $params[':status'] = $status;
    }

    $whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

    // Đếm tổng số
    $countSql = "SELECT COUNT(*) as total FROM contacts $whereSQL";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($params);
    $totalContacts = $countStmt->fetch()['total'];
    $totalPages = ceil($totalContacts / $perPage);

    // Lấy dữ liệu
    $sql = "SELECT * FROM contacts $whereSQL ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll();

    // Thống kê
    $statsSql = "SELECT
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_count,
                    SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read_count,
                    SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied_count
                 FROM contacts";
    $statsStmt = $pdo->query($statsSql);
    $stats = $statsStmt->fetch();

} catch (PDOException $e) {
    error_log("Dashboard Error: " . $e->getMessage());
    $contacts = [];
    $totalContacts = 0;
    $totalPages = 0;
}

// Hàm lấy badge class theo status
function getStatusBadge($status) {
    switch ($status) {
        case 'new': return 'badge-new';
        case 'read': return 'badge-read';
        case 'replied': return 'badge-replied';
        default: return 'badge-default';
    }
}

// Hàm lấy tên status
function getStatusText($status) {
    switch ($status) {
        case 'new': return 'Mới';
        case 'read': return 'Đã đọc';
        case 'replied': return 'Đã trả lời';
        default: return $status;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin HiChina</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            background: linear-gradient(135deg, #0066cc 0%, #004a99 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 1.5rem;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-logout {
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.total { background: #e3f2fd; color: #0066cc; }
        .stat-icon.new { background: #fff3e0; color: #f57c00; }
        .stat-icon.read { background: #e8f5e9; color: #4caf50; }
        .stat-icon.replied { background: #f3e5f5; color: #9c27b0; }

        .stat-content h3 {
            font-size: 2rem;
            color: #333;
        }

        .stat-content p {
            color: #666;
        }

        .main-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-header h2 {
            color: #333;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-input {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 0.95rem;
        }

        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #0066cc;
            color: white;
        }

        .btn-primary:hover {
            background: #004a99;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f5f5f5;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #666;
        }

        tr:hover {
            background: #fafafa;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-new { background: #fff3e0; color: #f57c00; }
        .badge-read { background: #e8f5e9; color: #4caf50; }
        .badge-replied { background: #f3e5f5; color: #9c27b0; }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        .btn-info { background: #2196f3; color: white; }
        .btn-success { background: #4caf50; color: white; }
        .btn-danger { background: #f44336; color: white; }

        .pagination {
            padding: 20px 30px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .page-link {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
        }

        .page-link:hover, .page-link.active {
            background: #0066cc;
            color: white;
            border-color: #0066cc;
        }

        .empty-state {
            padding: 60px 30px;
            text-align: center;
            color: #999;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 30px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .info-row {
            margin-bottom: 20px;
        }

        .info-row label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .info-row .value {
            color: #666;
        }

        .flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 2000;
            animation: slideIn 0.3s ease;
        }

        .flash-success {
            background: #4caf50;
            color: white;
        }

        .flash-error {
            background: #f44336;
            color: white;
        }

        @keyframes slideIn {
            from { transform: translateX(400px); }
            to { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <div class="navbar-right">
            <div class="user-info">
                <i class="fas fa-user-circle" style="font-size: 1.5rem;"></i>
                <span><?= htmlspecialchars($admin['full_name'] ?? $admin['username']) ?></span>
            </div>
            <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    </nav>

    <div class="container">
        <!-- Flash Message -->
        <?php
        $flash = getFlashMessage();
        if ($flash):
        ?>
            <div class="flash-message flash-<?= $flash['type'] ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
            <script>
                setTimeout(() => {
                    document.querySelector('.flash-message').remove();
                }, 3000);
            </script>
        <?php endif; ?>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['total'] ?></h3>
                    <p>Tổng liên hệ</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon new">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['new_count'] ?></h3>
                    <p>Liên hệ mới</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon read">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['read_count'] ?></h3>
                    <p>Đã đọc</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon replied">
                    <i class="fas fa-reply"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['replied_count'] ?></h3>
                    <p>Đã trả lời</p>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="main-card">
            <div class="card-header">
                <h2>Danh sách liên hệ</h2>
                <form method="GET" class="filters">
                    <input type="text" name="search" class="filter-input" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($search) ?>">
                    <select name="status" class="filter-input" onchange="this.form.submit()">
                        <option value="">Tất cả trạng thái</option>
                        <option value="new" <?= $status === 'new' ? 'selected' : '' ?>>Mới</option>
                        <option value="read" <?= $status === 'read' ? 'selected' : '' ?>>Đã đọc</option>
                        <option value="replied" <?= $status === 'replied' ? 'selected' : '' ?>>Đã trả lời</option>
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                    <?php if ($search || $status): ?>
                        <a href="dashboard.php" class="btn btn-primary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="table-container">
                <?php if (count($contacts) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Chủ đề</th>
                                <th>Trạng thái</th>
                                <th>Ngày gửi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><?= $contact['id'] ?></td>
                                    <td><?= htmlspecialchars($contact['name']) ?></td>
                                    <td><?= htmlspecialchars($contact['email']) ?></td>
                                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                                    <td><?= htmlspecialchars($contact['subject']) ?></td>
                                    <td>
                                        <span class="badge <?= getStatusBadge($contact['status']) ?>">
                                            <?= getStatusText($contact['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-info btn-sm" onclick="viewContact(<?= htmlspecialchars(json_encode($contact)) ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Xác nhận xóa?')">
                                                <input type="hidden" name="contact_id" value="<?= $contact['id'] ?>">
                                                <button type="submit" name="delete_contact" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Không có dữ liệu</h3>
                        <p>Chưa có liên hệ nào hoặc không tìm thấy kết quả phù hợp</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>"
                           class="page-link <?= $i === $page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Chi tiết -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Chi tiết liên hệ</h2>
                <button class="close-modal" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        function viewContact(contact) {
            const modal = document.getElementById('contactModal');
            const modalBody = document.getElementById('modalBody');

            const subjectMap = {
                'support': 'Hỗ trợ kỹ thuật',
                'product': 'Thông tin sản phẩm',
                'warranty': 'Bảo hành',
                'complaint': 'Khiếu nại',
                'other': 'Khác'
            };

            modalBody.innerHTML = `
                <div class="info-row">
                    <label>Họ tên:</label>
                    <div class="value">${contact.name}</div>
                </div>
                <div class="info-row">
                    <label>Email:</label>
                    <div class="value">${contact.email}</div>
                </div>
                <div class="info-row">
                    <label>Số điện thoại:</label>
                    <div class="value">${contact.phone}</div>
                </div>
                <div class="info-row">
                    <label>Chủ đề:</label>
                    <div class="value">${subjectMap[contact.subject] || contact.subject}</div>
                </div>
                <div class="info-row">
                    <label>Nội dung:</label>
                    <div class="value">${contact.message}</div>
                </div>
                <div class="info-row">
                    <label>Trạng thái:</label>
                    <div class="value">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="contact_id" value="${contact.id}">
                            <select name="new_status" class="filter-input" onchange="this.form.submit()">
                                <option value="new" ${contact.status === 'new' ? 'selected' : ''}>Mới</option>
                                <option value="read" ${contact.status === 'read' ? 'selected' : ''}>Đã đọc</option>
                                <option value="replied" ${contact.status === 'replied' ? 'selected' : ''}>Đã trả lời</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary btn-sm">Cập nhật</button>
                        </form>
                    </div>
                </div>
                <div class="info-row">
                    <label>Thời gian gửi:</label>
                    <div class="value">${new Date(contact.created_at).toLocaleString('vi-VN')}</div>
                </div>
            `;

            modal.classList.add('active');

            // Nếu trạng thái là new, tự động đổi thành read
            if (contact.status === 'new') {
                setTimeout(() => {
                    fetch('', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: `update_status=1&contact_id=${contact.id}&new_status=read`
                    }).then(() => {
                        location.reload();
                    });
                }, 1000);
            }
        }

        function closeModal() {
            document.getElementById('contactModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('contactModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
