<?php
require_once("db.php");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $con->prepare("SELECT * FROM customer WHERE verify_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $con->query("UPDATE customer SET email_verified = 1, verify_token = NULL WHERE verify_token = '$token'");
        echo "<script>alert('Email verified successfully! You can now login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Invalid or expired verification link.'); window.location.href='index.php';</script>";
    }
}
?>