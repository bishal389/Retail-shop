<?php
$active = "Product";
include("db.php");
include("functions.php");
include('header.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
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
            <a href='blog.php' class='btn btn-secondary mt-3'>Back to Blog</a>
        </div>
        ";
    } else {
        echo "<div class='container mt-5'><p>Post not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Invalid blog post ID.</p></div>";
}

include("footer.php");
?>