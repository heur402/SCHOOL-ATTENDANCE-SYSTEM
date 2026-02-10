
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance System</title>
    <link rel="stylesheet" href="/attendance-system/style.css">
</head>
<body>
    <!-- Logout button in top right corner -->
    <?php if (isset($_SESSION['admin_logged_in'])): ?>
    <div style="position: fixed; top: 10px; right: 10px; z-index: 1000;">
        <a href="/attendance-system/admin/logout.php" 
           style="color: white; padding: 8px 15px; 
                  border-radius: 5px; text-decoration: none; font-size: 14px;">
            Logout
        </a>
    </div>
    <?php endif; ?>
    
    <header>
        <h1>School Attendance System</h1>
    </header>
    
    <nav>
        <a href="/attendance-system/index.php">Home</a>
        <a href="/attendance-system/students/add_user.php">Add</a>
        <a href="/attendance-system/students/view_users.php">View</a>
        <a href="/attendance-system/attendance/mark_attendance.php">Mark Attendance</a>
        <a href="/attendance-system/attendance/view_attendance.php">View Attendance</a>
    </nav>