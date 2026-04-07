<?php 
session_start();
include 'includes/data.php'; 
include 'includes/header.php'; 
?>

<section class="hero" id="home">
    <!-- Slideshow Container -->
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="img/banner1.jpg" style="width:100%; height:100%; object-fit: cover;">
        </div>
        <div class="mySlides fade">
            <img src="img/banner2.jpg" style="width:100%; height:100%; object-fit: cover;">
        </div>
        
        <!-- Lớp phủ nền.jpg (ảnh mờ) -->
        <div class="hero-overlay"></div>
    </div>
    
    <!-- Nội dung chữ nằm trên cùng -->
    <div class="hero-content">
        <h1>CÀ PHÊ SÀI GÒN</h1>
        <p>Hương vị hoài cổ từ những năm 90</p>
        <div class="btns">
            <button class="btn-dark" onclick="location.href='#thucdon'">Xem thực đơn</button>
<button class="btn-outline" onclick="location.href='#khonggian'">Xem không gian</button>        </div>
    </div>
    
    <!-- Các chấm tròn (dots) -->
    <div class="dots-slider">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>
    
    <div class="coffee-beans-boundary" style="bottom: -100px;">
        <img src="img/beans-decor.png" class="bean bean-hero-mid" alt="bean">
    </div>
</section>

<section class="menu" id="thucdon">
    <div class="container">
        <div class="title">
            <h2>Thực Đơn</h2>
            <p>Những món đặc trưng "ngày ấy"</p>
        </div>
        
        <!-- 3 MÓN NƯỚC ĐẶC BIỆT -->
        <div class="grid featured-grid">
            <!-- 1. Americano - Đen Dài Ngày -->
            <div class="card featured-card">
                <div class="product-img-wrapper">
                    <img src="img/americano.png" alt="Americano" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <p class="product-type">Americano</p>
                <h3>Đen Dài Ngày</h3>
                <div class="price" style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                    <span class="now" style="color: #A67C52; font-weight: bold; font-size: 20px;">28,000đ</span>
                    <span class="old" style="text-decoration: line-through; color: #ccc; font-size: 14px;">35,000đ</span>
                </div>
            </div>

            <!-- 2. Chiều Đào Phai -->
            <!-- 2. Chiều Đào Phai -->
            <div class="card featured-card">
                <div class="tag">
                    <span>BEST<br>SELLER</span>
                </div>
                <div class="product-img-wrapper">
                    <img src="img/caphe-dao-phai.png" alt="Chiều Đào Phai" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <p class="product-type">A-Mê Đào</p>
                <h3>Chiều Đào Phai</h3>
                <div class="price" style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                    <span class="now" style="color: #A67C52; font-weight: bold; font-size: 20px;">39,500đ</span>
                    <span class="old" style="text-decoration: line-through; color: #ccc; font-size: 14px;">44,500đ</span>
                </div>
            </div>

            <!-- 3. Cold Brew - Ủ Qua Đêm -->
            <div class="card featured-card">
                <div class="product-img-wrapper">
                    <img src="img/cold-brew.png" alt="Cold Brew" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <p class="product-type">Cold Brew</p>
                <h3>Ủ Qua Đêm</h3>
                <div class="price" style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                    <span class="now" style="color: #A67C52; font-weight: bold; font-size: 20px;">35,000đ</span>
                    <span class="old" style="text-decoration: line-through; color: #ccc; font-size: 14px;">40,000đ</span>
                </div>
            </div>
        </div>
        
        <div class="view-more-container" style="text-align: right; margin-top: 40px; padding-right: 20px;">
            <a href="menu.php" style="font-family: 'Playfair Display', serif; font-weight: bold; font-size: 20px; color: #2B1F18; text-decoration: none; border-bottom: 2px solid #2B1F18; padding-bottom: 5px; display: inline-flex; align-items: center; gap: 10px;">
                XEM THÊM <i class="fas fa-long-arrow-alt-right"></i>
            </a>
        </div>
    </div>
</section>

