<?php
require '../connection.php';
session_start();

// Redirect to login if not logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch admin details
$admin_email = $_SESSION['user'];
$query = "SELECT * FROM admin WHERE email='$admin_email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $admin = mysqli_fetch_assoc($result);
} else {
    echo "Admin details not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
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
        <h2>Admin Profile</h2>
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo $admin['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $admin['email']; ?></p>
            <p><strong>Gender:</strong> <?php echo $admin['gender']; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $admin['dob']; ?></p>
            <div class="profile-actions">
                <a href="edit_profile.php" class="btn">Edit Profile</a>
                <a href="change_password.php" class="btn">Change Password</a>
            </div>
        </div>
    </div>
</body>
</html>
