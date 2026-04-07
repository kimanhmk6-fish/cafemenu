<?php

session_start(); 
include 'includes/menu_data.php'; include 'includes/header.php'; ?>

<section class="full-menu" style="background-color: #E6DED0; padding-bottom: 50px;">
    
    <!-- ===== BANNER GIỐNG TRANG CHỦ ===== -->
    <div class="menu-hero" style="position: relative; height: 65vh; min-height: 480px; overflow: hidden; margin-bottom: -1px;">
        <div class="slideshow-container" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
            <div class="mySlides fade">
                <img src="img/banner3.png" style="width:100%; height:100%; object-fit: cover;">
            </div>
            <div class="mySlides fade">
                <img src="img/banner4.jpeg" style="width:100%; height:100%; object-fit: cover;">
            </div>
            <div class="hero-overlay" style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); opacity:0.85; z-index:10;"></div>
        </div>
        
        <div class="hero-content" style="position: relative; z-index: 20; text-align: center; color: white; display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 65px; letter-spacing: 2px; text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">Thực đơn</h1>
            <p style="font-family: 'Playfair Display', serif; margin-top: 10px; font-size: 20px; font-weight: 300; letter-spacing: 1px; color: #f0f0f0;">Hôm nay quên vị gì?</p>
        </div>
        
        <div class="dots-slider" style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 20;">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </div>

    <!-- ===== PHẦN NỘI DUNG CHÍNH ===== -->
<div style="background: #e8e2d6; padding: 80px 0 80px; position: relative; z-index: 5;">
    <div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        
                <!-- Các nút lọc (filter) - STICKY HEADER -->
        <div class="menu-filter-wrapper">
            <div class="menu-filter">
                <a href="#homnay" class="filter-btn active" data-filter="homnay">HÔM NAY</a>
                <a href="#caphe" class="filter-btn" data-filter="caphe">CÀ PHÊ</a>
                <a href="#tra" class="filter-btn" data-filter="tra">TRÀ</a>
                <a href="#khac" class="filter-btn" data-filter="khac">KHÁC</a>
                <a href="#banh" class="filter-btn" data-filter="banh">BÁNH</a>
            </div>
        </div>

        <?php 
        $sections = [
            'homnay' => ['title' => '', 'filter' => 'best'],
            'caphe'  => ['title' => 'CÀ PHÊ', 'filter' => 'caphe'],
            'tra'    => ['title' => 'TRÀ', 'filter' => 'tra'],
            'khac'   => ['title' => 'KHÁC', 'filter' => 'khac'],
            'banh'   => ['title' => 'BÁNH', 'filter' => 'banh']
        ];

        foreach($sections as $id => $data): 
        ?>
<div id="<?= $id ?>" class="category-section" style="margin-top: 60px; scroll-margin-top: 170px; padding-top: 20px;">
    <?php if($data['title']): ?>
        <h2 class="section-heading" style="font-family: 'Playfair Display', serif; font-size: 28px; border-bottom: 2px solid #2B1F18; display: inline-block; margin-bottom: 35px; padding-bottom: 8px; scroll-margin-top: 170px;"><?= $data['title'] ?></h2>
    <?php endif; ?>
    

                <div class="product-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; max-width: 1000px; margin: 0 auto; padding: 0 15px;">
                    <?php foreach($all_menu_items as $item): 
                        $is_match = ($data['filter'] == 'best') ? ($item['best'] ?? false) : ($item['type'] == $data['filter'] && !($item['best'] ?? false));
                        if($is_match): 
                    ?>
                    <div class="product-card" style="text-align: center; position: relative; transition: 0.3s;">
                        <div class="product-img-box" style="position: relative; background-color: #634832; border-radius: 30px; height: 250px; display: flex; justify-content: center; align-items: center;">
                            <?php if(isset($item['best']) && $item['best']): ?>
                                <div class="badge-best-seller" style="position: absolute; bottom: 10px; right: 10px; background: white; border: 1px dashed #8d6e63; padding: 4px 8px; font-size: 10px; font-weight: bold; color: #8d6e63; transform: rotate(-5deg); z-index: 5; border-radius: 4px;">BEST SELLER</div>
                            <?php endif; ?>
                            <img src="<?= $item['image'] ?>" onerror="this.src='img/default.png'" style="display: block; margin: 0 auto; max-width: 85%; max-height: 85%; width: auto; height: auto; object-fit: contain;">
                        </div>
                        <div class="product-info" style="margin-top: 15px; text-align: center; width: 100%;">
                            <span class="product-note" style="font-size: 12px; color: #8d6e63; display: block;"><?= $item['note'] ?></span>
                            <h3 class="product-name" style="font-family: 'Playfair Display', serif; font-size: 20px; color: #2B1F18; margin: 5px 0;"><?= $item['name'] ?></h3>