<section class="news" id="tintuc">
    <div class="container">
        <div class="title-news">
            <h2>Tin tức</h2>
            <div class="dots" id="newsDots">
                <!-- Dots sẽ được tạo tự động bằng JavaScript -->
            </div>
        </div>

        <div class="news-slider">
            <div class="arrow left" onclick="changeNews(-1)">
                <i class="fas fa-long-arrow-alt-left"></i>
            </div>
            <div class="news-list" id="newsList">
                <!-- Nội dung sẽ được JavaScript tạo động -->
            </div>
            <div class="arrow right" onclick="changeNews(1)">
                <i class="fas fa-long-arrow-alt-right"></i>
            </div>
        </div>

        <div class="view-more-news">
            <a href="news.php">XEM THÊM <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>
</section>
<div class="coffee-beans-boundary" style="bottom: -60px;">
    <img src="img/beans-decor.png" class="bean bean-news-left" alt="bean">
</div>

<section class="story" id="chuyen90s">
    <div class="container">
        <h2 class="story-title">Chuyện 90s</h2>
        
        <div class="story-wrapper">
            <div class="story-image-block">
                <img src="img/story.png" alt="Chuyện 90s - Hành trình hương vị">
                <div class="image-overlay-text">
                    Hành trình<br>hương vị qua thời gian
                </div>
            </div>

            <div class="story-content-block">
                <p>
                    Góc Cà Phê 90s ra đời từ tình yêu với những giá trị xưa cũ. Chúng tôi muốn tạo ra một không gian nơi mọi người có thể tìm lại những ký ức đẹp của thập niên 90 - thời kỳ vàng son của cà phê vỉa hè Sài Gòn. Mỗi tách cà phê không chỉ đơn thuần là thức uống, mà còn là câu chuyện, là cả một bầu trời ký ức tuổi thơ.
                </p>
                <div class="read-more-link">
                    <a href="story.php">Đọc tiếp <i class="fas fa-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hạt cà phê trang trí -->
    <div class="coffee-beans-decor">
        <img src="img/beans-decor.png" class="bean" alt="">
        <img src="img/beans-decor.png" class="bean" alt="">
        <img src="img/beans-decor.png" class="bean" alt="">
    </div>
</section>

<section class="space" id="khonggian" style="background-color: #5D544F; padding: 100px 0; color: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 45px; text-transform: uppercase;">Không gian</h2>
            <p style="font-style: italic; opacity: 0.8;">Nơi thưởng thức ngược thời gian</p>
        </div>

        <div style="display: flex; align-items: stretch; justify-content: center; gap: 30px; max-width: 1100px; margin: 0 auto;">
            
            <!-- Ảnh bên trái -->
            <div style="flex: 1; position: relative; background: #2B1F18; border-radius: 30px 150px 30px 100px; overflow: hidden; min-height: 320px;">
                <img src="img/sp2-l.jpeg" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.6; display: block;" id="leftImage">
                <div style="position: absolute; top: 40px; left: 40px; text-align: left; font-family: 'Playfair Display', serif;" id="leftText">
                    <h4 style="font-size: 24px; line-height: 1.2; margin: 0;">20h00 Thứ 7<br>hàng tuần</h4>
                </div>
            </div>

            <!-- Phần giữa - menu dọc và dots dọc -->
            <div style="flex: 0.6; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                <ul style="list-style: none; padding: 0; margin: 0 0 25px 0; font-size: 18px; font-weight: bold; line-height: 2.2;">
                    <li id="menu1" style="margin-bottom: 5px; text-decoration: underline; text-underline-offset: 8px;">Nhạc 90s Bất Hủ</li>
                    <li id="menu2" style="opacity: 0.4; margin-bottom: 5px;">Góc Nhỏ Kỷ Niệm</li>
                    <li id="menu3" style="opacity: 0.4; margin-top: 10px;">Sự Kiện Sắp Tới</li>
                </ul>
                
                <!-- Dots dọc -->
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 12px;">
                    <span class="dot-vertical active" data-index="0" style="width: 12px; height: 12px; background: white; border-radius: 50%; opacity: 1;"></span>
                    <span class="dot-vertical" data-index="1" style="width: 6px; height: 6px; background: white; border-radius: 50%; opacity: 0.4;"></span>
                    <span class="dot-vertical" data-index="2" style="width: 6px; height: 6px; background: white; border-radius: 50%; opacity: 0.4;"></span>
                </div>
            </div>

            <!-- Ảnh bên phải -->
            <div style="flex: 1; position: relative; background: #2B1F18; border-radius: 150px 30px 100px 30px; overflow: hidden; min-height: 380px;">
                <img src="img/sp2-r.jpeg" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.7; display: block;" id="rightImage">
                <div style="position: absolute; bottom: 30px; right: 30px; display: flex; align-items: center; gap: 12px;" id="rightText">
                    <span style="font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 500;">Đêm nhạc Trịnh</span>
                </div>
            </div>

        </div>
    </div>
