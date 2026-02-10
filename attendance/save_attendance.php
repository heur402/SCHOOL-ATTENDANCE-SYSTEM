<?php
include("../config/db.php");

$type = $_POST['user_type'];
$user_id = $_POST['user_id'];
$class = $_POST['class'] ?? NULL;
$date = $_POST['date'];
$status = $_POST['status'];

mysqli_query($conn, "
INSERT INTO attendance(user_type, user_id, class, date, status)
VALUES('$type','$user_id','$class','$date','$status')
");

header("Location: mark_attendance.php?success=1");
?>