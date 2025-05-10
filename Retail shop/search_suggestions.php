<?php
    require_once('config.php');
    include('db.php');

    if (isset($_GET['query'])) {
        $query = mysqli_real_escape_string($con, $_GET['query']);
        
        $get_products = "SELECT * FROM products WHERE product_title LIKE '%$query%'";
        $run_products = mysqli_query($con, $get_products);
        
        if (mysqli_num_rows($run_products) > 0) {
            while ($row_product = mysqli_fetch_array($run_products)) {
                $product_id = $row_product['products_id'];
                $product_title = $row_product['product_title'];

                echo "<a href='product.php?product_id=$product_id' class='dropdown-item'>$product_title</a>";
            }
        } else {
            echo "<div class='dropdown-item'>No products found</div>";
        }
    }
?>