</section>
<script>
// ===== HERO SLIDER =====
let slideIndex = 0;
let slideTimer;

function showSlides() {
    const slides = document.getElementsByClassName("mySlides");
    const dots = document.getElementsByClassName("dot");
    
    // Ẩn hết slide
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.opacity = "0";
    }
    
    // Chuyển sang slide tiếp theo
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    
    // Hiện slide hiện tại
    slides[slideIndex - 1].style.opacity = "1";
    
    // Cập nhật dot
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    dots[slideIndex - 1].classList.add("active");
    
    // Lặp lại sau 4 giây
    slideTimer = setTimeout(showSlides, 4000);
}

// Hàm chuyển slide khi click dot
function currentSlide(n) {
    clearTimeout(slideTimer);
    slideIndex = n - 1;
    
    const slides = document.getElementsByClassName("mySlides");
    const dots = document.getElementsByClassName("dot");
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.opacity = "0";
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    
    slides[n - 1].style.opacity = "1";
    dots[n - 1].classList.add("active");
    slideIndex = n;
    
    slideTimer = setTimeout(showSlides, 4000);
}

// Bắt đầu slider khi trang tải xong
document.addEventListener('DOMContentLoaded', function() {
    // Hiển thị slide đầu tiên
    const slides = document.getElementsByClassName("mySlides");
    const dots = document.getElementsByClassName("dot");
    
    slides[0].style.opacity = "1";
    dots[0].classList.add("active");
    slideIndex = 1;
    
    // Bắt đầu auto slide
    slideTimer = setTimeout(showSlides, 4000);
    
    // Dừng khi hover
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', function() {
            clearTimeout(slideTimer);
        });
        
        heroSection.addEventListener('mouseleave', function() {
            clearTimeout(slideTimer);
            slideTimer = setTimeout(showSlides, 4000);
        });
    }
});

