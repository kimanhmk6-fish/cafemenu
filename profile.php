<?php
// File: profile.php - Trang cá nhân
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    setMessage('Vui lòng đăng nhập để xem trang cá nhân', 'error');
    redirect('login.php?redirect=profile.php');
}

$page_title = 'Trang cá nhân';
require_once 'includes/header.php';

$user_id = $_SESSION['user_id'];
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'info';

// ====================== LẤY DỮ LIỆU ======================
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
$stmt->close();

// ====================== STATUS TEXT ======================
$status_text = [
    'pending'   => 'Chờ xác nhận',
    'confirmed' => 'Đã xác nhận',
    'shipping'  => 'Đang giao hàng',
    'completed' => 'Hoàn thành',
    'cancelled' => 'Đã hủy',
    'delivered' => 'Đã giao'
];

$status_color = [
    'pending'   => '#fff3cd',
    'confirmed' => '#cfe2ff',
    'shipping'  => '#fff3cd',
    'completed' => '#d4edda',
    'cancelled' => '#f8d7da',
    'delivered' => '#d4edda'
];

$status_text_color = [
    'pending'   => '#856404',
    'confirmed' => '#004085',
    'shipping'  => '#856404',
    'completed' => '#155724',
    'cancelled' => '#721c24',
    'delivered' => '#155724'
];

// ====================== XỬ LÝ CẬP NHẬT THÔNG TIN ======================
if (isset($_POST['update_profile'])) {
    $fullname = escape($_POST['fullname']);
    $phone    = escape($_POST['phone']);
    $address  = escape($_POST['address']);

    $stmt = $conn->prepare("UPDATE users SET fullname = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->bind_param("sssi", $fullname, $phone, $address, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['fullname'] = $fullname;
        setMessage('Cập nhật thông tin thành công');
    } else {
        setMessage('Có lỗi xảy ra', 'error');
    }
    $stmt->close();
    redirect('profile.php');
}

// ====================== XỬ LÝ ĐỔI MẬT KHẨU ======================
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm      = $_POST['confirm_password'];

    if (password_verify($old_password, $user['password'] ?? '')) {
        if ($new_password === $confirm) {
            if (strlen($new_password) >= 6) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed, $user_id);
                $stmt->execute();
                $stmt->close();
                
                setMessage('Đổi mật khẩu thành công');
            } else {
                setMessage('Mật khẩu mới phải có ít nhất 6 ký tự', 'error');
            }
        } else {
            setMessage('Mật khẩu mới không khớp', 'error');
        }
    } else {
        setMessage('Mật khẩu cũ không đúng', 'error');
    }
    redirect('profile.php?tab=password');
}

// ====================== HÀM TIỆN ÍCH ======================
function formatDate($date) {
    return $date ? date('d/m/Y', strtotime($date)) : 'N/A';
}

function formatDateTime($datetime) {
    return $datetime ? date('d/m/Y H:i', strtotime($datetime)) : 'N/A';
}
?>

