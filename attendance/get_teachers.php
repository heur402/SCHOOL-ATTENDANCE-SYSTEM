<?php
include("../config/db.php");

$query = mysqli_query($conn,
    "SELECT teacher_id as id, name FROM teachers");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
?>
