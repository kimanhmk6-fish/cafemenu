<?php
session_start();
include 'includes/config.php';

$error = '';
$success = '';
$token = $_GET['token'] ?? '';

// Kiểm tra token hợp lệ
$email = verifyResetToken($token);
if (!$email && $_SERVER["REQUEST_METHOD"] != "POST") {
    $error = "Link không hợp lệ hoặc đã hết hạn!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];
    
    if (strlen($new_password) < 6) {
        $error = "Mật khẩu phải có ít nhất 6 ký tự";
    } elseif ($new_password != $confirm_password) {
        $error = "Mật khẩu nhập lại không khớp";
    } else {
        if (updatePasswordByToken($token, $new_password)) {
            $success = "Đổi mật khẩu thành công! <a href='login.php'>Đăng nhập ngay</a>";
        } else {
            $error = "Link không hợp lệ hoặc đã hết hạn!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <style>
        body { background: #cfc3b2; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: Arial; }
        .container { background: #e9e3d8; padding: 40px; border-radius: 20px; width: 400px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 8px; border: 1px solid #ccc; }
        button { width: 100%; padding: 12px; background: #2b1f18; color: white; border: none; border-radius: 25px; cursor: pointer; }
        .error { color: red; background: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
        .success { color: green; background: #d4edda; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Đặt lại mật khẩu</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="new_password" placeholder="Mật khẩu mới" required>
                <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
                <button type="submit">Đặt lại mật khẩu</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>