// Smooth Scroll với bù trừ header fixed
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        if (targetId === '#' || targetId === '') return;

        const target = document.querySelector(targetId);
        if (target) {
            const headerHeight = 80;
            const rect = target.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            let targetPosition = rect.top + scrollTop;
            
            // Custom offset theo từng section
            if (targetId === '#tintuc') targetPosition -= 0;
            if (targetId === '#chuyen90s') targetPosition -= 0;
            if (targetId === '#khonggian') targetPosition -= 0;
            
            const offsetPosition = targetPosition - headerHeight;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Back to Top Button
const backToTop = document.createElement('button');
backToTop.innerHTML = '↑';
backToTop.className = 'back-to-top';
backToTop.style.cssText = `
    position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px;
    border-radius: 50%; background: #2b1f18; color: white; border: none;
    cursor: pointer; display: none; font-size: 1.5rem; z-index: 999;
`;
backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
document.body.appendChild(backToTop);

window.addEventListener('scroll', () => {
    backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
});
</script>
<script>
// ===== NEWS SLIDER VÔ TẬN - ẢNH PHỤ LÀ ẢNH TRUNG TÂM CŨ/TIẾP THEO =====
const newsData = [
    {
        id: 1,
        title: "VỊ CHUA TRONG TÁCH CÀ PHÊ",
        date: "22.03.2026",
        centerImage: "img/news-2.png"  // Ảnh chính của tin này
    },
    {
        id: 2,
        title: "PHA CÀ PHÊ PHIN CHUẨN VỊ SÀI GÒN XƯA: NGHỆ THUẬT TỪ SỰ KIÊN NHẪN",
        date: "24.07.2022",
        centerImage: "img/news-3.png"
    },
    {
        id: 3,
        title: "BÃ CÀ PHÊ: ĐỪNG VỘI BỎ ĐI, ĐÂY LÀ KHO BÁU TRONG CĂN BẾP CỦA BẠN",
        date: "22.07.2021",
        centerImage: "img/news-1.png"
    },
    {
        id: 4,
        title: "CHỈ CHỌN CÀ PHÊ MỖI SÁNG NHƯNG CŨNG KHIẾN CUỘC SỐNG CỦA BẠN THÊM THÚ VỊ, TẠI SAO KHÔNG?",
        date: "27.05.2024",
        centerImage: "img/news-4.jpg"
    }
];

let currentCenterIndex = 0; // Index của tin đang ở giữa
let previousCenterIndex = 3; // Index của tin trung tâm cũ (khởi tạo là tin cuối)
let nextCenterIndex = 1;     // Index của tin trung tâm tiếp theo (khởi tạo là tin thứ 2)

// Hàm cập nhật các index
function updateIndices() {
    const totalNews = newsData.length;
    previousCenterIndex = (currentCenterIndex - 1 + totalNews) % totalNews;
    nextCenterIndex = (currentCenterIndex + 1) % totalNews;
}

// Hàm lấy 3 tin để hiển thị
function getDisplayNews() {
    updateIndices();
    
    return {
        left: newsData[previousCenterIndex],   // Bên trái là tin TRUNG TÂM CŨ
        center: newsData[currentCenterIndex],  // Giữa là tin TRUNG TÂM HIỆN TẠI
        right: newsData[nextCenterIndex]       // Bên phải là tin TRUNG TÂM TIẾP THEO
    };
}

// Hàm render slider
function renderNewsSlider() {
    const displayNews = getDisplayNews();
    const newsList = document.getElementById('newsList');
    
    if (!newsList) return;
    
    const html = `
        <div class="news-item side" onclick="goToNews(${displayNews.left.id})">
            <img src="${displayNews.left.centerImage}" alt="${displayNews.left.title}">
        </div>
        <div class="news-item center" onclick="goToNews(${displayNews.center.id})">
            <div class="news-card-inner">
                <img src="${displayNews.center.centerImage}" alt="${displayNews.center.title}">
                <div class="news-content">
                    <h3>${displayNews.center.title}</h3>
                    <span class="date">${displayNews.center.date}</span>
                </div>
            </div>
        </div>
        <div class="news-item side" onclick="goToNews(${displayNews.right.id})">
            <img src="${displayNews.right.centerImage}" alt="${displayNews.right.title}">
        </div>
    `;
    
    newsList.innerHTML = html;
    updateDots();
}

// Hàm thay đổi tin (bấm mũi tên)
function changeNews(direction) {
    const totalNews = newsData.length;
    // Cập nhật index mới với vòng lặp vô tận
    currentCenterIndex = (currentCenterIndex + direction + totalNews) % totalNews;
    
    // Thêm hiệu ứng fade
    const newsList = document.getElementById('newsList');
    if (newsList) {
        newsList.style.opacity = '0.5';
        setTimeout(() => {
            renderNewsSlider();
            newsList.style.opacity = '1';
        }, 200);
    } else {
        renderNewsSlider();
    }
}

// Hàm cập nhật dots
function updateDots() {
    const dotsContainer = document.getElementById('newsDots');
    if (!dotsContainer) return;
    
    let dotsHtml = '';
    for (let i = 0; i < newsData.length; i++) {
        const activeClass = (i === currentCenterIndex) ? 'active' : '';
        dotsHtml += `<span class="${activeClass}" onclick="goToNewsByIndex(${i})"></span>`;
    }
    dotsContainer.innerHTML = dotsHtml;
}

// Hàm chuyển đến tin cụ thể khi click dot
function goToNewsByIndex(index) {
    currentCenterIndex = index;
    renderNewsSlider();
}

// Hàm xử lý khi click vào tin
function goToNews(newsId) {
    // Chuyển hướng đến bài viết tương ứng
    switch(newsId) {
        case 1:
            window.location.href = 'pages/bai1.php';
            break;
        case 2:
            window.location.href = 'pages/bai2.php';
            break;
        case 3:
            window.location.href = 'pages/bai3.php';
            break;
        case 4:
            window.location.href = 'pages/bai4.php';
            break;
        default:
            window.location.href = 'pages/news.php';
    }
}

// Khởi tạo slider khi trang load xong
document.addEventListener('DOMContentLoaded', function() {
    updateIndices(); // Khởi tạo các index phụ
    renderNewsSlider();
    
    // Tự động chạy slider mỗi 5 giây (tùy chọn)
    let autoSlideInterval;
    
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            changeNews(1);
        }, 5000);
    }
    
    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
    }
    
    const newsSection = document.querySelector('.news');
    if (newsSection) {
        newsSection.addEventListener('mouseenter', stopAutoSlide);
        newsSection.addEventListener('mouseleave', startAutoSlide);
        startAutoSlide();
    }
});
</script>
<script>
// ===== KHÔNG GIAN - TỰ ĐỘNG CHẠY VÒNG QUANH 3 MỤC =====
const spaceData = [
    {
        name: "Nhạc 90s Bất Hủ",
        leftImage: "img/sp2-l.jpeg",
        leftText: "20h00 Thứ 7<br>hàng tuần",
        rightImage: "img/sp2-r.jpeg",
        rightText: "Đêm nhạc Trịnh Công Sơn"
    },
    {
        name: "Góc Nhỏ Kỷ Niệm",
        leftImage: "img/sp3-l.jpeg",
        leftText: "10h00 Chủ Nhật<br>hàng tuần",
        rightImage: "img/sp3-r.jpeg",
        rightText: "Triển lãm 'Ký Ức Xưa'"
    },
    {
        name: "Sự Kiện Sắp Tới",
        leftImage: "img/space-left.png",    // ← đổi thành ảnh có sẵn
        leftText: "19h00 Thứ 6<br>01/05/2026",
        rightImage: "img/space-rightt.png", // ← đổi thành ảnh có sẵn
        rightText: "Live Acoustic - Tuyển 90s"
    }
];

