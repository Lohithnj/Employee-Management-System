<?php
// change_password.php for employee
require '../connection.php';
session_start();

// Redirect to login if not logged in as employee
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['user'];

    // Check if current password matches
    $query = "SELECT password FROM employee WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row['password'] !== $current_password) {
        $error = 'Current password is incorrect';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New password and confirm password do not match';
    }
    else if($row['password'] == $new_password){
        $error = 'Old and New Password are similar';
    }
    else {
        // Update password
        $query = "UPDATE employee SET password='$new_password' WHERE email='$email'";
        if (mysqli_query($conn, $query)) {
            $success = 'Password changed successfully';
        } else {
            $error = 'Error changing password: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Employee</title>
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
            <h2>Change Password</h2>
            <?php if ($error) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>
            <?php if ($success) { ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php } ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
                <input type="submit" class ="btn" value="Change Password">
            </form>
    </div>
</body>
</html>
