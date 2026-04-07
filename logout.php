<?php
session_start();
include 'includes/config.php';

// 🔥 XÓA COOKIE REMEMBER ME KHI ĐĂNG XUẤT
if (isset($_COOKIE['remember_token'])) {
    // Xóa cookie trên trình duyệt
    setcookie('remember_token', '', time() - 3600, '/');
    
    // Xóa token trong database (nếu có)
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE users SET remember_token = NULL WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
}

// Xóa sạch session
$_SESSION = array();
session_destroy();

// Quay về trang chủ
header('Location: index.php');
exit();
?>