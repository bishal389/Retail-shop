<?php
require_once '../db.php';
require_once 'include/header.php';

if (!isset($_SESSION['admin_id'])) {
    echo "<script>window.open('login.php','_self');</script>";
    exit();
}

$messages = mysqli_query($con, "SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Contact Messages</h1>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-envelope me-1"></i> All Contact Messages</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($msg = mysqli_fetch_assoc($messages)): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                                    <td><?php echo $msg['created_at']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <?php require_once 'include/footer.php'; ?>
</div>