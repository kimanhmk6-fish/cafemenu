<?php
session_start();
include 'includes/config.php';

$error = '';
$success = '';

// Xử lý gửi email reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $token = createResetToken($email);
        // Trong thực tế, gửi email chứa link reset
        // Ở đây tạm thời hiển thị link
        $reset_link = "http://localhost/cafemenu/reset_password.php?token=" . $token;
        $success = "Link đặt lại mật khẩu: <a href='$reset_link'>$reset_link</a>";
    } else {
        $error = "Email không tồn tại trong hệ thống";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <style>
        body { background: #cfc3b2; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: Arial; }
        .container { background: #e9e3d8; padding: 40px; border-radius: 20px; width: 400px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 8px; border: 1px solid #ccc; }
        button { width: 100%; padding: 12px; background: #2b1f18; color: white; border: none; border-radius: 25px; cursor: pointer; }
        .error { color: red; background: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
        .success { color: green; background: #d4edda; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
        a { color: #2b1f18; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Quên mật khẩu</h2>
        <p style="text-align: center; color: #666;">Nhập email để nhận link đặt lại mật khẩu</p>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Email của bạn" required>
            <button type="submit">Gửi yêu cầu</button>
        </form>
        
        <div style="text-align: center; margin-top: 15px;">
            <a href="login.php">Quay lại đăng nhập</a>
        </div>
    </div>
</body>
</html>