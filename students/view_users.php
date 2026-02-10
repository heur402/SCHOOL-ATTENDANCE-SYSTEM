<?php
include("../config/db.php");
include("../layout/header.php");
?>
<link rel="stylesheet" href="../style.css">

<div class="container">
    <h2>Users List</h2>
    
    <!-- Filter by Type -->
    <form method="GET" action="" style="margin-bottom: 20px;">
        <select name="type" onchange="this.form.submit()">
            <option value="">All Users</option>
            <option value="student" <?= (isset($_GET['type']) && $_GET['type'] == 'student') ? 'selected' : '' ?>>Students</option>
            <option value="teacher" <?= (isset($_GET['type']) && $_GET['type'] == 'teacher') ? 'selected' : '' ?>>Teachers</option>
        </select>
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Class/Subject</th>
            <th>Action</th>
        </tr>

        <?php
        $type_filter = '';
        if (isset($_GET['type']) && in_array($_GET['type'], ['student', 'teacher'])) {
            $type_filter = " WHERE user_type = '{$_GET['type']}'";
        }
        
        $result = mysqli_query($conn, "SELECT * FROM users $type_filter ORDER BY user_type, name ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            $detail = ($row['user_type'] == 'student') ? $row['class'] : $row['subject'];
        ?>
        <tr>    
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= ucfirst(htmlspecialchars($row['user_type'])) ?></td>
            <td><?= htmlspecialchars($detail ?? '-') ?></td>
            <td>
                <a class="action-btn edit" href="edit_user.php?id=<?= $row['user_id'] ?>">Edit</a>
                <a class="action-btn delete" href="delete_user.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>