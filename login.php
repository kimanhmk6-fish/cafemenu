<?php
session_start();
include 'includes/config.php';

// Chuyển hướng nếu đã đăng nhập
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        redirect('admin/dashboard.php');
    } else {
        redirect('index.php');
    }
}

// 🔥 THÊM: Xử lý remember me cookie (tự động đăng nhập) - SỬA LẠI
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token']) && !isset($_GET['switch_account'])) {
    $token = $_COOKIE['remember_token'];
    $sql = "SELECT * FROM users WHERE remember_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
// Thành:
if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Thiết lập Session
        $_SESSION["user_id"]   = $user["id"];
        $_SESSION["user_name"] = $user["fullname"];
        $_SESSION["fullname"]  = $user["fullname"]; 
        $_SESSION["email"]     = $user["email"];
        $_SESSION["role"]      = $user["role"];
        
        // ĐIỀU HƯỚNG DỰA TRÊN ROLE
        if ($_SESSION["role"] == 'admin') {
            redirect('admin/dashboard.php');
        } else {
            redirect('index.php');
        }
        
        // XÓA DÒNG NÀY: redirect('index.php'); -> Vì nó nằm ngoài if/else và gây dư thừa.
        exit(); // Nên thêm exit() sau redirect để dừng script ngay lập tức
    }
}
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $remember = isset($_POST['remember']); // 🔥 THÊM DÒNG NÀY

    if (empty($email) || empty($password)) {
        setMessage("Vui lòng nhập đầy đủ thông tin", "error");
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["fullname"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"] ?? 'user';
                
                // 🔥 THÊM: Xử lý remember me (30 ngày)
                if ($remember) {
                    // Xóa token cũ nếu có (tránh trùng lặp)
                    $sql = "UPDATE users SET remember_token = NULL WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user['id']);
                    $stmt->execute();
                    
                    // Tạo token mới
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (86400 * 30), '/');
                    $sql = "UPDATE users SET remember_token = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $token, $user['id']);
                    $stmt->execute();
                }
                if ($user["role"] == 'admin') {
    redirect('admin/dashboard.php');
} else {
    redirect('index.php');
}
            } else {
                setMessage("Mật khẩu không đúng", "error");
            }
        } else {
            setMessage("Email này chưa đăng ký nha!", "error");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng nhập - Góc Cà Phê 90s</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: Arial, sans-serif;
    background: #cfc3b2;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.container {
    background: #e9e3d8;
    padding: 40px;
    border-radius: 20px;
    width: 450px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
h2 { text-align: center; margin-bottom: 10px; color: #2b1f18; }
.sub { text-align: center; font-size: 14px; color: #666; margin-bottom: 25px; }
label { display: block; margin-top: 15px; font-weight: bold; color: #2b1f18; }
input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-top: 5px;
    font-size: 14px;
}
.checkbox {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 15px;
}
.checkbox label { margin: 0; display: inline; font-weight: normal; }
.checkbox input { width: auto; margin-right: 8px; }
.forgot-link { color: #a67c52; text-decoration: none; font-size: 14px; }
button {
    width: 100%;
    margin-top: 25px;
    padding: 12px;
    border: none;
    border-radius: 25px;
    background: linear-gradient(to right, #3b2413, #2b1a0d);
    color: white;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
}
button:hover { opacity: 0.9; }
.footer { text-align: center; margin-top: 20px; font-size: 14px; }
.footer a { color: #2b1f18; font-weight: bold; text-decoration: none; }
.error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}
</style>
</head>
<body>
<div class="container">
    <h2>Đăng Nhập</h2>
    <div class="sub">Đăng nhập để sử dụng các chức năng của hệ thống</div>
    
    <?php displayMessage(); ?>
    <!-- Thêm dòng này bên trong container, sau form hoặc trước form -->
<?php if (isset($_COOKIE['remember_token'])): ?>
<div style="background: #fff3cd; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
    <p style="margin: 0; font-size: 14px;">🔐 Bạn đang có phiên đăng nhập tự động.
    <a href="?switch_account=1" style="color: #856404; font-weight: bold;">Đăng nhập tài khoản khác?</a></p>
</div>
<?php endif; ?>
    <form method="POST" action="">
        <label>Email *</label>
        <input type="email" name="email" required>
        
        <label>Mật khẩu *</label>
        <input type="password" name="password" required>
        
        <div class="checkbox">
            <label><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label>
            <a href="forgot_password.php" class="forgot-link">Quên mật khẩu?</a>
        </div>
        
        <button type="submit">Đăng nhập</button>
    </form>
    
    <div class="footer">
        Chưa có tài khoản? <a href="register.php">Đăng ký</a>
    </div>
</div>
</body>
</html>