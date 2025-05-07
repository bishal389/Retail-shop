<?php
require_once '../db.php';
require_once 'include/header.php';

if (!isset($_SESSION['admin_id'])) {
    echo "<script>window.open('login.php','_self');</script>";
    exit();
}

// Add new blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $image = mysqli_real_escape_string($con, $_POST['image']);
    $category_id = (int)$_POST['category'];

    $insert = "INSERT INTO blog_posts (title, content, image, category_id) VALUES ('$title', '$content', '$image', '$category_id')";
    if (mysqli_query($con, $insert)) {
        $_SESSION['success'] = "Blog post added successfully.";
        header("Location: admin_blog.php");
        exit();
    }
}

// Fetch all blog posts
$blogs = mysqli_query($con, "SELECT blog_posts.*, categories.name AS category_name FROM blog_posts LEFT JOIN categories ON blog_posts.category_id = categories.id ORDER BY blog_posts.created_at DESC");

// Fetch categories
$categories = mysqli_query($con, "SELECT * FROM categories");
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Blog Management</h1>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <!-- Add New Blog Post -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-plus me-1"></i> Add New Blog Post</div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="text" name="image" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name'] ?? ''); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Blog</button>
                    </form>
                </div>
            </div>

            <!-- List Blog Posts -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table me-1"></i> All Blog Posts</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($blog = mysqli_fetch_assoc($blogs)): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($blog['title'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($blog['category_name'] ?? 'Uncategorized'); ?></td>
                                    <td><img src="<?php echo (filter_var($blog['image'], FILTER_VALIDATE_URL)) ? $blog['image'] : '../' . htmlspecialchars($blog['image'] ?? ''); ?>" width="60" height="50" alt="Blog Image"></td>
                                    <td><?php echo $blog['created_at']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once 'include/footer.php'; ?>
