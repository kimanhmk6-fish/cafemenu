<?php
// File: checkout.php - Thanh toán đơn hàng
require_once 'includes/config.php';
$page_title = 'Thanh toán';
require_once 'includes/header.php';

if(!isset($_SESSION['user_id'])) {
    setMessage('Vui lòng đăng nhập để thanh toán', 'error');
    redirect('login.php?redirect=checkout.php');
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

// Lấy giỏ hàng
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
if($cart_items->num_rows == 0) {
    redirect('cart.php');
}

$total = 0;
$items_list = [];
$items_json = [];
while($item = $cart_items->fetch_assoc()) {
    $subtotal = $item['item_price'] * $item['quantity'];
    $total += $subtotal;
    $items_list[] = $item['item_name'] . " x" . $item['quantity'];
    $items_json[] = [
        'id' => $item['item_id'],
        'name' => $item['item_name'],
        'price' => $item['item_price'],
        'quantity' => $item['quantity']
    ];
}
$items_str = implode(", ", $items_list);
$items_json_str = json_encode($items_json, JSON_UNESCAPED_UNICODE);

// Xử lý đặt hàng
if(isset($_POST['checkout'])) {
    $customer_name = escape($_POST['customer_name']);
    $phone = escape($_POST['phone']);
    $email = escape($_POST['email'] ?? '');
    $pickup_time = $_POST['pickup_date'] . ' ' . $_POST['pickup_hour'] . ':' . $_POST['pickup_minute'];
    $payment_method = escape($_POST['payment_method']);
    $note = escape($_POST['note'] ?? '');
    
    // Thêm đơn hàng
    $stmt = $conn->prepare("INSERT INTO takeaway_orders (user_id, customer_name, phone, email, items, total_price, pickup_time, payment_method, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issssdsss", $user_id, $customer_name, $phone, $email, $items_str, $total, $pickup_time, $payment_method, $note);
    
    if($stmt->execute()) {
        $order_id = $conn->insert_id;
        
        // Xóa giỏ hàng
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");
        
        setMessage('Đặt hàng thành công! Mã đơn hàng: #' . $order_id);
        
        // Gửi email xác nhận
        if(!empty($email)) {
            $subject = "Xác nhận đơn hàng #$order_id - Góc Cà Phê 90s";
            $content = "Cảm ơn bạn đã đặt hàng tại Góc Cà Phê 90s.\n\n";
            $content .= "Mã đơn hàng: #$order_id\n";
            $content .= "Thông tin đơn hàng:\n";
            foreach($items_json as $item) {
                $content .= "- {$item['name']} x{$item['quantity']}: " . formatPrice($item['price'] * $item['quantity']) . "\n";
            }
            $content .= "Tổng cộng: " . formatPrice($total) . "\n\n";
            $content .= "Thời gian nhận hàng: $pickup_time\n";
            $content .= "Phương thức thanh toán: " . ($payment_method == 'cash' ? 'Tiền mặt' : ($payment_method == 'bank' ? 'Chuyển khoản' : 'Momo')) . "\n\n";
            $content .= "Vui lòng đến đúng giờ để nhận hàng.";
            // sendMail($email, $subject, $content);
        }
        
        redirect('profile.php?tab=orders');
    } else {
        setMessage('Có lỗi xảy ra: ' . $conn->error, 'error');
    }
}
?>

<section class="py-3">
    <div class="section-title">
        <h2>Thanh Toán</h2>
        <p>Xác nhận thông tin đơn hàng</p>
    </div>
    
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
            <!-- Order Summary -->
            <div style="background: var(--card-bg); padding: 30px; border-radius: 20px;">
                <h3 style="margin-bottom: 20px;">🛒 Đơn hàng của bạn</h3>
                
                <table style="width: 100%; margin-bottom: 20px;">
                    <?php 
                    $cart_items->data_seek(0);
                    while($item = $cart_items->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?php echo $item['item_name']; ?></td>
                        <td>x<?php echo $item['quantity']; ?></td>
                        <td style="text-align: right;"><?php echo formatPrice($item['item_price'] * $item['quantity']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    <tr style="border-top: 2px solid var(--accent-brown);">
                        <td colspan="2" style="text-align: right; font-weight: 700;">Tổng cộng:</td>
                        <td style="font-weight: 700; color: var(--accent-brown);"><?php echo formatPrice($total); ?></td>
                    </tr>
                </table>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                    <p><strong>Hình thức nhận hàng:</strong> 🛵 Nhận tại quán</p>
                    <p><strong>Địa chỉ quán:</strong> 123 Đường Hoài Niệm, Quận 3, TP.HCM</p>
                </div>
            </div>
            
            <!-- Checkout Form -->
            <div style="background: var(--card-bg); padding: 30px; border-radius: 20px;">
                <h3 style="margin-bottom: 20px;">📝 Thông tin nhận hàng</h3>
                
                <form method="post" data-validate="true">
                    <div class="form-group">
                        <label>Họ tên người nhận *</label>
                        <input type="text" name="customer_name" value="<?php echo $user['fullname']; ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Số điện thoại *</label>
                            <input type="tel" name="phone" value="<?php echo $user['phone']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $user['email']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Ngày nhận *</label>
                            <input type="date" name="pickup_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Giờ nhận *</label>
                            <div style="display: flex; gap: 5px;">
                                <select name="pickup_hour" style="flex: 1;" required>
                                    <?php for($h = 7; $h <= 22; $h++): ?>
                                    <option value="<?php echo sprintf("%02d", $h); ?>"><?php echo $h; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span style="align-self: center;">:</span>
                                <select name="pickup_minute" style="flex: 1;" required>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Methods -->
                    <div class="form-group">
                        <label>Phương thức thanh toán *</label>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 10px;">
                            <label style="display: flex; align-items: center; gap: 5px; padding: 10px; background: #f8f9fa; border-radius: 8px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="cash" checked> 💵 Tiền mặt
                            </label>
                            <label style="display: flex; align-items: center; gap: 5px; padding: 10px; background: #f8f9fa; border-radius: 8px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="bank"> 🏦 Chuyển khoản
                            </label>
                            <label style="display: flex; align-items: center; gap: 5px; padding: 10px; background: #f8f9fa; border-radius: 8px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="momo"> 📱 Momo
                            </label>
                        </div>
                    </div>
                    
                    <!-- Bank Info (hidden by default) -->
                    <div id="bank-info" style="display: none; background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <p><strong>Ngân hàng:</strong> Vietcombank</p>
                        <p><strong>Số tài khoản:</strong> 1234 5678 9012</p>
                        <p><strong>Chủ tài khoản:</strong> GÓC CÀ PHÊ 90s</p>
                        <p><strong>Nội dung:</strong> DH<?php echo time(); ?> + SĐT</p>
                    </div>
                    
                    <!-- Momo Info -->
                    <div id="momo-info" style="display: none; background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <p><strong>Số Momo:</strong> 0123 456 789</p>
                        <p><strong>Tên:</strong> GÓC CÀ PHÊ 90s</p>
                    </div>
                    
                    <div class="form-group">
                        <label>Ghi chú (không đường, ít đá...)</label>
                        <textarea name="note" rows="3" placeholder="Ghi chú cho quán..."></textarea>
                    </div>
                    
                    <button type="submit" name="checkout" class="btn btn-primary" style="width: 100%;">✅ Xác nhận đặt hàng</button>
                    <a href="cart.php" style="display: block; text-align: center; margin-top: 15px;">← Quay lại giỏ hàng</a>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Hiển thị thông tin thanh toán tương ứng
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('bank-info').style.display = this.value === 'bank' ? 'block' : 'none';
        document.getElementById('momo-info').style.display = this.value === 'momo' ? 'block' : 'none';
    });
});

// Mặc định chọn ngày mai
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[name="pickup_date"]');
    if(dateInput) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const yyyy = tomorrow.getFullYear();
        const mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
        const dd = String(tomorrow.getDate()).padStart(2, '0');
        dateInput.value = `${yyyy}-${mm}-${dd}`;
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>