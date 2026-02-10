<?php include("../layout/header.php"); ?>
<?php include("../config/db.php"); ?>

<div class="container">
<h2>Add Student or Teacher</h2>

<form method="POST">

<!-- Select Type -->
<label>Select Type</label>
<select name="user_type" id="user_type" onchange="toggleFields()" required>
    <option value="">-- Select --</option>
    <option value="student">Student</option>
    <option value="teacher">Teacher</option>
</select>

<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>

<!-- Student Field -->
<div id="classField" style="display:none;">
    <input type="text" name="class" placeholder="Class">
</div>

<!-- Teacher Field -->
<div id="subjectField" style="display:none;">
    <input type="text" name="subject" placeholder="Subject">
</div>

<button name="save">Save</button>
</form>
</div>
<script>
function toggleFields(){
    const type = document.getElementById("user_type").value;

    if(type === "student"){
        document.getElementById("classField").style.display = "block";
        document.getElementById("subjectField").style.display = "none";
    }else if(type === "teacher"){
        document.getElementById("classField").style.display = "none";
        document.getElementById("subjectField").style.display = "block";
    }
}
</script>
<?php
if(isset($_POST['save'])){

    $type = $_POST['user_type'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    if($type == "student"){
        $class = mysqli_real_escape_string($conn, $_POST['class']);
        $sql = "INSERT INTO users(name, email, user_type, class, subject)
                VALUES('$name','$email','$type','$class', NULL)";
    } else if($type == "teacher"){
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $sql = "INSERT INTO users(name, email, user_type, class, subject)
                VALUES('$name','$email','$type', NULL, '$subject')";
    }
    
    mysqli_query($conn, $sql);
    echo ucfirst($type) . " Added Successfully!";
}
?>