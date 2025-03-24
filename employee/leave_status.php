<?php
require '../connection.php';
session_start();

// Redirect to login if not logged in as employee
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$employee_email = $_SESSION['user'];

// Fetch leave requests for the logged-in employee
$query = "SELECT * FROM emp_leave WHERE email='$employee_email' ORDER BY start_date DESC LIMIT 10";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Status</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/header-styles.css">

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</head>
<body>
<div class="header">
        <div class="title">
            <h1>Employee Management System - Employee</h1>
        </div>
        <div class="buttons">
            <button onclick="redirectTo('dashboard.php')" class="current">Dashboard</button>
            <button onclick="redirectTo('leave_status.php')">Leave Status</button>
            <button onclick="redirectTo('apply_leave.php')">Apply for Leave</button>
            <button onclick="redirectTo('view_employee.php')">View Employees</button>
            <button onclick="redirectTo('profile.php')">Profile</button>
            <button onclick="redirectTo('logout.php')">Logout</button>
        </div>
    </div>
    <div class="container">
        <h2>Leave Status</h2>
        <table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Reason</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Days</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $start_date = new DateTime($row['start_date']);
                        $end_date = new DateTime($row['last_date']);
                        $interval = $start_date->diff($end_date);
                        $total_days = $interval->days + 1;
                        echo "<tr>
                                <td>{$sno}</td>
                                <td>{$row['reason']}</td>
                                <td>{$row['start_date']}</td>
                                <td>{$row['last_date']}</td>
                                <td>{$total_days}</td>
                                <td>{$row['status']}
                                </td>
                            </tr>";
                        $sno++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No leave requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
