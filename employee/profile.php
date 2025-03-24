<?php
require '../connection.php';
session_start();

// Debugging: Check session variables

// Redirect to login if not logged in as employee
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['user'];

// Fetch employee details
$query = "SELECT * FROM employee WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    echo "Error fetching employee details.";
    exit();
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $update_query = "UPDATE employee SET name = '$name', email = '$email', gender = '$gender', dob = '$dob' WHERE email = '$email'";
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['user'] = $email;  // Update session variable
        echo "<script>alert('Profile updated successfully.'); window.location.href='dashboard.php';</script>";
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
    <title>Employee Profile</title>
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
        <h2>Employee Profile</h2>
        <div class="profile-details">
            <p><strong>Employee ID : </strong> <?php echo $employee['id'];?></p>
            <p><strong>Name : </strong> <?php echo $employee['name']; ?></p>
            <p><strong>Email : </strong> <?php echo $employee['email']; ?></p>
            <p><strong>Gender : </strong> <?php echo $employee['gender']; ?></p>
            <p><strong>Date of Birth : </strong> <?php echo $employee['dob']; ?></p>
            <p><strong>Salary : </strong> <?php echo $employee['salary'];?></p>
            <div class="profile-actions">
                <a href="edit_profile.php" class="btn">Edit Profile</a>
                <a href="change_password.php" class="btn">Change Password</a>
            </div>
        </div>
    </div>

    <!--
    <div class="container">
        <h2>Employee Profile</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $employee['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?php echo ($employee['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($employee['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($employee['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $employee['dob']; ?>" required>
            </div>
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>
    -->
</body>
</html>
