<?php 
session_start();
require_once 'includes/config.php';
include 'includes/header.php'; 
?>

<style>
    /* Reset cơ bản */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* --- TIÊU ĐỀ TRANG --- */
    .page-header {
        text-align: center;
        padding: 120px 20px 40px;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('img/banner-contact.jpg');
        background-size: cover;
        background-position: center;
        color: white;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 52px;
        margin-bottom: 15px;
        letter-spacing: 2px;
    }

    .page-subtitle {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-style: italic;
        opacity: 0.9;
    }

    /* --- BỐ CỤC LIÊN HỆ --- */
    .contact-section {
        background-color: #f4f1ea;
        padding: 80px 0;
    }

    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        gap: 40px;
    }

    .contact-box {
        background-color: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* Cột bên trái: Thông tin */
    .contact-info {
        flex: 1;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        color: #2b1f18;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: #c49a6c;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 28px;
    }

    .icon-circle {
        width: 48px;
        height: 48px;
        background-color: #2b1f18;
        color: #fff2cf;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        flex-shrink: 0;
        transition: 0.3s;
    }

    .info-item:hover .icon-circle {
        background-color: #c49a6c;
        transform: scale(1.05);
    }

    .info-content h4 {
        font-size: 18px;
        color: #2b1f18;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .info-content p {
        font-size: 15px;
        color: #555;
        margin-bottom: 4px;
        line-height: 1.5;
    }

    .info-content a {
        color: #c49a6c;
        text-decoration: none;
        transition: 0.3s;
    }

    .info-content a:hover {
        color: #2b1f18;
        text-decoration: underline;
    }

    /* Cột bên phải: Form */
    .contact-form {
        flex: 1.3;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-row .form-group {
        flex: 1;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #2b1f18;
    }

    label .required {
        color: #c49a6c;
    }

    input, textarea, select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e0d3c2;
        border-radius: 10px;
        font-family: inherit;
        font-size: 15px;
        background-color: #fff;
        outline: none;
        transition: all 0.3s;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #c49a6c;
        box-shadow: 0 0 0 3px rgba(196, 154, 108, 0.1);
    }

    textarea {
        resize: vertical;
        min-height: 130px;
    }

    .submit-btn {
        background-color: #2b1f18;
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 40px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
        width: auto;
        display: inline-block;
    }

    .submit-btn:hover {
        background-color: #c49a6c;
        transform: translateY(-2px);
    }

    /* Map section */
    .map-section {
        padding: 0 0 80px;
        background-color: #f4f1ea;
    }

    .map-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .map-container iframe {
        width: 100%;
        height: 400px;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .contact-container {
            flex-direction: column;
        }
        .page-header {
            padding: 100px 20px 40px;
        }
        .page-title {
            font-size: 42px;
        }
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        .contact-box {
            padding: 30px 20px;
        }
        .page-title {
            font-size: 32px;
        }
        .page-subtitle {
            font-size: 16px;
        }
    }

    /* Alert messages */
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-left: 4px solid #28a745;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-left: 4px solid #dc3545;
    }
</style>

<?php
// Xử lý form gửi tin nhắn
$msg_success = '';
$msg_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Kiểm tra dữ liệu
    if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
        $msg_error = "Vui lòng điền đầy đủ thông tin có dấu *";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg_error = "Email không hợp lệ";
    } else {
        // Lưu vào database (tạo bảng contacts nếu chưa có)
        $msg_success = "Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.";
        // Lưu vào database
        $sql = "INSERT INTO contacts (fullname, email, phone, subject, message, status, created_at) 
                VALUES (?, ?, ?, ?, ?, 'pending', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fullname, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            $msg_success = "Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.";
        } else {
            $msg_error = "Có lỗi xảy ra, vui lòng thử lại sau.";
        }
        $stmt->close();
        // Nếu muốn lưu vào database, thêm code ở đây
        // $sql = "INSERT INTO contacts (fullname, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        // $stmt = $conn->prepare($sql);
        // $stmt->bind_param("sssss", $fullname, $email, $phone, $subject, $message);
        // $stmt->execute();
    }
}
?>

