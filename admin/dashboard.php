<?php
require '../connection.php';
session_start();

// Redirect to login if not logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Total number of admins
$query_total_admins = "SELECT COUNT(*) as total_admins FROM admin";
$result_total_admins = mysqli_query($conn, $query_total_admins);
$row_total_admins = mysqli_fetch_assoc($result_total_admins);
$total_admins = $row_total_admins['total_admins'];

// Total number of employees
$query_total_employees = "SELECT COUNT(*) as total_employees FROM employee";
$result_total_employees = mysqli_query($conn, $query_total_employees);
$row_total_employees = mysqli_fetch_assoc($result_total_employees);
$total_employees = $row_total_employees['total_employees'];

// Employees on leave today
$today_date = date('Y-m-d');
$query_leave_today = "SELECT COUNT(*) as leave_today FROM emp_leave WHERE start_date <= '$today_date' AND last_date >= '$today_date' AND status = 'accepted'";
$result_leave_today = mysqli_query($conn, $query_leave_today);
$row_leave_today = mysqli_fetch_assoc($result_leave_today);
$leave_today = $row_leave_today['leave_today'];


// Employee leaderboard based on salary
$query_leaderboard = "SELECT id,name, salary FROM employee ORDER BY salary DESC LIMIT 10";
$result_leaderboard = mysqli_query($conn, $query_leaderboard);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            <h1>Employee Management System - Admin</h1>
        </div>
        <div class="buttons">
            <button onclick="redirectTo('dashboard.php')" class="current">Dashboard</button>
            <button onclick="redirectTo('manage_employee.php')">Manage Employees</button>
            <button onclick="redirectTo('manage_admin.php')">Manage Admins</button>
            <button onclick="redirectTo('manage_leave.php')">Manage Leaves</button>
            <button onclick="redirectTo('profile.php')">Profile</button>
            <button onclick="redirectTo('logout.php')">Logout</button>
        </div>
    </div>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <div class="dashboard-section">
            <h3>Total Admins: <?php echo $total_admins; ?></h3>
        </div>
        <div class="dashboard-section">
            <h3>Total Employees: <?php echo $total_employees; ?></h3>
        </div>
        <div class="dashboard-section">
            <h3>Employees on Leave Today: <?php echo $leave_today; ?></h3>
        </div>
        <div class="dashboard-section">
            <h3>Employee Leaderboard (Top 10 by Salary)</h3>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Salary</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($result_leaderboard)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['salary']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
