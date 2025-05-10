<?php require_once 'include/header.php'?>
<div id="layoutSidenav_content">
   <main>
      <div class="container-fluid px-4">
         <h1 class="mt-4">Product </h1>
         <div class="row">
            <div class="col-xl-6">
               <div class="card mb-4">
                  <div class="card-header">
                     <i class="fas fa-list me-1"></i>
                     Enter Product Details
                  </div>
                  <div class="card-body">
                    <form method="post" action="include/admin_form.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Title/Name</label>
                            <input type="text" class="form-control" name="product_title" placeholder="Enter product name" required>
                        </div>
                        <div class="form-group">
                            <label for="product_category">Product Category</label>
                            <select class="form-control" name="cat_id" id="product_category" required>
                                <option value="">Select a Product Category</option>
                                <?php
                                $get_p_category = "SELECT * FROM category GROUP BY cat_title";
                                $run_p_category = mysqli_query($con, $get_p_category);
                                while ($p_cat_row = mysqli_fetch_array($run_p_category)) {
                                    $cat_id = $p_cat_row['cat_id'];
                                    $cat_title = $p_cat_row['cat_title'];
                                    echo "<option value='$cat_id' data-title='$cat_title'>$cat_title</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group" id="genderSelect" style="display: none;">
                            <label for="gender">Select Target Group</label>
                            <select class="form-control" name="product_gender">
                                <?php
                                $get_types_query = "SELECT DISTINCT p_cat_id, p_cat_type FROM product_categories WHERE p_cat_type IS NOT NULL AND p_cat_type != ''";
                                $run_types = mysqli_query($con, $get_types_query);

                                if ($run_types && mysqli_num_rows($run_types) > 0) {
                                    while ($type_row = mysqli_fetch_assoc($run_types)) {
                                        $id = htmlspecialchars($type_row['p_cat_id']);
                                        $type = htmlspecialchars($type_row['p_cat_type']);
                                        echo "<option value=\"$id\">$type</option>";
                                    }
                                } else {
                                    echo "<option disabled>No options available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Image # 1</label>
                            <input type="file" class="form-control" name="product_img1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Image # 2</label>
                            <input type="file" class="form-control" name="product_img2" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Price</label>
                            <input type="text" class="form-control" name="product_price" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Keywords</label>
                            <input type="text" class="form-control" name="product_keywords" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Product Description</label>
                            <textarea class="form-control" name="product_desc" cols="19" rows="6"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_status">Product Status</label>
                            <select class="form-control" name="product_status" required>
                                <option value="Active">Active</option>
                                <option value="Processing">Processing</option>
                                <option value="Sold">Sold</option>
                                <option value="Out of Stock">Out of Stock</option>
                                <option value="Coming Soon">Coming Soon</option>
                                <option value="Discontinued">Discontinued</option>
                            </select>
                        </div>
                        <input type="submit" value="Insert Product" name="product_add" class="btn btn-primary mt-2">
                    </form>

                  </div>
               </div>
            </div>
            
         </div>
      </div>
   </main>
   <script>
    function disableSubmit(form) {
        const btn = form.querySelector('#submitBtn');
        btn.disabled = true;
        btn.value = 'Submitting...';
    }
    document.addEventListener('DOMContentLoaded', function () {
        const productCategory = document.getElementById('product_category');
        const genderSelect = document.getElementById('genderSelect');

        productCategory.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const selectedTitle = selectedOption.getAttribute('data-title');

            if (selectedTitle.trim().toLowerCase() === 'clothes') {
                genderSelect.style.display = 'block';
            } else {
                genderSelect.style.display = 'none';
            }
        });
    });
   </script>
<?php require_once 'include/footer.php'?>