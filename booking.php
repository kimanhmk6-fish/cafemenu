<?php
// File: booking.php - Đặt bàn trực tuyến
require_once 'includes/config.php';
$page_title = 'Đặt bàn';
require_once 'includes/header.php';

// Xử lý đặt bàn
if(isset($_POST['booking'])) {
    $customer_name = escape($_POST['customer_name']);
    $phone = escape($_POST['phone']);
    $email = escape($_POST['email']);
    $date = escape($_POST['date']);
    $time = escape($_POST['time']);
    $guests = intval($_POST['guests']);
    $note = escape($_POST['note'] ?? '');
    $user_id = $_SESSION['user_id'] ?? null;
    
    // Kiểm tra ngày giờ hợp lệ
    $booking_datetime = $date . ' ' . $time;
    if(strtotime($booking_datetime) < time()) {
        setMessage('Không thể đặt bàn trong quá khứ', 'error');
        redirect('booking.php');
    }
    
    // Kiểm tra số lượng bàn (giả sử quán có 20 bàn)
    $check_sql = "SELECT COUNT(*) as total FROM bookings WHERE booking_date = ? AND booking_time = ? AND status != 'cancelled'";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $date, $time);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $booked_tables = $check_result->fetch_assoc()['total'];
    
    if($booked_tables >= 20) {
        setMessage('Xin lỗi, khung giờ này đã hết bàn. Vui lòng chọn giờ khác.', 'error');
        redirect('booking.php');
    }
    
    // Thêm đặt bàn
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, customer_name, phone, email, booking_date, booking_time, guests, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isssssis", $user_id, $customer_name, $phone, $email, $date, $time, $guests, $note);
    
    if($stmt->execute()) {
        setMessage('Đặt bàn thành công! Chúng tôi sẽ liên hệ xác nhận qua điện thoại.');
        
        // Gửi email xác nhận (nếu có)
        if(!empty($email)) {
            $subject = "Xác nhận đặt bàn tại Góc Cà Phê 90s";
            $content = "Cảm ơn bạn đã đặt bàn tại Góc Cà Phê 90s.\n\n";
            $content .= "Thông tin đặt bàn:\n";
            $content .= "- Họ tên: $customer_name\n";
            $content .= "- SĐT: $phone\n";
            $content .= "- Ngày: $date\n";
            $content .= "- Giờ: $time\n";
            $content .= "- Số người: $guests\n";
            $content .= "- Ghi chú: $note\n\n";
            $content .= "Vui lòng đến đúng giờ, bàn sẽ được giữ tối đa 15 phút.";
            // sendMail($email, $subject, $content);
        }
    } else {
        setMessage('Có lỗi xảy ra: ' . $conn->error, 'error');
    }
    
    redirect('booking.php');
}
?>

<section class="py-3">
    <div class="section-title">
        <h2>Đặt Bàn</h2>
        <p>Để lại thông tin, chúng tôi sẽ liên hệ xác nhận</p>
    </div>
    
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
            <!-- Booking Form -->
            <div style="background: var(--card-bg); padding: 40px; border-radius: 20px;">
                <form method="post" data-validate="true">
                    <div class="form-group">
                        <label>Họ tên *</label>
                        <input type="text" name="customer_name" required value="<?php echo $_SESSION['fullname'] ?? ''; ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Số điện thoại *</label>
                            <input type="tel" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Ngày *</label>
                            <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+30 days')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Giờ *</label>
                            <select name="time" required>
                                <option value="">-- Chọn giờ --</option>
                                <?php for($h = 7; $h <= 22; $h++): 
                                    $time = sprintf("%02d:00", $h);
                                ?>
                                <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Số người *</label>
                            <input type="number" name="guests" min="1" max="20" value="2" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Ghi chú (dị ứng, yêu cầu đặc biệt...)</label>
                        <textarea name="note" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" name="booking" class="btn btn-primary">Xác nhận đặt bàn</button>
                </form>
            </div>
            
            <!-- Information -->
            <div>
                <div style="background: var(--accent-brown); color: white; padding: 30px; border-radius: 20px; margin-bottom: 30px;">
                    <h3 style="color: white; margin-bottom: 20px;">📌 Lưu ý</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 15px; display: flex; gap: 10px;">
                            <span>✓</span>
                            Bàn được giữ tối đa 15 phút sau giờ đặt
                        </li>
                        <li style="margin-bottom: 15px; display: flex; gap: 10px;">
                            <span>✓</span>
                            Quán nhận đặt bàn trước 30 ngày
                        </li>
                        <li style="margin-bottom: 15px; display: flex; gap: 10px;">
                            <span>✓</span>
                            Vui lòng liên hệ hotline nếu có thay đổi
                        </li>
                    </ul>
                </div>
                
                <div style="background: var(--card-bg); padding: 30px; border-radius: 20px;">
                    <h3 style="margin-bottom: 20px;">☎️ Hotline hỗ trợ</h3>
                    <p style="font-size: 2rem; color: var(--accent-brown); font-weight: 700; margin-bottom: 10px;">0123 456 789</p>
                    <p style="color: #666;">(8:00 - 22:00 hàng ngày)</p>
                    
                    <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
                    
                    <h4 style="margin-bottom: 10px;">🕒 Giờ mở cửa</h4>
                    <p>Thứ 2 - Thứ 6: 6:00 - 22:00</p>
                    <p>Thứ 7 - CN: 7:00 - 23:00</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Tự động chọn ngày mai
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[name="date"]');
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