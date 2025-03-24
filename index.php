<?php
require 'connection.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'admin') {
        $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    } else {
        $query = "SELECT * FROM employee WHERE email='$email' AND password='$password'";
    }

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $_SESSION['user'] = $row['email'];
        $_SESSION['role'] = $role;
        if ($role == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: employee/dashboard.php");
        }
        exit();
    } else {
        $error = 'Invalid email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Login - Employee Management System</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
        <div class="container">
                <h1>Employee Management System</h1>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form method="POST" action="">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="role">Login as:</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                </select>

                <input type="submit" value="Login">

                <?php if ($error) { ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</body>
</html>