<?php
    // Start session and check if admin is logged in
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page
    header("Location: admin/login.php");
    exit();
}

 include("layout/header.php"); 

?>

<div class="container">
<h2>Welcome</h2>
<p>Manage school attendance easily.</p>
</div>

<?php include("layout/footer.php"); ?>
