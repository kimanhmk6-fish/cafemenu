<?php
// File: blog.php
$page_title = 'Blog ký ức';
require_once 'includes/config.php';
require_once 'includes/header.php';

$category_names = getBlogCategories();
$selected_cat = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 6;

// Xây dựng câu truy vấn
$sql = "SELECT p.*, u.fullname as author_name FROM blog_posts p 
        LEFT JOIN users u ON p.author_id = u.id 
        WHERE p.status = 'published'";

if(!empty($selected_cat) && array_key_exists($selected_cat, $category_names)) {
    $sql .= " AND p.category = '" . escape($selected_cat) . "'";
}

if(!empty($search)) {
    $sql .= " AND (p.title LIKE '%" . escape($search) . "%' OR p.content LIKE '%" . escape($search) . "%')";
}

// Đếm tổng số bài viết
$count_sql = str_replace("p.*, u.fullname as author_name", "COUNT(*) as total", $sql);
$count_result = $conn->query($count_sql);
$total_posts = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_posts / $per_page);

// Phân trang
$offset = ($page - 1) * $per_page;
$sql .= " ORDER BY p.created_at DESC LIMIT $offset, $per_page";
$result = $conn->query($sql);
?>

<section class="py-3">
    <div class="section-title">
        <h2>Blog Ký Ức</h2>
        <p>Nơi những kỷ niệm ùa về</p>
    </div>
    
    <div class="container">
        <!-- Search and Filter -->
        <div style="background: var(--card-bg); padding: 30px; border-radius: 20px; margin-bottom: 40px;">
            <form method="get" style="display: grid; grid-template-columns: 1fr auto auto; gap: 15px;">
                <input type="text" name="search" placeholder="Tìm bài viết..." value="<?php echo htmlspecialchars($search); ?>" style="padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                
                <select name="category" style="padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                    <option value="">📌 Tất cả chủ đề</option>
                    <?php foreach($category_names as $key => $name): ?>
                        <option value="<?php echo $key; ?>" <?php echo ($selected_cat == $key) ? 'selected' : ''; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
        
        <!-- Blog Posts -->
        <?php if($result->num_rows == 0): ?>
            <div style="text-align: center; padding: 50px; background: var(--card-bg); border-radius: 20px;">
                <p style="font-size: 1.2rem;">Không tìm thấy bài viết nào phù hợp.</p>
            </div>
        <?php else: ?>
            <div class="blog-grid">
                <?php while($post = $result->fetch_assoc()): ?>
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="<?php echo getImageUrl($post['image'], 'blog'); ?>" alt="<?php echo $post['title']; ?>">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span>📅 <?php echo formatDate($post['created_at']); ?></span>
                                <span>✍️ <?php echo $post['author_name'] ?: 'Admin'; ?></span>
                                <span>📌 <?php echo $category_names[$post['category']] ?? 'Ký ức'; ?></span>
                            </div>
                            <h3><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h3>
                            <div class="blog-excerpt">
                                <?php echo truncate(strip_tags($post['content']), 150); ?>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="read-more">
                                    Đọc tiếp →
                                </a>
                                <?php if(isset($_SESSION['user_id'])): ?>
                                    <a href="favorite.php?post_id=<?php echo $post['id']; ?>" style="color: var(--accent-brown);" title="Lưu bài viết">
                                        ❤️
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
                <?php
                $url = "blog.php?";
                if(!empty($search)) $url .= "search=$search&";
                if(!empty($selected_cat)) $url .= "category=$selected_cat&";
                echo pagination($page, $total_pages, $url);
                ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>