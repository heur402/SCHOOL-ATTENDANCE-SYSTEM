<?php
include("../config/db.php"); 

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid user ID.");
}

$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("User not found.");
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $detail = $_POST['detail'];

    if ($user_type == 'student') {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, user_type=?, class=?, subject=NULL WHERE user_id=?");
        $stmt->bind_param("ssssi", $name, $email, $user_type, $detail, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, user_type=?, class=NULL, subject=? WHERE user_id=?");
        $stmt->bind_param("ssssi", $name, $email, $user_type, $detail, $id);
    }
    
    $stmt->execute();
    header("Location: view_users.php?msg=updated");
    exit();
}
?>

<?php include("../layout/header.php"); ?>

<div class="container">
    <h2>Update User</h2>

    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

        <label>Type:</label>
        <select name="user_type" id="user_type" onchange="toggleDetailField()">
            <option value="student" <?= $row['user_type'] == 'student' ? 'selected' : '' ?>>Student</option>
            <option value="teacher" <?= $row['user_type'] == 'teacher' ? 'selected' : '' ?>>Teacher</option>
        </select>

        <div id="detailField">
            <label id="detailLabel"><?= $row['user_type'] == 'student' ? 'Class:' : 'Subject:' ?></label>
            <input type="text" name="detail" id="detailInput" value="<?= htmlspecialchars($row['user_type'] == 'student' ? $row['class'] : $row['subject']) ?>" required>
        </div>

        <br><br>
        <button type="submit" name="update">Update</button>
    </form>
</div>

<script>
function toggleDetailField() {
    const type = document.getElementById('user_type').value;
    const label = document.getElementById('detailLabel');
    const input = document.getElementById('detailInput');
    
    if (type === 'student') {
        label.textContent = 'Class:';
        input.placeholder = 'Enter Class';
    } else {
        label.textContent = 'Subject:';
        input.placeholder = 'Enter Subject';
    }
}
</script>

<?php include("../layout/footer.php"); ?>