<?php
// dashboard.php for employee
require '../connection.php';
session_start();

// Redirect to login if not logged in as employee
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['user'];

// Fetch upcoming leave date and last leave date
$current_date = date("Y-m-d");
$query = "SELECT start_date FROM emp_leave WHERE email='$email' AND status='Accepted' AND start_date > '$current_date' ORDER BY start_date DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$upcoming_leave_date = $row['start_date'] ?? 'No Upcoming Leaves';

$query = "SELECT last_date FROM emp_leave WHERE email='$email' AND status='Accepted'  AND last_date < '$current_date' ORDER BY start_date DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$last_leave_date = $row['last_date'] ?? 'No Leaves';

// $query = "SELECT start_date, last_date FROM emp_leave WHERE email='$email' AND status='Accepted' ORDER BY start_date DESC LIMIT 1";
// $result = mysqli_query($conn, $query);
// $row = mysqli_fetch_assoc($result);
// $upcoming_leave_date = $row['start_date'] ?? 'No Upcoming Leaves';
// $last_leave_date = $row['last_date'] ?? 'N/A';

// Fetch leave status
$query = "SELECT COUNT(*) as total_applied FROM emp_leave WHERE email='$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_applied = $row['total_applied'];

$query = "SELECT COUNT(*) as total_accepted FROM emp_leave WHERE email='$email' AND status='Accepted'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_accepted = $row['total_accepted'];

$today_date = date('Y-m-d');
$query = "UPDATE emp_leave SET status = 'Rejected' WHERE status = 'Pending' AND start_date < '$today_date'";
$result = mysqli_query($conn, $query);

$query = "SELECT COUNT(*) as total_rejected FROM emp_leave WHERE email='$email' AND status='Rejected'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_rejected = $row['total_rejected'];

$query = "SELECT COUNT(*) as total_pending FROM emp_leave WHERE email='$email' AND status='Pending'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_pending = $row['total_pending'];

// Fetch employee leaderboard based on salary
$query = "SELECT * FROM employee ORDER BY salary DESC LIMIT 10";
$leaderboard_result = mysqli_query($conn, $query);
$rank=1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Employee</title>
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
        <h2>Dashboard</h2>
        <div class="dashboard-section">
            <h3>Upcoming Leave Date : <?php echo $upcoming_leave_date; ?></h3>
        </div>
        <div class="dashboard-section">
            <h3>Last Leave Date: <?php echo $last_leave_date; ?></h3>
        </div>
        <h2>Leave Records</h2>
        <div class="dashboard-section">
            <h3>Total Applied Leaves: <?php echo $total_applied; ?></h3>
        </div>
        <div class="dashboard-section">
            <h3>Accepted Leave Requests: <?php echo $total_accepted; ?></h3>
        </div>
        <div class="dashboard-section">
            <h3>Rejected Leave Requests: <?php echo $total_rejected; ?></h3>
        </div>
        <div class="dashboard-section">
            <h3>Pending Leave Requests: <?php echo $total_pending; ?></h3>
        </div>
        <div class="dashboard-section">
            <h2>Employee Leaderboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($leaderboard_result)) { ?>
                <tr>
                    <td><?php echo $rank++;?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>