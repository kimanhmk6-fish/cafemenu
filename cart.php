<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// ========== XỬ LÝ CẬP NHẬT GIỎ HÀNG ==========
if (isset($_POST['update_cart']) && isset($_POST['quantity']) && is_array($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $cart_id => $qty) {
        $cart_id = intval($cart_id);
        $qty = intval($qty);
        if ($qty <= 0) {
            $conn->query("DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id");
        } else {
            $qty = min($qty, 99);
            $conn->query("UPDATE cart SET quantity = $qty WHERE id = $cart_id AND user_id = $user_id");
        }
    }
    header('Location: cart.php');
    exit();
}

// ========== XỬ LÝ XÓA MÓN ==========
if (isset($_POST['remove_item'])) {
    $cart_id = intval($_POST['cart_id']);
    $conn->query("DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id");
    header('Location: cart.php');
    exit();
}

// ========== XỬ LÝ THÊM TỪ GỢI Ý ==========
if (isset($_POST['add_from_suggest'])) {
    $p_id = intval($_POST['product_id']);
    $check = $conn->query("SELECT id FROM cart WHERE user_id = $user_id AND product_id = $p_id AND size = 'M'");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $p_id AND size = 'M'");
    } else {
        $conn->query("INSERT INTO cart (user_id, product_id, quantity, size) VALUES ($user_id, $p_id, 1, 'M')");
    }
    header('Location: cart.php');
    exit();
}

