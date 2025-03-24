<?php
require '../connection.php';
session_start();

// Redirect to login if not logged in as employee
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

// Fetch all employees
$query = "SELECT id, name, email, gender, dob FROM employee";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
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
        <h2>View Employees</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($employee = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $employee['id'] . "</td>";
                        echo "<td>" . $employee['name'] . "</td>";
                        echo "<td>" . $employee['email'] . "</td>";
                        echo "<td>" . $employee['gender'] . "</td>";
                        echo "<td>" . $employee['dob'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No employees found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
