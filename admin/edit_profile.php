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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $update_query = "UPDATE admin SET name='$name', email='$email', gender='$gender', dob='$dob' WHERE email='$admin_email'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profile updated successfully.'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/header-styles.css">
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</head>
<body>
<header>
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
    </header>
    <div class="container">
        <h2>Edit Profile</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $admin['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo $admin['gender']; ?>">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $admin['dob']; ?>">
            </div>
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>
</body>
</html>