<style>
:root {
    --card-bg: #fdf8f2;
    --accent-brown: #6b4a3a;
    --bg-color: #d8cbb7;
    --dark-brown: #2b1f18;
}
.form-group { margin-bottom: 20px; }
.form-group label {
    display: block;
    color: var(--dark-brown);
    font-weight: 600;
    margin-bottom: 8px;
}
.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e0d3c2;
    border-radius: 10px;
    background: white;
    box-sizing: border-box;
    font-size: 1rem;
}
.form-group input:disabled {
    background: #f0f0f0;
    cursor: not-allowed;
}
.btn-primary {
    background: #6b4a3a;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}
.btn-primary:hover { background: #2b1f18; }
.order-card {
    background: white;
    border-radius: 15px;
    margin-bottom: 25px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e8dcd0;
}
.order-status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}
@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
</style>

<section class="py-3">
    <div class="container">
        <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px;">
            
            <!-- Sidebar -->
            <div style="background: var(--card-bg); border-radius: 20px; overflow: hidden;">
                <div style="background: var(--accent-brown); color: white; padding: 30px 20px; text-align: center;">
                    <div style="width: 80px; height: 80px; background: var(--bg-color); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: var(--dark-brown);">
                        👤
                    </div>
                    <h3 style="color: white; margin-bottom: 5px;"><?php echo htmlspecialchars($user['fullname'] ?? ''); ?></h3>
                    <p style="opacity: 0.9; font-size: 0.9rem;"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                </div>
                
                <div style="padding: 20px;">
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;">
                            <a href="?tab=info" class="<?php echo $active_tab == 'info' ? 'active' : ''; ?>" 
                               style="display:block;padding:10px;border-radius:8px;color:var(--dark-brown);text-decoration:none;<?php echo $active_tab == 'info' ? 'background:var(--bg-color);font-weight:600;' : ''; ?>">
                                Thông tin cá nhân
                            </a>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <a href="?tab=orders" class="<?php echo $active_tab == 'orders' ? 'active' : ''; ?>" 
                               style="display:block;padding:10px;border-radius:8px;color:var(--dark-brown);text-decoration:none;<?php echo $active_tab == 'orders' ? 'background:var(--bg-color);font-weight:600;' : ''; ?>">
                                Đơn hàng
                            </a>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <a href="?tab=password" class="<?php echo $active_tab == 'password' ? 'active' : ''; ?>" 
                               style="display:block;padding:10px;border-radius:8px;color:var(--dark-brown);text-decoration:none;<?php echo $active_tab == 'password' ? 'background:var(--bg-color);font-weight:600;' : ''; ?>">
                                Đổi mật khẩu
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div style="background: var(--card-bg); padding: 30px; border-radius: 20px;">
                
                <?php if ($active_tab == 'info'): ?>
                    <!-- ====================== TAB THÔNG TIN ====================== -->
                    <h2 style="margin-bottom: 30px;">Thông tin cá nhân</h2>
                    <form method="post">
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" disabled style="background:#f8f9fa;">
                            <small style="color:#666;">Email không thể thay đổi</small>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Ngày tham gia</label>
                            <input type="text" value="<?php echo formatDate($user['created_at']); ?>" disabled style="background:#f8f9fa;">
                        </div>
                        <button type="submit" name="update_profile" class="btn-primary">Cập nhật</button>
                    </form>

                <?php elseif ($active_tab == 'orders'): ?>
                    <!-- ====================== TAB ĐƠN HÀNG ====================== -->
                    <h2 style="margin-bottom: 30px;">Lịch sử đơn hàng</h2>
                    <?php if ($orders->num_rows == 0): ?>
                        <p style="text-align:center;padding:40px;">Chưa có đơn hàng nào. <a href="menu.php">Đặt hàng ngay!</a></p>
                    <?php else: ?>
                        <?php while ($order = $orders->fetch_assoc()):
                            $details = $conn->query("SELECT od.*, p.name, p.image 
                                                   FROM order_details od 
                                                   JOIN products p ON od.product_id = p.id 
                                                   WHERE od.order_id = " . (int)$order['id']);
                        ?>
                            <div class="order-card">
                                <div class="order-header">
                                    <div>
                                        <strong style="font-size:16px;">Đơn hàng #<?php echo $order['id']; ?></strong>
                                        <span style="margin-left:15px;font-size:13px;color:#666;">
                                            <?php echo formatDateTime($order['created_at']); ?>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="order-status" data-order-id="<?php echo $order['id']; ?>"
                                              style="background:<?php echo $status_color[$order['status']] ?? '#f0f0f0'; ?>;color:<?php echo $status_text_color[$order['status']] ?? '#333'; ?>">
                                            <?php echo $status_text[$order['status']] ?? ucfirst($order['status']); ?>
                                        </span>
                                    </div>
                                </div>

                                <div style="margin-bottom:15px;">
                                    <?php while ($detail = $details->fetch_assoc()):
                                        $detail_price = $detail['price_at_purchase'];
                                        $detail_subtotal = $detail_price * $detail['quantity'];
                                        $imagePath = '/cafemenu/' . $detail['image'];
                                    ?>
                                        <div style="display:flex;align-items:center;gap:15px;padding:10px 0;border-bottom:1px solid #eee;">
                                            <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                                 style="width:50px;height:50px;object-fit:cover;border-radius:8px;background:#634832;"
                                                 onerror="this.src='/cafemenu/img/default.png'">
                                            <div style="flex:1;">
                                                <strong><?php echo htmlspecialchars($detail['name']); ?></strong>
                                                <div style="font-size:13px;color:#666;">
                                                    Size: <span style="background:#e8dcd0;padding:2px 8px;border-radius:12px;">
                                                        <?php echo htmlspecialchars($detail['size'] ?? 'M'); ?>
                                                    </span> × <?php echo $detail['quantity']; ?>
                                                </div>
                                            </div>
                                            <div style="text-align:right;">
                                                <div><?php echo number_format($detail_price); ?>đ</div>
                                                <div style="font-size:13px;color:#a67c52;">
                                                    Thành tiền: <?php echo number_format($detail_subtotal); ?>đ
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>

                                <div style="text-align:right;margin-top:15px;padding-top:10px;border-top:1px dashed #ddd;">
                                    <?php if (!empty($order['note'])): ?>
                                        <div style="font-size:13px;color:#666;margin-bottom:8px;">
                                            Ghi chú: <?php echo htmlspecialchars($order['note']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($order['address'])): ?>
                                        <div style="font-size:13px;color:#444;margin-bottom:5px;">
                                            Địa chỉ giao hàng: <?php echo htmlspecialchars($order['address']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div style="font-size:18px;font-weight:bold;color:#a67c52;">
                                        Tổng cộng: <?php echo number_format($order['total_price']); ?>đ
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>

                <?php elseif ($active_tab == 'password'): ?>
                    <!-- ====================== TAB ĐỔI MẬT KHẨU ====================== -->
                    <h2 style="margin-bottom:30px;">Đổi mật khẩu</h2>
                    <form method="post" style="max-width:400px;">
                        <div class="form-group">
                            <label>Mật khẩu cũ</label>
                            <input type="password" name="old_password" required>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu mới</label>
                            <input type="password" name="new_password" required>
                            <small>Ít nhất 6 ký tự</small>
                        </div>
                        <div class="form-group">
                            <label>Xác nhận mật khẩu mới</label>
                            <input type="password" name="confirm_password" required>
                        </div>
                        <button type="submit" name="change_password" class="btn-primary">Đổi mật khẩu</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>