<?php
$active = "Checkout";
include('db.php');
include("functions.php");
include("header.php");
?>


<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <a href="shop.php">Shop</a>
                    <span>Check Out</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">
        <form class="checkout-form">
            <div class="row">

                <div class="col-lg-6" <?php if (!($_SESSION['customer_email'] == 'unset')) {
                                            echo "style = 'margin: 0 auto'";
                                        } ?>>
                    <div class="checkout-content">
                        <a href="shop.php" class="content-btn">Continue Shopping</a>
                    </div>
                    <div class="place-order">
                        <h4>Your Order</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li>Products <span>Total</span></li>
                                <?php checkoutProds(); ?>

                                <li class="fw-normal">Subtotal <span><?php total_price(); ?></span></li>
                                <li class="total-price">Total <span><?php total_price(); ?></span></li>
                            </ul>
                            <form action="check-out.php" method="post">
                                <div class="order-btn">
                                    <a href="check-out.php?place=1" class="site-btn place-btn">Place Order</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
        </form>
    </div>
</section>
<!-- Shopping Cart Section End -->


<?php
include('footer.php');
?>

</body>

</html>


<?php
if (isset($_GET['place'])) {

    $c_id = $_SESSION['customer_id'];

    // Get customer data
    $query = "SELECT * FROM customer WHERE customer_id = '$c_id'";
    $run_query = mysqli_query($con, $query);
    if (!$run_query) {
        die("Customer query failed: " . mysqli_error($con));
    }

    $get_query = mysqli_fetch_array($run_query);
    $custom_id = $get_query['customer_id'];

    // Get cart items
    $get_items = "SELECT * FROM cart WHERE c_id = '$c_id'";
    $run_items = mysqli_query($con, $get_items);
    if (!$run_items) {
        die("Cart query failed: " . mysqli_error($con));
    }

    while ($row_items = mysqli_fetch_array($run_items)) {
        $p_id = $row_items['products_id'];
        $pro_qty = $row_items['qty'];

        // Get product details
        $get_item = "SELECT * FROM products WHERE products_id = '$p_id'";
        $run_item = mysqli_query($con, $get_item);
        if (!$run_item) {
            die("Product query failed: " . mysqli_error($con));
        }

        $row_item = mysqli_fetch_array($run_item);
        $pro_price = $row_item['product_price'];

        $pro_total_p = $pro_price * $pro_qty;

        // Insert order
        $order = "INSERT INTO orders (order_qty, order_price, c_id, product_id, date)
                  VALUES ('$pro_qty', '$pro_total_p', '$custom_id', '$p_id', NOW())";

        $run_order = mysqli_query($con, $order);
        if (!$run_order) {
            die("Order insert failed: " . mysqli_error($con));
        }
    }

    // Clear the cart
    $cart_clear = "DELETE FROM cart WHERE c_id = '$c_id'";
    $run_clear = mysqli_query($con, $cart_clear);
    if (!$run_clear) {
        die("Cart clear failed: " . mysqli_error($con));
    }

    echo "<script>alert('Order Placed. Thank you for Shopping')</script>";
    echo "<script>window.open('account.php?orders','_self')</script>";
}
?>