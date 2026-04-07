<?php
// news_detail.php - trang chi tiết tin tức
require_once 'includes/config.php';
require_once 'includes/header.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: news.php');
    exit();
}

// Lấy bài viết theo slug
$stmt = $conn->prepare("
    SELECT n.*, c.category_name 
    FROM news n 
    LEFT JOIN categories c ON n.category_id = c.id 
    WHERE n.slug = ? AND n.status = 'published'
");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    header('Location: news.php');
    exit();
}

$page_title = htmlspecialchars($news['title']);
?>

<main>
    <article class="news-detail">
        <div class="container">
            <div class="news-header">
                <div class="news-meta">
                    <span class="category"><?= htmlspecialchars($news['category_name'] ?? 'COFFEEHOLIC') ?></span>
                    <span class="date"><?= date('d F, Y', strtotime($news['created_at'])) ?></span>
                </div>
                <h1 class="news-title"><?= htmlspecialchars($news['title']) ?></h1>
            </div>
            
            <?php if ($news['image']): ?>
                <div class="news-image">
                    <img src="<?= BASE_URL . $news['image'] ?>" alt="<?= htmlspecialchars($news['title']) ?>">
                </div>
            <?php endif; ?>
            
            <div class="news-content">
                <?= $news['content'] ?>
            </div>
            
            <div class="news-footer">
                <a href="news.php" class="btn-back">← Quay lại trang tin tức</a>
            </div>
        </div>
    </article>
</main>

<style>
.news-detail {
    padding: 60px 0;
    background: #fff;
}
.news-detail .container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}
.news-header {
    text-align: center;
    margin-bottom: 40px;
}
.news-meta {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #a08c80;
}
.news-meta .category {
    color: #8C5E45;
    font-weight: 600;
}
.news-title {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    color: #2c1810;
    line-height: 1.3;
}
.news-image {
    margin-bottom: 40px;
    border-radius: 15px;
    overflow: hidden;
}
.news-image img {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
}
.news-content {
    font-size: 17px;
    line-height: 1.8;
    color: #333;
}
.news-content p {
    margin-bottom: 20px;
}
.news-content h2, .news-content h3 {
    margin-top: 30px;
    margin-bottom: 15px;
    color: #2c1810;
}
.btn-back {
    display: inline-block;
    margin-top: 40px;
    padding: 12px 24px;
    background: #8C5E45;
    color: white;
    text-decoration: none;
    border-radius: 30px;
    transition: background 0.3s;
}
.btn-back:hover {
    background: #6b452e;
}
@media (max-width: 768px) {
    .news-title {
        font-size: 28px;
    }
    .news-content {
        font-size: 15px;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>