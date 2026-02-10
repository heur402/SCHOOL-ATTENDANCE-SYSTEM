<?php
// get_users.php
include("../config/db.php");

$type = $_GET['type'] ?? '';
$class = $_GET['class'] ?? '';

$users = [];

if ($type === 'student') {
    $sql = "SELECT user_id, name FROM users WHERE user_type = 'student'";
    if (!empty($class)) {
        $sql .= " AND class = '" . mysqli_real_escape_string($conn, $class) . "'";
    }
    $sql .= " ORDER BY name";
    
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = [
            'id' => $row['user_id'],
            'name' => $row['name']
        ];
    }
} 
else if ($type === 'teacher') {
    $sql = "SELECT user_id, name FROM users WHERE user_type = 'teacher' ORDER BY name";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = [
            'id' => $row['user_id'],
            'name' => $row['name']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($users);
?>