<?php
session_start();
include 'includes/config.php';

// Chuyển hướng nếu đã đăng nhập
if (isLoggedIn()) { // Dùng hàm isLoggedIn bạn đã viết trong config
    redirect('index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = escape($_POST["fullname"]);
    $email = escape($_POST["email"]);
    $phone = escape($_POST["phone"]);
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    // 1. Kiểm tra dữ liệu rỗng
    if (empty($fullname) || empty($email) || empty($password)) {
        setMessage("Vui lòng điền các trường có dấu * nhé!", "error");
    } 
    // 2. Kiểm tra khớp mật khẩu
    elseif ($password !== $repassword) {
        setMessage("Mật khẩu nhập lại không khớp, kiểm tra lại giúp mình!", "error");
    } 
    // 3. Kiểm tra độ dài mật khẩu
    elseif (strlen($password) < 6) {
        setMessage("Mật khẩu phải từ 6 ký tự trở lên để bảo mật hơn nè.", "error");
    } 
    else {
        // 4. Kiểm tra email đã tồn tại
        $sql_check = "SELECT id FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            setMessage("Email này đã có người sử dụng rồi!", "error");
        } else {
            // ĐOẠN CODE MỚI (đã thêm address)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users(fullname, email, phone, address, password, role) VALUES (?, ?, ?, ?, ?, 'user')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $fullname, $email, $phone, $address, $hashedPassword);

            if ($stmt->execute()) {
                setMessage("Đăng ký thành công! Chào mừng bạn đến với Góc 90s.", "success");
                // Đợi 2 giây rồi mới chuyển trang để khách kịp đọc tin vui
                header("refresh:2; url=login.php");
            } else {
                setMessage("Lỗi hệ thống: " . $stmt->error, "error");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng ký - Góc Cà Phê 90s</title>
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
    width: 500px;
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
.row { display: flex; gap: 15px; }
.row div { flex: 1; }
.checkbox {
    display: flex;
    align-items: center;
    margin-top: 15px;
    font-size: 13px;
}
.checkbox input { width: auto; margin-right: 10px; }
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
.footer a:hover { text-decoration: underline; }
.error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}
.success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}
</style>
</head>
<body>
<div class="container">
    <h2>Đăng Ký Thành Viên</h2>
    <div class="sub">Trở thành thành viên để đặt đồ</div>
    
    <?php displayMessage(); ?>
    
    <form method="POST" action="">
        <label>Họ và tên *</label>
        <input type="text" name="fullname" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
        
        <div class="row">
            <div>
                <label>Email *</label>
                <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div>
                <label>Số điện thoại *</label>
                <input type="tel" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
            </div>
            <!-- Thêm dòng này sau phần số điện thoại -->
            <div>
                <label>Địa chỉ</label>
                <input type="text" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
            </div>
        </div>
        
        <div class="row">
            <div>
                <label>Mật khẩu *</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label>Nhập lại mật khẩu *</label>
                <input type="password" name="repassword" required>
            </div>
        </div>
        
        <div class="checkbox">
            <input type="checkbox" required>
            <span style="margin-left: 10px;">Tôi đồng ý với điều khoản sử dụng</span>
        </div>
        
        <button type="submit">Đăng ký</button>
    </form>
    
    <div class="footer">
        Đã có tài khoản? <a href="login.php">Đăng nhập</a>
    </div>
</div>
</body>
</html>