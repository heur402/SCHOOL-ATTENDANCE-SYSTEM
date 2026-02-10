<?php
include("../config/db.php");

$id = $_GET['id'] ?? 0;

if ($id > 0) {
    // First delete attendance records
    mysqli_query($conn, "DELETE FROM attendance WHERE user_id = $id");
    
    // Then delete the user
    mysqli_query($conn, "DELETE FROM users WHERE user_id = $id");
}

if(isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    header("Location: view_users.php");
    exit();
}
?>