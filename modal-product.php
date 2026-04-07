<?php
// modal-product.php - Hiển thị popup chọn size
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>
<div id="productModal" class="product-modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3>Chọn thông tin sản phẩm</h3>
            <button class="modal-close">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="modal-product-img" id="modal-product-img">
                <img id="modal-img" src="" alt="">
            </div>
            
            <div class="modal-product-info">
                <h4 id="modal-name"></h4>
                <p class="price">Giá gốc: <span id="modal-base-price"></span>đ</p>
                <p class="final-price">Thành tiền: <strong id="modal-final-price"></strong>đ</p>
                
                <!-- Chọn size từ database -->
                <div class="size-options" id="size-options">
                    <label>Kích cỡ:</label>
                    <div class="size-buttons" id="size-buttons">
                        <div class="loading-sizes">Đang tải...</div>
                    </div>
                </div>
                
                <!-- Chọn số lượng -->
                <div class="quantity-selector">
                    <label>Số lượng:</label>
                    <div class="quantity-control">
                        <button class="qty-minus">-</button>
                        <input type="number" id="modal-quantity" value="1" min="1" max="99">
                        <button class="qty-plus">+</button>
                    </div>
                </div>
                
                <!-- Nút hành động -->
                <div class="modal-actions">
                    <button class="btn-add-to-cart" id="btnAddToCart">
                        Thêm vào giỏ hàng
                    </button>
                    <button class="btn-buy-now" id="btnBuyNow">
                        Mua ngay
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    visibility: hidden;
    opacity: 0;
    transition: all 0.3s ease;
}
.product-modal.active {
    visibility: visible;
    opacity: 1;
}
.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
}
.modal-container {
    position: relative;
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 550px;
    z-index: 10;
    overflow: hidden;
    animation: modalSlideIn 0.3s ease;
}
@keyframes modalSlideIn {
    from { transform: scale(0.9) translateY(-30px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #2b1f18;
    color: white;
}
.modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 28px;
    cursor: pointer;
    line-height: 1;
}
.modal-body {
    padding: 20px;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.modal-product-img {
    width: 140px;
    height: 140px;
    background: #634832;
    border-radius: 15px;
    overflow: hidden;
    flex-shrink: 0;
}
.modal-product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.modal-product-info {
    flex: 1;
    min-width: 200px;
}
.modal-product-info h4 {
    font-size: 20px;
    margin-bottom: 8px;
    color: #2b1f18;
}
.modal-product-info .price {
    font-size: 14px;
    color: #666;
    margin-bottom: 8px;
}
.modal-product-info .final-price {
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
.modal-product-info .final-price strong {
    color: #a67c52;
    font-size: 22px;
}
.size-options, .quantity-selector {
    margin-bottom: 15px;
}
.size-options label, .quantity-selector label {
    display: block;
    font-size: 14px;
    margin-bottom: 8px;
    color: #666;
    font-weight: 600;
}
.size-buttons {
    display: flex;
    gap: 12px;
}
.size-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 2px solid #ddd;
    background: white;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.2s;
}
.size-btn:hover {
    border-color: #a67c52;
}
.size-btn.active {
    background: #2b1f18;
    color: white;
    border-color: #2b1f18;
}
.quantity-control {
    display: flex;
    align-items: center;
    gap: 12px;
}
.quantity-control button {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid #ddd;
    background: #f5f5f5;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}
.quantity-control button:hover {
    background: #e0e0e0;
}
.quantity-control input {
    width: 70px;
    text-align: center;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
}
.modal-actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}
.btn-add-to-cart, .btn-buy-now {
    flex: 1;
    padding: 12px 16px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-weight: bold;
    font-size: 15px;
    transition: all 0.2s;
}
.btn-add-to-cart {
    background: #2b1f18;
    color: white;
}
.btn-add-to-cart:hover {
    background: #1a120c;
}
.btn-buy-now {
    background: #a67c52;
    color: white;
}
.btn-buy-now:hover {
    background: #8b623f;
}
.loading-sizes {
    color: #999;
    font-size: 13px;
    padding: 8px 0;
}
</style>