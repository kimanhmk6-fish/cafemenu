<?php
// File: news.php (đặt ở thư mục gốc /cafemenu/)
$page_title = 'Tin tức';
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<main>
    <section class="page-header">
        <h1 class="page-title">Tin tức</h1>
        <p class="page-description">
            Tại chuyên mục Coffeeholic, Góc chúng tớ kể những câu chuyện xoay quanh hạt cà phê – từ hành trình chọn lọc, rang xay đến ly cà phê trọn vị trên tay bạn. Mỗi bài viết là một lát cắt nhỏ trong hành trình Nhà mang nụ cười đến từ hương vị nguyên bản.
        </p>
    </section>

    <section class="news-container">
        
        <!--  SỬA LINK: bai1.html -> /cafemenu/pages/bai1.php -->
        <a href="/cafemenu/pages/bai1.php" class="card-link">
            <article class="card">
                <img src="https://images.unsplash.com/photo-1611162458324-aae1eb4129a4?q=80&w=600&auto=format&fit=crop" alt="Máy rang cà phê" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="category">COFFEEHOLIC</span>
                        <span class="date">22.03.2026</span>
                    </div>
                    <h2 class="card-title">VỊ CHUA TRONG TÁCH CÀ PHÊ: NÉT QUYẾN RŨ BỊ HIỂU LẦM</h2>
                    <p class="card-excerpt">
                        Nhiều người trong chúng ta thường mặc định rằng cà phê là phải đắng. Vì thế, khi vô tình nhấp một ngụm cà phê có vị chua, phản ứng đầu tiên thường là e ngại...
                    </p>
                </div>
            </article>
        </a>

        <!--  SỬA LINK: bai2.html -> /cafemenu/pages/bai2.php -->
        <a href="/cafemenu/pages/bai2.php" class="card-link">
            <article class="card">
                <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=600&auto=format&fit=crop" alt="Quán cà phê cổ" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="category">COFFEEHOLIC</span>
                        <span class="date">24.07.2022</span>
                    </div>
                    <h2 class="card-title">PHA CÀ PHÊ PHIN CHUẨN VỊ SÀI GÒN XƯA: NGHỆ THUẬT TỪ SỰ KIÊN NHẪN</h2>
                    <p class="card-excerpt">
                        Giữa nhịp sống hối hả của hiện đại, có những người vẫn chọn cho mình một góc nhỏ, ngồi ngắm nhìn từng giọt cà phê chầm chậm rơi qua chiếc phin nhôm cũ...
                    </p>
                </div>
            </article>
        </a>

        <!-- SỬA LINK: bai3.html -> /cafemenu/pages/bai3.php -->
        <a href="/cafemenu/pages/bai3.php" class="card-link">
            <article class="card">
                <img src="https://images.unsplash.com/photo-1559525839-b184a4d698c7?q=80&w=600&auto=format&fit=crop" alt="Bã cà phê" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="category">COFFEEHOLIC</span>
                        <span class="date">22.07.2021</span>
                    </div>
                    <h2 class="card-title">BÃ CÀ PHÊ: ĐỪNG VỘI BỎ ĐI, ĐÂY LÀ KHO BÁU TRONG CĂN BẾP CỦA BẠN</h2>
                    <p class="card-excerpt">
                        Sau khi thưởng thức xong một ly cà phê phin đậm đà, bạn thường làm gì với phần bã còn lại? Thay vì bỏ vào thùng rác, hãy giữ chúng lại...
                    </p>
                </div>
            </article>
        </a>

        <!-- SỬA LINK: bai4.html -> /cafemenu/pages/bai4.php -->
        <a href="/cafemenu/pages/bai4.php" class="card-link">
            <article class="card">
                <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=600&auto=format&fit=crop" alt="Cà phê sáng" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="category">COFFEEHOLIC</span>
                        <span class="date">27.05.2024</span>
                    </div>
                    <h2 class="card-title">CHỈ CHỌN CÀ PHÊ MỖI SÁNG NHƯNG CŨNG KHIẾN CUỘC SỐNG CỦA BẠN THÊM THÚ VỊ, TẠI SAO KHÔNG?</h2>
                    <p class="card-excerpt">
                        Thực chất, bạn không nhất thiết phải làm điều gì quá to tát để tạo nên một ngày rực rỡ. Đôi khi, sự thay đổi chỉ bắt đầu từ những việc nhỏ nhặt nhất...
                    </p>
                </div>
            </article>
        </a>

    </section>
</main>

<style>
/* CSS giữ nguyên như cũ */
.page-header { 
    text-align: center; 
    padding: 50px 20px; 
    max-width: 800px; 
    margin: 0 auto; 
}
.page-title { 
    font-family: 'Playfair Display', serif; 
    font-size: 42px; 
    color: #8C5E45; 
    margin-bottom: 20px; 
    font-style: italic; 
}
.page-description { 
    font-size: 15px; 
    color: #665246; 
}
.news-container { 
    max-width: 1100px; 
    margin: 0 auto; 
    padding: 0 20px 60px; 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); 
    gap: 30px; 
}
.card { 
    background-color: #F5EFEB; 
    border-radius: 15px; 
    overflow: hidden; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); 
    display: flex; 
    flex-direction: column; 
    height: 100%; 
    transition: transform 0.3s ease; 
}
.card:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); 
}
.card-img { 
    width: 100%; 
    height: 250px; 
    object-fit: cover; 
}
.card-content { 
    padding: 25px; 
    display: flex; 
    flex-direction: column; 
    flex-grow: 1; 
}
.card-meta { 
    display: flex; 
    justify-content: space-between; 
    font-size: 12px; 
    color: #888; 
    font-weight: 700; 
    margin-bottom: 15px; 
}
.card-meta .category { 
    color: #000; 
}
.card-meta .date { 
    color: #a08c80; 
}
.card-title { 
    font-size: 18px; 
    font-weight: 700; 
    margin-bottom: 15px; 
    line-height: 1.4; 
    color: #222; 
    text-transform: uppercase; 
}
.card-excerpt { 
    font-size: 14px; 
    color: #444; 
    flex-grow: 1; 
    text-align: justify; 
}
a.card-link { 
    text-decoration: none; 
    color: inherit; 
    display: block; 
}
@media (max-width: 768px) {
    .news-container { 
        grid-template-columns: 1fr; 
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>