let currentIndex = 0;
let autoInterval;

// Hàm cập nhật hiển thị
function updateSpaceDisplay(index) {
    const data = spaceData[index];
    
    // Cập nhật ảnh
    document.getElementById('leftImage').src = data.leftImage;
    document.getElementById('rightImage').src = data.rightImage;
    
    // Cập nhật text trên ảnh
    document.getElementById('leftText').innerHTML = `<h4 style="font-size: 24px; line-height: 1.2; margin: 0;">${data.leftText}</h4>`;
    document.getElementById('rightText').innerHTML = `
        <span style="font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 500;">${data.rightText}</span>
    `;
    
    // Cập nhật menu (gạch chân cái đang active)
    const menus = ['menu1', 'menu2', 'menu3'];
    menus.forEach((menuId, i) => {
        const menu = document.getElementById(menuId);
        if (i === index) {
            menu.style.textDecoration = 'underline';
            menu.style.textUnderlineOffset = '8px';
            menu.style.opacity = '1';
        } else {
            menu.style.textDecoration = 'none';
            menu.style.opacity = '0.4';
        }
    });
    
    // Cập nhật dots dọc
    const dots = document.querySelectorAll('.dot-vertical');
    dots.forEach((dot, i) => {
        if (i === index) {
            dot.style.width = '12px';
            dot.style.height = '12px';
            dot.style.opacity = '1';
        } else {
            dot.style.width = '6px';
            dot.style.height = '6px';
            dot.style.opacity = '0.4';
        }
    });
}

// Chuyển sang mục tiếp theo (vòng quanh)
function nextSpace() {
    currentIndex = (currentIndex + 1) % spaceData.length;
    updateSpaceDisplay(currentIndex);
}

