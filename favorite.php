<?php
// File: favorite.php - Thêm/xóa bài viết yêu thích
require_once 'includes/config.php';

if(!isset($_SESSION['user_id']) || !isset($_GET['post_id'])) {
    header("Location: blog.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = intval($_GET['post_id']);

// Tạo bảng favorites nếu chưa có
$conn->query("CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    UNIQUE KEY unique_favorite (user_id, post_id)
)");

// Kiểm tra đã lưu chưa
$check = $conn->query("SELECT id FROM favorites WHERE user_id = $user_id AND post_id = $post_id");

if($check->num_rows > 0) {
    // Đã lưu thì xóa
    $conn->query("DELETE FROM favorites WHERE user_id = $user_id AND post_id = $post_id");
    setMessage('Đã xóa khỏi danh sách yêu thích');
} else {
    // Chưa lưu thì thêm
    $conn->query("INSERT INTO favorites (user_id, post_id) VALUES ($user_id, $post_id)");
    setMessage('Đã thêm vào danh sách yêu thích');
}

// Quay lại trang trước đó
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'blog.php'));
exit();
?>