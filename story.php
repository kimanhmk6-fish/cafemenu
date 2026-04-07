<?php
$page_title = 'Câu chuyện 90s';
session_start();
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<!-- Nội dung chính của story -->
<section class="story-page">
    <div class="container">
        <h1 class="story-title">Câu Chuyện 90s</h1>
        <p class="story-subtitle">Hành trình hương vị qua thời gian</p>

        <!-- Phần 1: Khởi nguồn -->
        <div class="story-grid">
            <div>
                <img src="https://ik.imagekit.io/tvlk/blog/2022/10/cafe-sai-gon-xua-3.jpg?tr=dpr-2,w-675" alt="Khởi nguồn" class="story-img">
            </div>
            <div>
                <h2 class="story-heading">Khởi Nguồn</h2>
                <p class="story-text">Góc Cà Phê 90s ra đời từ tình yêu với những giá trị xưa cũ. Chúng tôi muốn tạo ra một không gian nơi mọi người có thể tìm lại những ký ức đẹp của thập niên 90 - thời kỳ vàng son của cà phê vỉa hè Sài Gòn.</p>
                <p class="story-text">Mỗi tách cà phê được pha bằng phương pháp phin truyền thống, mang hương vị đậm đà, nguyên bản. Mỗi góc nhỏ trong quán đều được bài trí với những kỷ vật của một thời: radio cassette, điện thoại quay số, băng nhạc, truyện tranh...</p>
            </div>
        </div>

        <!-- Phần 2: Giá trị cốt lõi -->
        <div class="story-grid">
            <div style="order: 2;">
                <img src="https://media.istockphoto.com/id/1503372218/photo/coffee-beans-roasted-in-sack-with-scoop.webp?b=1&s=170667a&w=0&k=20&c=F13uzXTYc8QDXdaqV0cWX8hBMDnirnT140BFnSBrbmw=" alt="Giá trị cốt lõi" class="story-img-rounded">
            </div>
            <div style="order: 1;">
                <h2 class="story-heading">Giá Trị Cốt Lõi</h2>
                <ul class="value-list">
                    <li><span class="value-check">✓</span> <strong>Nguyên bản:</strong> 100% cà phê nguyên chất, rang xay thủ công</li>
                    <li><span class="value-check">✓</span> <strong>Hoài niệm:</strong> Không gian và âm nhạc những năm 90</li>
                    <li><span class="value-check">✓</span> <strong>Kết nối:</strong> Nơi gặp gỡ của những tâm hồn đồng điệu</li>
                    <li><span class="value-check">✓</span> <strong>Tận tâm:</strong> Phục vụ bằng cả trái tim</li>
                </ul>
            </div>
        </div>

        <!-- Phần 3: Quote -->
        <div class="quote-block">
            <p class="quote-text">"Cà phê không chỉ là thức uống, mà còn là câu chuyện, là ký ức, là nơi chúng ta tìm về những giá trị đã mất."</p>
            <p class="quote-author">— Góc Cà Phê 90s —</p>
        </div>
    </div>
</section>

<style>
/* Chỉ thêm CSS riêng cho story, không ghi đè toàn bộ */
.story-page {
    padding: 60px 0 100px;
}
.story-title {
    font-family: 'Playfair Display', serif;
    font-size: 48px;
    text-align: center;
    color: var(--dark-brown);
    margin-bottom: 20px;
}
.story-subtitle {
    text-align: center;
    color: var(--gold-brown);
    font-style: italic;
    margin-bottom: 60px;
    font-size: 18px;
}
.story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
    margin-bottom: 80px;
}
.story-img {
    width: 100%;
    border-radius: 0 0 50px 50px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.story-img-rounded {
    width: 100%;
    border-radius: 50px 0 50px 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.story-heading {
    font-size: 2rem;
    margin-bottom: 20px;
    color: var(--dark-brown);
    font-family: 'Playfair Display', serif;
}
.story-text {
    line-height: 1.8;
    margin-bottom: 15px;
    color: #444;
}
.value-list {
    list-style: none;
    padding: 0;
}
.value-list li {
    margin-bottom: 15px;
    display: flex;
    gap: 10px;
    align-items: center;
}
.value-check {
    color: var(--gold-brown);
    font-size: 1.5rem;
    font-weight: bold;
}
.quote-block {
    background: #e8e2d6;
    padding: 40px;
    border-radius: 30px;
    text-align: center;
    margin-top: 60px;
}
.quote-text {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-style: italic;
    color: var(--dark-brown);
}
.quote-author {
    margin-top: 20px;
    color: var(--gold-brown);
}
@media (max-width: 768px) {
    .story-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    .story-title {
        font-size: 36px;
    }
    .quote-text {
        font-size: 18px;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>