// Chuyển sang mục trước đó
function prevSpace() {
    currentIndex = (currentIndex - 1 + spaceData.length) % spaceData.length;
    updateSpaceDisplay(currentIndex);
}

// Bắt đầu tự động chạy (mỗi 4 giây)
function startAutoSlide() {
    if (autoInterval) clearInterval(autoInterval);
    autoInterval = setInterval(nextSpace, 4000);
}

// Dừng tự động khi hover vào section space
function stopAutoSlide() {
    if (autoInterval) {
        clearInterval(autoInterval);
        autoInterval = null;
    }
}

// ===== GÁN SỰ KIỆN =====
// Click vào menu để chuyển thủ công
document.getElementById('menu1').addEventListener('click', function() {
    currentIndex = 0;
    updateSpaceDisplay(0);
    stopAutoSlide();
    startAutoSlide(); // Chạy lại timer từ đầu
});

document.getElementById('menu2').addEventListener('click', function() {
    currentIndex = 1;
    updateSpaceDisplay(1);
    stopAutoSlide();
    startAutoSlide();
});

document.getElementById('menu3').addEventListener('click', function() {
    currentIndex = 2;
    updateSpaceDisplay(2);
    stopAutoSlide();
    startAutoSlide();
});

// Click vào dots dọc
document.querySelectorAll('.dot-vertical').forEach((dot, idx) => {
    dot.addEventListener('click', function() {
        currentIndex = idx;
        updateSpaceDisplay(idx);
        stopAutoSlide();
        startAutoSlide();
    });
});

// Hover vào section space: tạm dừng tự động
const spaceSection = document.querySelector('#khonggian');
if (spaceSection) {
    spaceSection.addEventListener('mouseenter', stopAutoSlide);
    spaceSection.addEventListener('mouseleave', startAutoSlide);
}

// Khởi động
updateSpaceDisplay(0);
startAutoSlide();
</script>
<style>
/* ... code cũ ... */

/* THÊM MỚI TỪ ĐÂY */
/* Fix khung ảnh cố định */
#khonggian .container > div > div {
    align-items: stretch !important;
}

#khonggian div[style*="border-radius: 30px 150px"] {
    min-height: 380px !important;
    height: 380px !important;
}

#khonggian div[style*="border-radius: 150px 30px"] {
    min-height: 380px !important;
    height: 380px !important;
}

#leftImage, #rightImage {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

/* Hover effects */

#menu1, #menu2, #menu3 {
    transition: all 0.3s ease;
    cursor: pointer;
}

#menu1:hover, #menu2:hover, #menu3:hover {
    letter-spacing: 1px;
    transform: translateX(5px);
}

.dot-vertical {
    transition: all 0.3s ease;
    cursor: pointer;
}

.dot-vertical:hover {
    transform: scale(1.5);
    opacity: 1 !important;
}
</style>
<script>
(function() {
    'use strict';
    
    // Hàm scroll mượt đến phần tử
    function smoothScrollToElement(element) {
        if (element) {
            element.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
    
    // Xử lý khi load trang có hash (VD: index.php#tintuc)
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1);
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            // Delay nhẹ để đảm bảo DOM đã load xong
            setTimeout(function() {
                smoothScrollToElement(targetElement);
            }, 150);
        }
    }
    
    // Xử lý click vào các link chỉ có hash (khi đang ở index.php)
    const hashLinks = document.querySelectorAll('a[href^="#"]');
    hashLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Chỉ xử lý nếu link không phải là "#" hoặc rỗng
            const hash = this.getAttribute('href');
            if (hash === '#' || hash === '') return;
            
            e.preventDefault();
            const targetId = hash.substring(1);
            const target = document.getElementById(targetId);
            
            if (target) {
                smoothScrollToElement(target);
                // Cập nhật URL mà không reload trang
                history.pushState(null, null, hash);
            }
        });
    });
})();
</script>
<!-- Cart JavaScript -->
<script src="/cafemenu/assets/js/cart.js"></script>
<?php include 'includes/footer.php'; ?>
