<?php
$active = "Product";
include("db.php");
include("functions.php");
include('header.php');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM blog_posts WHERE id = $id";
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $title = htmlspecialchars($row['title']);
    $content = nl2br(htmlspecialchars($row['content']));
    $image = htmlspecialchars($row['image']);
    echo "
    <div class='container mt-5'>
        <h2>$title</h2>
        <img src='$image' class='img-fluid mb-3' alt='Blog Image'>
        <p>$content</p>
    </div>
    ";
} else {
    echo "<div class='container mt-5'><p>Post not found.</p></div>";
}
?>
<div style="overflow: hidden;">
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php"><i class="fa fa-home"></i> Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

</div>


<div class="related-products spad">
    <div class="container mt-5">
        <div class="row">
        <div class="col-lg-8">
            <h3>Welcome to our Fashion Blog!</h3>

            <?php
            $condition = "";
            if (isset($_GET['category'])) {
                $category_id = (int)$_GET['category'];
                $condition = "WHERE category_id = $category_id";
            }
            
            $query = "SELECT * FROM blog_posts $condition ORDER BY created_at DESC";
            $result = mysqli_query($con, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $title = htmlspecialchars($row['title']);
                $content = htmlspecialchars(substr($row['content'], 0, 200)) . "...";
                $image = htmlspecialchars($row['image']);
                $id = $row['id'];
                echo "
                <div class='card mb-4'>
                    <img src='$image' class='card-img-top' alt='Blog Image'>
                    <div class='card-body'>
                        <h5 class='card-title'>$title</h5>
                        <p class='card-text'>$content</p>
                        <a href='blog_post.php?id=$id' class='btn btn-primary'>Read More</a>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
            

        <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <ul class="list-group">
                            <?php
                            $cat_query = "SELECT * FROM categories";
                            $cat_result = mysqli_query($con, $cat_query);
                            while ($cat = mysqli_fetch_assoc($cat_result)) {
                                $cat_id = $cat['id'];
                                $cat_name = htmlspecialchars($cat['name']);
                                echo "<li class='list-group-item'>
                                    <a href='blog.php?category=$cat_id'>$cat_name</a>
                                </li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php
include('footer.php');
?>



</body>

</html>