<div class="product-price">
    <?php if(!empty($item['old_price']) && $item['old_price'] > 0): ?>
        <div class="price-wrapper">
            <span class="current-price"><?= number_format($item['price']) ?>đ</span>
            <span class="old-price"><?= number_format($item['old_price']) ?>đ</span>
        </div>
    <?php else: ?>
        <span class="current-price"><?= number_format($item['price']) ?>đ</span>
    <?php endif; ?>
</div>    
       </div>
                    </div>
                    <?php endif; endforeach; ?>
                </div>
                
                <?php if($id == 'homnay'): ?>
                    <div style="text-align: center; margin-top: 30px;">
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>
    </div> <!-- Đóng container -->
    </div> <!-- Đóng div background -->
<!-- Giỏ hàng cố định dưới cùng -->
<div class="cart-footer">
    <a href="cart.php">GIỎ HÀNG <i class="fas fa-shopping-cart"></i></a>
</div>
</section>

<script>
// Slider cho banner
let slideIndex_menu = 0;
let slideTimer_menu;

function showSlides_menu() {
    const slides = document.querySelectorAll('.menu-hero .mySlides');
    const dots = document.querySelectorAll('.menu-hero .dot');
    if (slides.length === 0) return;
    for (let i = 0; i < slides.length; i++) slides[i].style.opacity = "0";
    slideIndex_menu++;
    if (slideIndex_menu > slides.length) slideIndex_menu = 1;
    slides[slideIndex_menu - 1].style.opacity = "1";
    for (let i = 0; i < dots.length; i++) dots[i].classList.remove("active");
    if (dots[slideIndex_menu - 1]) dots[slideIndex_menu - 1].classList.add("active");
    slideTimer_menu = setTimeout(showSlides_menu, 4000);
}

function currentSlide(n) {
    clearTimeout(slideTimer_menu);
    slideIndex_menu = n - 1;
    const slides = document.querySelectorAll('.menu-hero .mySlides');
    const dots = document.querySelectorAll('.menu-hero .dot');
    for (let i = 0; i < slides.length; i++) slides[i].style.opacity = "0";
    for (let i = 0; i < dots.length; i++) dots[i].classList.remove("active");
    slides[n - 1].style.opacity = "1";
    if (dots[n - 1]) dots[n - 1].classList.add("active");
    slideIndex_menu = n;
    slideTimer_menu = setTimeout(showSlides_menu, 4000);
}

