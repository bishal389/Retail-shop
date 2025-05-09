<?php
require_once 'include/header.php';
if (!isset($_SESSION['admin_id'])) {
  echo "<script>window.open('login.php','_self');</script>";
  exit();
}
?>
<?php 
   require_once '../db.php';
   if (isset($_GET['delete_id'])) {
      if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'superadmin') {
         $query1 = "DELETE FROM customer WHERE customer_id=" . $_GET['delete_id'];
         $result1 = mysqli_query($con, $query1);
         if ($result1) {
               $_SESSION['success'] = "The data has been deleted successfully";
         }
      } else {
         $_SESSION['error'] = "You do not have permission to delete users.";
      }
   }

   $query = "SELECT * FROM `customer`";
   $result = mysqli_query($con, $query);
?>
<div id="layoutSidenav_content">
   <main>
      <div class="container-fluid px-4">
      <h1 class="mt-4">Users Table</h1>
         <?php if(isset($_SESSION['success'])):?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
            </div>
         <?php endif?>
         <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
               <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
         <?php endif ?>
        <div class="card mb-4">
            <div class="card-header">
               <i class="fas fa-table me-1"></i>
               All Users
            </div>
            
            <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'superadmin'): ?>
                           <th>Action</th>
                        <?php endif; ?>
                     </tr>
                  </thead>
                  <tbody>
                    <?php foreach($result as $i => $data):?>
                     <tr>
                        <td><?php echo ++$i;?></td>
                        <td><?php echo $data['customer_name']?></td>
                        <td><?php echo $data['customer_email']?></td>
                        <td><?php echo $data['customer_address']?></td>
                        <td><?php echo $data['customer_contact']?></td>
                        <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'superadmin'): ?>
                           <td>
                              <a href="javascript:delete_id(<?php echo $data['customer_id']; ?>)" class="btn btn-danger btn-sm">
                                 <i class="fas fa-trash"></i>
                              </a>
                           </td>
                        <?php endif; ?>
                     </tr>
                     <?php endforeach?>
                  </tbody>
                </table>
            </div>
         </div>
        </div>
   </main>
<script>
   function delete_id(id) {
    if (confirm('Are you sure you want to delete this?')) {
        window.location.href = 'users.php?delete_id=' + id;
    }
}
</script>


<?php require_once 'include/footer.php'?>
