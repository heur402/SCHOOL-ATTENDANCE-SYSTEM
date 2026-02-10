<?php
include("../config/db.php");
include("../layout/header.php");
?>
<link rel="stylesheet" href="../style.css">

<div class="container">
    <h2>Mark School Attendance</h2>

    <form method="POST" action="save_attendance.php">

        <!-- Select Attendance Type -->
        <label>Select Attendance For:</label>
        <select name="user_type" id="user_type" onchange="handleUserType()" required>
            <option value="">-- Select Type --</option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select>

        <!-- Class (Only for Students) -->
        <div id="classDiv" style="display:none;">
            <label>Select Class:</label>
            <select name="class" id="class" onchange="loadUsers()">
                <option value="">--Select Class--</option>
                <?php
                $classes = mysqli_query($conn, "SELECT DISTINCT class FROM users WHERE user_type = 'student' AND class IS NOT NULL ORDER BY class ASC");
                while ($c = mysqli_fetch_assoc($classes)) {
                    echo "<option value='{$c['class']}'>{$c['class']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- User Select -->
        <label>Select Student / Teacher:</label>
        <select name="user_id" id="user_id" required>
            <option value="">-- Select User --</option>
        </select>

        <input type="date" name="date" required>

        <select name="status" required>
            <option value="present">Present</option>
            <option value="absent">Absent</option>
        </select>

        <button type="submit">Save Attendance</button>
    </form>
</div>
<script>

function handleUserType() {
    const type = document.getElementById('user_type').value;
    const classDiv = document.getElementById('classDiv');

    document.getElementById('user_id').innerHTML =
        '<option value="">-- Select User --</option>';

    if (type === "student") {
        classDiv.style.display = "block";
    } else {
        classDiv.style.display = "none";
        loadUsers(); // Load users directly
    }
}

function loadUsers() {
    const type = document.getElementById('user_type').value;
    const className = document.getElementById('class').value;
    const userSelect = document.getElementById('user_id');

    userSelect.innerHTML = '<option value="">Loading...</option>';

    let url = "get_users.php?type=" + type;
    
    if (type === "student") {
        if (!className) {
            userSelect.innerHTML = '<option value="">-- Select --</option>';
            return;
        }
        url += "&class=" + className;
    }

    fetch(url)
        .then(res => res.json())
        .then(data => {
            userSelect.innerHTML = '<option value="">-- Select --</option>';
            data.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.text = user.name;
                userSelect.add(option);
            });
        });
}

</script>