document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.menu-hero .mySlides');
    const dots = document.querySelectorAll('.menu-hero .dot');
    if (slides.length > 0) {
        slides[0].style.opacity = "1";
        if (dots[0]) dots[0].classList.add("active");
        slideIndex_menu = 1;
        slideTimer_menu = setTimeout(showSlides_menu, 4000);
        const menuHero = document.querySelector('.menu-hero');
        if (menuHero) {
            menuHero.addEventListener('mouseenter', () => clearTimeout(slideTimer_menu));
            menuHero.addEventListener('mouseleave', () => {
                clearTimeout(slideTimer_menu);
                slideTimer_menu = setTimeout(showSlides_menu, 4000);
            });
        }
    }
    
    // Active filter button khi click
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            filterBtns.forEach(b => {
                b.style.background = 'transparent';
                b.style.color = '#2b1f18';
            });
            this.style.background = '#2b1f18';
            this.style.color = '#e6ded0';
        });
    });
});
</script>
<style>
.product-card {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.product-img-box {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.product-img-box img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.product-info {
    text-align: center;
    width: 100%;
}
</style>
<script>
// Active menu item dựa trên vị trí scroll
window.addEventListener('scroll', function() {
    const filterWrapper = document.querySelector('.menu-filter-wrapper');
    if (filterWrapper) {
        if (window.scrollY > 100) {
            filterWrapper.classList.add('scrolled');
        } else {
            filterWrapper.classList.remove('scrolled');
        }
    }
    
    // Active menu item dựa trên vị trí scroll
    const sections = ['homnay', 'caphe', 'tra', 'khac', 'banh'];
    let current = '';
    
    sections.forEach(section => {
        const element = document.getElementById(section);
        if (element) {
            const rect = element.getBoundingClientRect();
            const offset = 170;
            if (rect.top <= offset && rect.bottom >= 100) {
                current = section;
            }
        }
    });
    
    // Cập nhật active class cho filter buttons
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        const href = btn.getAttribute('href');
        if (href && href.substring(1) === current) {
            filterBtns.forEach(b => {
                b.classList.remove('active');
                b.style.background = 'transparent';
                b.style.color = '#2b1f18';
            });
            btn.classList.add('active');
            btn.style.background = '#2b1f18';
            btn.style.color = '#e6ded0';
        }
    });
});

// ===== SMOOTH SCROLL KHI CLICK FILTER =====
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId && targetId !== '#') {
            const target = document.querySelector(targetId);
            if (target) {
                const heading = target.querySelector('.section-heading');
                let scrollTarget = target;
                
                if (heading) {
                    scrollTarget = heading;
                }
                
                const headerHeight = 80;
                const filterHeight = 70;
                const spaceFromFilter = 20;
                const totalOffset = headerHeight + filterHeight + spaceFromFilter;
                const targetPosition = scrollTarget.getBoundingClientRect().top + window.pageYOffset - totalOffset;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        }
        
        // Cập nhật active style
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.background = 'transparent';
            btn.style.color = '#2b1f18';
        });
        this.classList.add('active');
        this.style.background = '#2b1f18';
        this.style.color = '#e6ded0';
    });
});

// Active button ban đầu và xử lý hash URL
document.addEventListener('DOMContentLoaded', function() {
    const activeBtn = document.querySelector('.filter-btn.active');
    if (activeBtn) {
        activeBtn.style.background = '#2b1f18';
        activeBtn.style.color = '#e6ded0';
    }
    
    if (window.location.hash) {
        setTimeout(function() {
            const targetId = window.location.hash.substring(1);
            const target = document.getElementById(targetId);
            if (target) {
                const heading = target.querySelector('.section-heading');
                let scrollTarget = target;
                if (heading) scrollTarget = heading;
                
                const headerHeight = 80;
                const filterHeight = 70;
                const spaceFromFilter = 20;
                const totalOffset = headerHeight + filterHeight + spaceFromFilter;
                const targetPosition = scrollTarget.getBoundingClientRect().top + window.pageYOffset - totalOffset;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        }, 100);
    }
});
</script>
<script>
// ===== HIỆN/ẨN GIỎ HÀNG KHI SCROLL =====
document.addEventListener('DOMContentLoaded', function() {
    const cartFooter = document.querySelector('.cart-footer');
    const filterWrapper = document.querySelector('.menu-filter-wrapper');
    
    if (!cartFooter) return;
    
    function toggleCartOnScroll() {
        if (filterWrapper) {
            const filterPosition = filterWrapper.getBoundingClientRect();
            const filterBottom = filterPosition.bottom;
            
            // Hiện khi đã scroll qua thanh filter hoặc scroll > 200px
            if (filterBottom <= 0 || window.scrollY > 200) {
                cartFooter.classList.add('show');
            } else {
                cartFooter.classList.remove('show');
            }
        } else {
            if (window.scrollY > 300) {
                cartFooter.classList.add('show');
            } else {
                cartFooter.classList.remove('show');
            }
        }
    }
    
    toggleCartOnScroll();
    window.addEventListener('scroll', toggleCartOnScroll);
});
</script>
<!-- Cart JavaScript -->
<script src="/cafemenu/assets/js/cart.js"></script>
<?php include 'includes/footer.php'; ?>