<?php
require '../connection.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Delete admin
if (isset($_GET['delete'])) {
    $admin_id = $_GET['delete'];
    $query = "DELETE FROM admin WHERE id = $admin_id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin deleted successfully.'); window.location.href='manage_admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting admin: " . mysqli_error($conn) . "'); window.location.href='manage_admin.php';</script>";
    }
}

// Fetch all admins
$query = "SELECT * FROM admin";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
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
        <h1>Manage Admins</h1>
        <a href="add_admin.php" class="btn">Add New Admin</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($admin = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $admin['id']; ?></td>
                        <td><?php echo $admin['name']; ?></td>
                        <td><?php echo $admin['email']; ?></td>
                        <td><?php echo $admin['gender']; ?></td>
                        <td><?php echo $admin['dob']; ?></td>
                        <td>
                            <a href="edit_admin.php?id=<?php echo $admin['id']; ?>" class="btn">Edit</a>
                            <a href="manage_admin.php?delete=<?php echo $admin['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>