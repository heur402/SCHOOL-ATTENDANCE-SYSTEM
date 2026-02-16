<?php include("../config/db.php"); ?>
<?php include("../layout/header.php"); ?>

<?php

// ================= PRESENT =================
$presentSql = "
SELECT attendance.*, users.name AS user_name
FROM attendance
LEFT JOIN users ON attendance.user_id = users.user_id
WHERE attendance.status = 'present'
ORDER BY attendance.date DESC
";

$presentRes = mysqli_query($conn, $presentSql);


// ================= ABSENT =================
$absentSql = "
SELECT attendance.*, users.name AS user_name
FROM attendance
LEFT JOIN users ON attendance.user_id = users.user_id
WHERE attendance.status = 'absent'
ORDER BY attendance.date DESC
";

$absentRes = mysqli_query($conn, $absentSql);

?>

<style>
    .container {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    /* Two Column Layout */
    .report-row {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .report-col {
        flex: 1;
    }

    /* Normal List Look */
    Ol {
        margin-left: 20px;
    }

    li {
        margin-bottom: 6px;
    }

    /* Titles */
    .present {
        color: green;
    }

    .absent {
        color: red;
    }

    /* Mobile Responsive */
    @media(max-width:768px) {
        .report-row {
            flex-direction: column;
        }
    }
</style>

<div class="container">

    <h2>Attendance Report</h2>

    <div class="report-row">

        <!-- ================= LEFT SIDE : PRESENT ================= -->
        <div class="report-col">

            <h3 class="present">Present</h3>

            <ol>
                <?php
                if (mysqli_num_rows($presentRes) > 0) {
                    while ($row = mysqli_fetch_assoc($presentRes)) {
                ?>
                        <li>
                            <strong><?= htmlspecialchars($row['user_name'] ?? 'Unknown') ?></strong>
                            - <?= ucfirst($row['user_type']) ?>
                        </li>
                <?php
                    }
                } else {
                    echo "<li>No Present Records</li>";
                }
                ?>
            </ol>

        </div>


        <!-- ================= RIGHT SIDE : ABSENT ================= -->
        <div class="report-col">

            <h3 class="absent">Absent</h3>

            <ol>
                <?php
                if (mysqli_num_rows($absentRes) > 0) {
                    while ($row = mysqli_fetch_assoc($absentRes)) {
                ?>
                        <li>
                            <strong><?= htmlspecialchars($row['user_name'] ?? 'Unknown') ?></strong>
                            - <?= ucfirst($row['user_type']) ?>

                        </li>
                <?php
                    }
                } else {
                    echo "<li>No Absent Records</li>";
                }
                ?>
            </ol>

        </div>

    </div>

</div>