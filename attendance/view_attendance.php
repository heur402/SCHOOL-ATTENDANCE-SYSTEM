<?php include("../config/db.php"); ?>
<?php include("../layout/header.php"); ?>
<link rel="stylesheet" href="../style.css">

<div class="container">
<h2>Attendance Records</h2>

<table>
<tr>
<th>Name</th>
<th>Type</th>
<th>Class</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php
$sql = "
SELECT 
    attendance.*,
    users.user_id,
    users.name AS user_name
FROM attendance
LEFT JOIN users ON attendance.user_id = users.user_id
ORDER BY attendance.date DESC
";

$res = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($res)){
?>
<tr>
<td><?= htmlspecialchars($row['user_name'] ?? 'Unknown') ?></td>
<td><?= ucfirst($row['user_type']) ?></td>
<td><?= $row['class'] ?? '-' ?></td>
<td><?= $row['date'] ?></td>
<td><?= ucfirst($row['status']) ?></td>
</tr>
<?php } ?>
</table>
</div>