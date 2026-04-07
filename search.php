<?php
// File: search.php
require_once 'includes/config.php';
$page_title = 'Tìm kiếm';
require_once 'includes/header.php';

$keyword = isset($_GET['q']) ? escape($_GET['q']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'all';

$results = [];
$count = 0;

if(!empty($keyword)) {
    // Tìm kiếm sản phẩm
    if($type == 'all' || $type == 'menu') {
        $menu_sql = "SELECT * FROM menu_items WHERE name LIKE '%$keyword%' OR description LIKE '%$keyword%'";
        $menu_result = $conn->query($menu_sql);
        while($row = $menu_result->fetch_assoc()) {
            $row['search_type'] = 'menu';
            $results[] = $row;
        }
    }
    
    // Tìm kiếm bài viết
    if($type == 'all' || $type == 'blog') {
        $blog_sql = "SELECT * FROM blog_posts WHERE title LIKE '%$keyword%' OR content LIKE '%$keyword%'";
        $blog_result = $conn->query($blog_sql);
        while($row = $blog_result->fetch_assoc()) {
            $row['search_type'] = 'blog';
            $results[] = $row;
        }
    }
    
    $count = count($results);
}
?>

<div class="container" style="padding: 40px 20px;">
    <h1>Tìm kiếm</h1>
    
    <form method="get" style="margin: 30px 0;">
        <div style="display: flex; gap: 10px;">
            <input type="text" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Nhập từ khóa..." style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            <select name="type" style="padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                <option value="all" <?php echo $type == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                <option value="menu" <?php echo $type == 'menu' ? 'selected' : ''; ?>>Thực đơn</option>
                <option value="blog" <?php echo $type == 'blog' ? 'selected' : ''; ?>>Blog</option>
            </select>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>
    
    <?php if(!empty($keyword)): ?>
        <p>Tìm thấy <strong><?php echo $count; ?></strong> kết quả cho "<?php echo htmlspecialchars($keyword); ?>"</p>
        
        <?php if($count > 0): ?>
            <div style="margin-top: 30px;">
                <?php foreach($results as $item): ?>
                    <?php if($item['search_type'] == 'menu'): ?>
                        <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                            <h3><a href="menu.php?cat=<?php echo $item['category']; ?>">🍵 <?php echo $item['name']; ?></a></h3>
                            <p><?php echo $item['description']; ?></p>
                            <p><strong>Giá: <?php echo formatPrice($item['price']); ?></strong></p>
                        </div>
                    <?php else: ?>
                        <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                            <h3><a href="post.php?id=<?php echo $item['id']; ?>">📝 <?php echo $item['title']; ?></a></h3>
                            <p><?php echo substr(strip_tags($item['content']), 0, 200); ?>...</p>
                            <small>Ngày: <?php echo date('d/m/Y', strtotime($item['created_at'])); ?></small>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>