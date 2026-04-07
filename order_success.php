<?php
session_start();
include 'includes/config.php';
include 'includes/header.php';

$order_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? 0;

// Lấy thông tin đơn hàng
$sql = "SELECT o.*, u.fullname, u.email, u.phone, u.address 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        WHERE o.id = ? AND o.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header('Location: index.php');
    exit();
}
?>

<section style="padding: 120px 0; background: #f4f1ea; text-align: center;">
    <div class="container">
        <div style="background: white; border-radius: 20px; padding: 50px; max-width: 600px; margin: 0 auto;">
            <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745; margin-bottom: 20px;"></i>
            <h2 style="font-family: 'Playfair Display', serif;">Đặt hàng thành công!</h2>
            <p>Mã đơn hàng: <strong>#<?php echo $order_id; ?></strong></p>
            <p>Tổng tiền: <strong style="color: #a67c52; font-size: 24px;"><?php echo number_format($order['total_price']); ?>đ</strong></p>
            <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
            <a href="menu.php" class="btn-checkout" style="display: inline-block; margin-top: 20px;">Tiếp tục mua sắm</a>
            <a href="orders.php" class="btn-checkout" style="display: inline-block; margin-top: 20px; background: #6c757d;">Xem lịch sử đơn hàng</a>
        </div>
    </div>
</section>

<style>
.btn-checkout { background: #2b1f18; color: white; border: none; padding: 12px 30px; border-radius: 30px; text-decoration: none; margin: 0 10px; }
</style>

<?php include 'includes/footer.php'; ?>