<section class="page-header">
    <h1 class="page-title">Liên Hệ</h1>
    <p class="page-subtitle">Chúng tôi luôn sẵn sàng lắng nghe bạn</p>
</section>

<section class="contact-section">
    <div class="contact-container">
        
        <!-- Cột bên trái: Thông tin -->
<!-- Cột bên trái: Thông tin -->
<div class="contact-box contact-info">
    <h2 class="section-title">Thông Tin Liên Hệ</h2>
    
    <!-- Địa chỉ -->
    <div class="info-item">
        <div class="icon-circle">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="info-content">
            <h4>Địa chỉ</h4>
            <p>79 Hồ Tùng Mậu, Mai Dịch, Cầu Giấy, Hà Nội</p>
        </div>
    </div>

    <!-- Điện thoại -->
    <div class="info-item">
        <div class="icon-circle">
            <i class="fas fa-phone-alt"></i>
        </div>
        <div class="info-content">
            <h4>Điện thoại</h4>
            <p>0123 456 789 (Hotline)</p>
            <p>0976 543 210 (Đặt bàn)</p>
        </div>
    </div>

    <!-- Email -->
    <div class="info-item">
        <div class="icon-circle">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="info-content">
            <h4>Email</h4>
            <p>info@cafe90s.com</p>
        </div>
    </div>

    <!-- Giờ mở cửa -->
    <div class="info-item">
        <div class="icon-circle">
            <i class="far fa-clock"></i>
        </div>
        <div class="info-content">
            <h4>Giờ mở cửa</h4>
            <p>Thứ 2 - Thứ 6: 6:00 - 22:00</p>
            <p>Thứ 7 - CN: 7:00 - 23:00</p>
        </div>
    </div>

    <!-- Facebook -->
    <div class="info-item">
        <div class="icon-circle">
            <i class="fab fa-facebook-f"></i>
        </div>
        <div class="info-content">
            <h4>Facebook</h4>
            <p>
                <a href="https://www.facebook.com/profile.php?id=61583012016197" target="_blank" style="color: #c49a6c; text-decoration: none;">
                    Góc Cà Phê 90s
                </a>
            </p>
            <p style="font-size: 13px; color: #888; margin-top: 5px;">Organic Garden</p>
        </div>
    </div>
</div>  <!-- Đóng contact-info -->

        <!-- Cột bên phải: Form -->
        <div class="contact-box contact-form">
            <h2 class="section-title">Gửi Tin Nhắn</h2>
            
            <?php if ($msg_success): ?>
                <div class="alert-success"><?php echo $msg_success; ?></div>
            <?php endif; ?>
            <?php if ($msg_error): ?>
                <div class="alert-error"><?php echo $msg_error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Họ tên <span class="required">*</span></label>
                    <input type="text" name="fullname" required placeholder="Nhập họ và tên của bạn">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" required placeholder="example@gmail.com">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" name="phone" placeholder="Ví dụ: 0912345678">
                    </div>
                </div>

                <div class="form-group">
                    <label>Tiêu đề <span class="required">*</span></label>
                    <input type="text" name="subject" required placeholder="Vấn đề bạn cần hỗ trợ là gì?">
                </div>

                <div class="form-group">
                    <label>Nội dung <span class="required">*</span></label>
                    <textarea name="message" required placeholder="Hãy viết tin nhắn của bạn ở đây..."></textarea>
                </div>

                <button type="submit" class="submit-btn">Gửi tin nhắn</button>
            </form>
        </div>

    </div>
</section>

<!-- Bản đồ Google Maps -->
<section class="map-section">
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.123456789012!2d105.80123456789012!3d21.03456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab123456789%3A0x1234567890abcdef!2zNzkgSOG7kyBUw7luZyBN4bqtdSwgTWFpIELhuqFjLCBD4bqndSBHaeG6pXksIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

<?php include 'includes/footer.php'; ?>