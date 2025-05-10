<?php 
session_start();
require_once '../../db.php';

    if (isset($_POST['product_add'])) {

        $cat_id = $_POST['cat_id'];
        $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
        $product_img1 = $_FILES['product_img1']['name'];
        $product_img2 = $_FILES['product_img2']['name'];
        $product_price = $_POST['product_price'];
        $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
        $product_desc = mysqli_real_escape_string($con, $_POST['product_desc']);
        $product_gender = isset($_POST['product_gender']) ? $_POST['product_gender'] : null;
        $product_status = $_POST['product_status'];

        if ($cat_id == 3 && $product_gender !== null) {
            $p_cat_id = $product_gender;
        } else {
            $p_cat_id = $_POST['cat_id'];
        }

        $temp_name1 = $_FILES['product_img1']['tmp_name'];
        $temp_name2 = $_FILES['product_img2']['tmp_name'];

        move_uploaded_file($temp_name1, "../../img/products/$product_img1");
        move_uploaded_file($temp_name2, "../../img/products/$product_img2");

        $insert_product = "INSERT INTO products (
            p_cat_id, cat_id, date, product_title, product_img1, product_img2,
            product_price, product_keywords, product_desc,  product_status
        ) VALUES (
            '$p_cat_id', '$cat_id', NOW(), '$product_title', '$product_img1',
            '$product_img2', '$product_price', '$product_keywords', '$product_desc', '$product_status'
        )";

        $run_insert_product = mysqli_query($con, $insert_product);

        if ($run_insert_product) {
            $_SESSION['success'] = "Product added successfully";
            header('location:../product.php');
            exit();
        }
    }

    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
    
        // Prepare SQL statement
        $stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows === 1) {
            $data = $result->fetch_assoc();

            if (password_verify($password, $data['password'])) {
                $_SESSION['admin_id'] = $data['admin_id'];
                $_SESSION['admin_email'] = $data['admin_email'];
                $_SESSION['admin_role'] = $data['role'];
                $_SESSION['admin_name'] = $data['admin_name'];
                header('Location: ../index.php');
                exit;
            } else {
                $_SESSION['error'] = "Username or password invalid!";
                header('Location: ../login.php');
                exit;
            }
        } else {
            $_SESSION['error'] = "Username or password invalid!";
            header('Location: ../login.php');
            exit;
        }
    }

    if(isset($_POST['find'])){
		$email = $_POST['email'];

		$query = "SELECT * FROM admin WHERE admin_email = '$email'";

		$result = mysqli_query($con, $query);

		if(mysqli_num_rows($result) > 0){
			$data = mysqli_fetch_assoc($result);
			$_SESSION['success'] = "Email found! Change your password";

			$_SESSION['admin_email'] = $data['email'];
			header('location:../update-password.php');
		}
		else{
			$_SESSION['error'] = "No email found!";
			header('location:../forgot.php');

		}
	}
    if(isset($_POST['update'])){
		$pass = $_POST['password'];
		$email = $_SESSION['admin_email'];

		$query = "UPDATE admin SET admin.password ='$pass' WHERE admin.admin_email = '$email'";

		$result = mysqli_query($con, $query);
		$_SESSION['success'] = "Password updated successfully, Login to continue";
		header('location:../login.php');
	}
    if (isset($_POST['product_update'])) {

        $p_cat_id = $_POST['p_cat_id'];
        $cat_id = $_POST['cat_id'];
        $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
        $product_price = $_POST['product_price'];
        $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
        $product_desc = mysqli_real_escape_string($con, $_POST['product_desc']);
        $product_status = $_POST['product_status']; // Get product status
        $id = $_POST['product_id'];

        // Ensure product_status is sanitized (if needed)
        $product_status = mysqli_real_escape_string($con, $product_status);

        $update = "UPDATE products SET 
                    p_cat_id = '$p_cat_id', 
                    cat_id = '$cat_id', 
                    product_title = '$product_title', 
                    product_price = '$product_price', 
                    product_desc = '$product_desc', 
                    product_keywords = '$product_keywords', 
                    product_status = '$product_status'  -- Include product_status
                WHERE products_id = '$id'";

        echo $update;

        $run_update_product = mysqli_query($con, $update);

        if ($run_update_product) {
            $_SESSION['success'] = "Product updated successfully";
            header('location:../product.php');
        }
    }

?>