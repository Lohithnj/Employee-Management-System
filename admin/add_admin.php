<?php
// add_admin.php
require '../connection.php';
session_start();

// Redirect to login if not logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    if (empty($name) || empty($email) || empty($password) || empty($dob) || empty($gender)) {
        $error = 'Please fill all the fields';
    } else {
        $query = "INSERT INTO admin (name, email, password, dob, gender) VALUES ('$name', '$email', '$password', '$dob', '$gender')";
        if (mysqli_query($conn, $query)) {
            $success = 'Admin added successfully';
        } else {
            $error = 'Error adding admin: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin - Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2>Add Admin</h2>
            <?php if ($error) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>
            <?php if ($success) { ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php } ?>
            <form method="POST" action="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <input type="submit" value="Add Admin">
            </form>
        </div>
    </div>
</body>
</html>
