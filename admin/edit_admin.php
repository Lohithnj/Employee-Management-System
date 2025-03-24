<?php
require '../connection.php';
session_start();

// Redirect to login if not logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch admin details
    $query = "SELECT * FROM admin WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if (!$admin) {
        echo "<script>alert('Admin not found.'); window.location.href='manage_admin.php';</script>";
        exit();
    }
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];

    $query = "UPDATE admin SET name='$name', email='$email', gender='$gender', dob='$dob', password='$password' WHERE id=$id";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin updated successfully.'); window.location.href='manage_admin.php';</script>";
    } else {
        echo "<script>alert('Error updating admin: " . mysqli_error($conn) . "'); window.location.href='edit_admin.php?id=$id';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

    <div class="container">
        <h1>Edit Admin</h1>
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
                <select id="gender" name="gender" required>
                    <option value="Male" <?php if($admin['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($admin['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $admin['dob']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $admin['password']; ?>" required>
            </div>
            <button type="submit" name="update">Update Admin</button>
        </form>
    </div>
</body>
</html>
