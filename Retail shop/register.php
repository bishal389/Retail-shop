<?php
    $active = "Register";
    include("db.php");
    include("functions.php");
    include('header.php');
?>

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="Index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Register</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Section Begin -->
<div class="register-login-section spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="register-form">
                    <h2>Register</h2>
                    <form action="register.php" method="post" enctype="multipart/form-data" id="logform">
                        <div class="row">
                            <div class="group-input col-md-6">
                                <label for="username">Name</label>
                                <input type="text" id="username" name="name" required>
                                <div id="nameerr" style="margin:20px 0"></div>
                            </div>
                            <div class="group-input col-md-6">
                                <label for="con">Contact *</label>
                                <input type="text" id="con" name="contact" required>
                                <div id="conerr" style="margin:20px 0"></div>
                            </div>
                        </div>
                        <div class="group-input">
                            <label for="email">Email *</label>
                            <input type="text" id="eemail" name="cemail" required>
                            <div id="eerr" style="margin:20px 0"></div>
                        </div>
                        <div class="group-input">
                            <label for="pass">Password *</label>
                            <input type="password" id="pass" name="password" required>
                            <small>Password must be at least 8 characters and include uppercase, lowercase, number, and symbol.</small>
                        </div>
                        <div class="group-input">
                            <label for="con-pass">Address *</label>
                            <input type="text" id="con-pass" name="address" required>
                        </div>
                        <div class="group-input">
                            <label for="con-pass">Profile Image *</label>
                            <input type="file" name="pimage" style="border: none; margin-top:6px;" required>
                        </div>
                        <button type="submit" class="site-btn register-btn" name="register">REGISTER</button>
                    </form>
                    <div class="switch-login">
                        <a href="login.php" class="or-login">Or Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Form Section End -->

<?php include('footer.php'); ?>

<script>
    $("#logform").submit(function(event) {
        var name = $('#username').val();
        var email = $('#eemail').val();
        var con = $('#con').val();
        var password = $('#pass').val();

        var letters = /^[A-Za-z]+(?: [A-Za-z]+){0,2}$/;
        var em = /\S+@\S+\.\S+/;
        var numbers = /^[0-9]{11}$/;
        var strongPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

        if (!name.match(letters)) {
            $("#nameerr").html("<span class='alert alert-danger'>Enter Valid Name (Letters only)</span>");
            event.preventDefault();
        }

        if (!con.match(numbers)) {
            $("#conerr").html(
                "<span class='alert alert-danger'>Enter Valid Contact (11 Digit)</span>");
            event.preventDefault();
        }

        if (!email.match(em)) {
            $("#eerr").html(
                "<span class='alert alert-danger'>Enter Valid Email</span>");
            event.preventDefault();
        }

        if (!password.match(strongPass)) {
            alert("Password must be at least 8 characters and include an uppercase letter, a lowercase letter, a number, and a special character.");
            event.preventDefault();
        }
    });
</script>

</body>
</html>

<?php
if (isset($_POST['register'])) {
    require_once("db.php");
    include('smtp/PHPMailerAutoload.php');

    function smtp_mailer($to, $subject, $msg) {
        $mail = new PHPMailer(); 
        $mail->IsSMTP(); 
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; 
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Username = "shopretail297@gmail.com";
        $mail->Password = "gjuc vncr bmrb gbyf";
        $mail->SetFrom("shopretail297@gmail.com");
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->AddAddress($to);
        $mail->SMTPOptions = array('ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ));

        if (!$mail->Send()) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        } else {
            return true;
        }
    }

    $c_name    = trim($_POST['name']);
    $c_email   = trim($_POST['cemail']);
    $c_address = trim($_POST['address']);
    $c_contact = trim($_POST['contact']);
    $c_pass_raw = $_POST['password'];
    $c_ip = getRealIpUser();

    // Check if email already exists
    $check_email = $con->prepare("SELECT customer_email FROM customer WHERE customer_email = ?");
    $check_email->bind_param("s", $c_email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email is already registered. Please use another email.'); window.location.href='register.php';</script>";
        exit();
    }
    $check_email->close();

    // Validate password
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $c_pass_raw)) {
        echo "<script>alert('Password must be at least 8 characters and include uppercase, lowercase, number, and special character.')</script>";
        exit();
    }

    $c_pass = password_hash($c_pass_raw, PASSWORD_DEFAULT);

    // Image upload
    $tardir = "img/customer/";
    $fileName = basename($_FILES['pimage']['name']);
    $targetPath = $tardir . $fileName;
    $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);
    $allow = array('jpg', 'jpeg', 'png');

    if (!in_array(strtolower($fileType), $allow)) {
        echo "<script>alert('Only JPG, JPEG, and PNG files are allowed.')</script>";
        exit();
    }

    if (!move_uploaded_file($_FILES['pimage']['tmp_name'], $targetPath)) {
        echo "<script>alert('Failed to upload image. Check folder permissions.')</script>";
        exit();
    }

    // Generate email verification token
    $verify_token = md5(rand());

    $stmt = $con->prepare("INSERT INTO customer (customer_name, customer_email, customer_pass, customer_address, customer_contact, customer_image, customer_ip, verify_token)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        error_log("Prepare failed: " . $con->error);
        echo "<script>alert('Database error: prepare failed.')</script>";
        exit();
    }

    $stmt->bind_param("ssssssss", $c_name, $c_email, $c_pass, $c_address, $c_contact, $fileName, $c_ip, $verify_token);

    if ($stmt->execute()) {
        $verify_link = "http://localhost:8000/verify.php?token=$verify_token";
        $subject = "Verify Your Email Address";
        $message = "
            <h3>Welcome, $c_name!</h3>
            <p>Please verify your email by clicking the link below:</p>
            <a href='$verify_link'>Verify Email</a>
        ";

        smtp_mailer($c_email, $subject, $message);

        echo "<script>alert('Registered successfully! Please check your email to verify your account.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Try again later.');</script>";
    }

    $stmt->close();
}
?>