// ========== LẤY DỮ LIỆU GIỎ HÀNG ==========
$cart_result = $conn->query("
    SELECT c.*, p.name, p.price, p.image 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = $user_id
");

// ========== TÍNH TỔNG TIỀN ==========
$total_res = $conn->query("
    SELECT SUM((p.price + IFNULL(c.price_extra, 0)) * c.quantity) as total 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = $user_id
")->fetch_assoc();
$total = $total_res['total'] ?? 0;

// ========== LẤY ĐỊA CHỈ USER ==========
$user_addr = $conn->query("SELECT address FROM users WHERE id = $user_id")->fetch_assoc();
$user_address = $user_addr['address'] ?? '';

include 'includes/header.php';
?>

<style>
:root {
    --cafe-dark: #3e2723;
    --cafe-accent: #d35400;
    --cafe-bg: #fcf9f2;
    --card-bg: #fdf8f2;
}
body { background: var(--cafe-bg); font-family: 'Segoe UI', sans-serif; }

/* Layout chính */
.cart-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 380px; gap: 30px; }
@media (max-width: 992px) { .cart-container { grid-template-columns: 1fr; } }

/* Giỏ hàng */
.cart-box { background: white; border-radius: 25px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
.cart-table { width: 100%; border-collapse: collapse; }
.cart-table th { text-align: left; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0; color: #888; font-size: 14px; text-transform: uppercase; }
.cart-table td { padding: 20px 0; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
.prod-info { display: flex; align-items: center; gap: 15px; }
.prod-info img { width: 80px; height: 80px; object-fit: cover; border-radius: 15px; background: #634832; }
.qty-input { width: 70px; padding: 8px; border: 2px solid #eee; border-radius: 10px; text-align: center; font-weight: bold; }
.btn-remove-link { background: none; border: none; color: #dc3545; cursor: pointer; font-size: 12px; margin-top: 5px; padding: 0; }

/* Gợi ý sản phẩm */
.suggest-section { margin-top: 50px; }
.suggest-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; margin-top: 20px; }
.suggest-card { background: white; padding: 15px; border-radius: 20px; text-align: center; transition: 0.3s; cursor: pointer; border: 1px solid transparent; }
.suggest-card:hover { transform: translateY(-5px); border-color: var(--cafe-accent); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
.suggest-card img { width: 100%; height: 140px; object-fit: cover; border-radius: 15px; margin-bottom: 10px; }
.btn-add-small { background: var(--cafe-dark); color: white; border: none; padding: 8px 15px; border-radius: 20px; cursor: pointer; font-size: 13px; width: 100%; margin-top: 10px; }
.btn-add-small:hover { background: var(--cafe-accent); }

/* Thanh toán */
.checkout-side { background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); position: sticky; top: 20px; }
.address-box { margin: 20px 0; }
.address-box label { display: block; margin-bottom: 10px; font-weight: bold; }
.address-box textarea { width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 15px; resize: none; font-family: inherit; }
.address-box textarea:focus { border-color: var(--cafe-accent); outline: none; }
.note-box { margin: 15px 0; }
.note-box textarea { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 15px; resize: none; font-family: inherit; font-size: 14px; }
.btn-main { width: 100%; padding: 18px; border-radius: 35px; border: none; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-update { background: white; border: 2px solid var(--cafe-dark); color: var(--cafe-dark); margin-bottom: 15px; }
.btn-pay { background: var(--cafe-accent); color: white; box-shadow: 0 5px 15px rgba(211,84,0,0.3); }

/* Modal QR */
#qrModal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
.qr-content { background: white; padding: 40px; border-radius: 30px; text-align: center; max-width: 400px; width: 90%; animation: pop 0.3s ease; }
@keyframes pop { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }

.empty-cart { text-align: center; padding: 60px; background: white; border-radius: 20px; }
</style>

<div class="cart-container">
    <div class="main-content">
        <!-- GIỎ HÀNG -->
        <div class="cart-box">
            <h2 style="margin-top: 0;">Giỏ hàng của bạn</h2>
            
            <?php if ($cart_result->num_rows == 0): ?>
                <div class="empty-cart">
                    <p>Giỏ hàng đang trống</p>
                    <a href="menu.php" class="btn-pay" style="display: inline-block; margin-top: 20px; text-decoration: none; padding: 12px 30px;">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <table class="cart-table">
                        <thead>
                            <tr><th>Sản phẩm</th><th>Đơn giá</th><th style="text-align:center">Số lượng</th><th style="text-align:right">Thành tiền</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php while($item = $cart_result->fetch_assoc()): 
                                $price_unit = $item['price'] + ($item['price_extra'] ?? 0);
                                $subtotal = $price_unit * $item['quantity'];
                            ?>
                            <tr>
                                <td>
                                    <div class="prod-info">
                                        <img src="/cafemenu/<?= htmlspecialchars($item['image']) ?>" onerror="this.src='/cafemenu/img/default.png'">
                                        <div>
                                            <div style="font-weight: bold;"><?= htmlspecialchars($item['name']) ?></div>
                                            <small style="color: #999;">Size: <?= htmlspecialchars($item['size'] ?? 'M') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= number_format($price_unit) ?>đ</td>
                                <td style="text-align: center;">
                                    <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" max="99" class="qty-input">
                                </td>
                                <td style="text-align: right; font-weight: bold; color: var(--cafe-accent);">
                                    <?= number_format($subtotal) ?>đ
                                </td>
                                <td style="text-align: center;">
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                        <button type="submit" name="remove_item" class="btn-remove-link" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update_cart" class="btn-main btn-update" style="margin-top: 20px;">CẬP NHẬT GIỎ HÀNG</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- GỢI Ý SẢN PHẨM -->
        <div class="suggest-section">
            <h3 style="border-left: 5px solid var(--cafe-accent); padding-left: 15px;">Có thể bạn cũng thích</h3>
            <div class="suggest-grid" id="suggestGrid">
                <?php
                $suggest_sql = "SELECT * FROM products WHERE id NOT IN (SELECT product_id FROM cart WHERE user_id = $user_id) ORDER BY RAND() LIMIT 4";
                $suggest_res = $conn->query($suggest_sql);
                while($s = $suggest_res->fetch_assoc()):
                ?>
                <div class="suggest-card" data-name="<?= htmlspecialchars($s['name']) ?>" data-price="<?= $s['price'] ?>" data-image="/cafemenu/<?= $s['image'] ?>">
                    <img src="/cafemenu/<?= $s['image'] ?>" onerror="this.src='/cafemenu/img/default.png'">
                    <div style="font-weight: bold;"><?= htmlspecialchars($s['name']) ?></div>
                    <div style="color: var(--cafe-accent); font-weight: bold; margin: 10px 0;"><?= number_format($s['price']) ?>đ</div>
                    <button class="btn-add-small suggest-add-btn">+ Thêm vào giỏ</button>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- THANH TOÁN -->
    <div class="sidebar">
        <div class="checkout-side">
            <h3 style="margin-top: 0;">Tóm tắt đơn hàng</h3>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Tạm tính</span>
                <span><?= number_format($total) ?>đ</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                <span>Phí vận chuyển</span>
                <span><?= number_format($total > 0 ? 15000 : 0) ?>đ</span>
            </div>

            <div class="address-box">
                <label>Địa chỉ giao hàng:</label>
                <textarea id="shipping_address" rows="3" placeholder="Nhập số nhà, tên đường, phường/xã..."><?= htmlspecialchars($user_address) ?></textarea>
            </div>

            <div class="note-box">
                <label>Ghi chú đơn hàng:</label>
                <textarea id="order_note" rows="2" placeholder="Ví dụ: không đá, ít đường, giao giờ hành chính..."></textarea>
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: bold; border-top: 2px dashed #eee; padding-top: 20px; margin-bottom: 25px;">
                <span>Tổng cộng</span>
                <span style="color: var(--cafe-accent);"><?= number_format($total > 0 ? $total + 15000 : 0) ?>đ</span>
            </div>

            <button type="button" class="btn-main btn-pay" onclick="handlePayment()" <?= $total == 0 ? 'disabled style="background:#ccc;"' : '' ?>>
                THANH TOÁN QR
            </button>
        </div>
    </div>
</div>

<!-- MODAL QR -->
<div id="qrModal">
    <div class="qr-content">
        <div style="text-align: right;"><button onclick="closeQR()" style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button></div>
        <h2>Quét mã chuyển khoản</h2>
        <p style="color:#666">Hệ thống sẽ tự xác nhận sau khi nhận tiền</p>
        <div style="font-size:28px; font-weight:bold; color:var(--cafe-accent); margin:20px 0;">
            <span id="qrTotal">0</span>đ
        </div>
        <img id="qrImg" src="" style="width:250px; height:250px; border:1px solid #eee; padding:10px; border-radius:15px;">
        <div style="margin-top:20px; background:#f9f9f9; padding:15px; border-radius:15px;">
            <strong>Nội dung CK:</strong> <span id="qrDesc" style="color:var(--cafe-accent); font-weight:bold;"></span>
        </div>
        <button onclick="confirmOrder()" class="btn-main btn-pay" style="margin-top:20px; background:#28a745;">XÁC NHẬN ĐÃ CHUYỂN</button>
    </div>
</div>

<script>
const totalAmount = <?= $total + 15000 ?>;
const userId = <?= $user_id ?>;

// ========== THÊM VÀO GIỎ TỪ GỢI Ý (DÙNG MODAL) ==========
document.querySelectorAll('.suggest-add-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const card = this.closest('.suggest-card');
        const name = card.dataset.name;
        const price = parseInt(card.dataset.price);
        const image = card.dataset.image;
        showProductModal(name, price, image);
    });
});

// ========== HÀM HIỆN MODAL SẢN PHẨM (TỪ cart.js) ==========
function showProductModal(name, price, image) {
    const old = document.getElementById('productModal');
    if (old) old.remove();
    
    const modalHtml = `
    <div id="productModal" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:10000; display:flex; align-items:center; justify-content:center;">
        <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7);"></div>
        <div style="position:relative; background:white; border-radius:20px; width:90%; max-width:500px; overflow:hidden;">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:15px 20px; background:#2b1f18; color:white;">
                <h3 style="margin:0;">Chọn thông tin</h3>
                <button id="closeModalBtn" style="background:none; border:none; color:white; font-size:28px; cursor:pointer;">&times;</button>
            </div>
            <div style="padding:20px; display:flex; gap:20px; flex-wrap:wrap;">
                <div style="width:120px; height:120px; background:#634832; border-radius:15px; overflow:hidden;">
                    <img id="modalImg" src="${image}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='/cafemenu/img/default.png'">
                </div>
                <div style="flex:1;">
                    <h4 style="font-size:20px; margin:0 0 5px;">${name}</h4>
                    <p>Giá gốc: <span id="basePrice">${price.toLocaleString()}</span>đ</p>
                    <p>Thành tiền: <strong id="finalPrice" style="color:#a67c52; font-size:22px;">${price.toLocaleString()}</strong>đ</p>
                    <div style="margin-bottom:15px;">
                        <label>Kích cỡ:</label>
                        <div style="display:flex; gap:10px; margin-top:5px;">
                            <button class="sizeOption" data-size="S" data-extra="0" style="width:44px; height:44px; border-radius:50%; border:2px solid #ddd; background:#2b1f18; color:white; cursor:pointer;">S</button>
                            <button class="sizeOption" data-size="M" data-extra="5000" style="width:44px; height:44px; border-radius:50%; border:2px solid #ddd; background:white; cursor:pointer;">M</button>
                            <button class="sizeOption" data-size="L" data-extra="10000" style="width:44px; height:44px; border-radius:50%; border:2px solid #ddd; background:white; cursor:pointer;">L</button>
                        </div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label>Số lượng:</label>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <button id="qtyMinus" style="width:36px; height:36px; border-radius:50%; border:1px solid #ddd; background:#f5f5f5; cursor:pointer;">-</button>
                            <input id="qtyInput" type="number" value="1" min="1" max="99" style="width:70px; text-align:center; padding:8px; border:1px solid #ddd; border-radius:8px;">
                            <button id="qtyPlus" style="width:36px; height:36px; border-radius:50%; border:1px solid #ddd; background:#f5f5f5; cursor:pointer;">+</button>
                        </div>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button id="addToCartBtn" style="flex:1; padding:12px; border:none; border-radius:30px; background:#2b1f18; color:white; font-weight:bold; cursor:pointer;">Thêm vào giỏ</button>
                        <button id="buyNowBtn" style="flex:1; padding:12px; border:none; border-radius:30px; background:#a67c52; color:white; font-weight:bold; cursor:pointer;">Mua ngay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    let selectedSize = 'S';
    let selectedExtra = 0;
    let currentPrice = price;
    
    function updatePrice() {
        const qty = parseInt(document.getElementById('qtyInput').value) || 1;
        const total = (currentPrice + selectedExtra) * qty;
        document.getElementById('finalPrice').innerHTML = total.toLocaleString();
    }
    
    document.querySelectorAll('.sizeOption').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.sizeOption').forEach(b => {
                b.style.background = 'white';
                b.style.color = '#333';
            });
            this.style.background = '#2b1f18';
            this.style.color = 'white';
            selectedSize = this.dataset.size;
            selectedExtra = parseInt(this.dataset.extra);
            updatePrice();
        });
    });
    
    const qtyInput = document.getElementById('qtyInput');
    document.getElementById('qtyMinus').onclick = () => {
        let val = parseInt(qtyInput.value);
        if (val > 1) qtyInput.value = val - 1;
        updatePrice();
    };
    document.getElementById('qtyPlus').onclick = () => {
        let val = parseInt(qtyInput.value);
        if (val < 99) qtyInput.value = val + 1;
        updatePrice();
    };
    qtyInput.onchange = () => updatePrice();
    
    function addToCart(redirect = false) {
        const quantity = parseInt(qtyInput.value) || 1;
        fetch('/cafemenu/api/add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                product_name: name,
                quantity: quantity,
                size: selectedSize,
                price_extra: selectedExtra
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('productModal').remove();
                if (redirect) window.location.href = '/cafemenu/cart.php';
                else window.location.reload();
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Lỗi!');
            }
        })
        .catch(err => alert('Lỗi kết nối!'));
    }
    
    document.getElementById('addToCartBtn').onclick = () => addToCart(false);
    document.getElementById('buyNowBtn').onclick = () => addToCart(true);
    document.getElementById('closeModalBtn').onclick = () => document.getElementById('productModal').remove();
    document.querySelector('#productModal > div:first-child').onclick = () => document.getElementById('productModal').remove();
}

// ========== THANH TOÁN QR ==========
function handlePayment() {
    const address = document.getElementById('shipping_address').value.trim();
    if (address === "") {
        alert("Vui lòng nhập địa chỉ nhận hàng!");
        document.getElementById('shipping_address').focus();
        return;
    }
    
    const bank = "BIDV";
    const account = "4420847563"; // THAY BẰNG STK THẬT
    const desc = "CAFE90S của tình yêu số " + userId;
    const qrUrl = `https://img.vietqr.io/image/${bank}-${account}-compact2.png?amount=${totalAmount}&addInfo=${desc}`;    
    document.getElementById('qrTotal').innerText = totalAmount.toLocaleString();
    document.getElementById('qrImg').src = qrUrl;
    document.getElementById('qrDesc').innerText = desc;
    document.getElementById('qrModal').style.display = 'flex';
}

function closeQR() {
    document.getElementById('qrModal').style.display = 'none';
}

function confirmOrder() {
    const address = document.getElementById('shipping_address').value.trim();
    const note = document.getElementById('order_note').value.trim();
    
    if (!address) {
        alert('Vui lòng nhập địa chỉ!');
        return;
    }
    
    fetch('/cafemenu/api/create_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            note: note,
            address: address,
            total: <?= $total ?>,
            shipping_fee: 15000
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Đặt hàng thành công! Cảm ơn bạn.');
            window.location.href = '/cafemenu/profile.php?tab=orders';
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(err => alert('Lỗi kết nối server!'));
}
</script>

<?php include 'includes/footer.php'; ?>