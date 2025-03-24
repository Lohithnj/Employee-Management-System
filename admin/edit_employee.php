<?php
require '../connection.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch employee details
$employee_id = $_GET['id'];
$query = "SELECT * FROM employee WHERE id='$employee_id'";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $salary = $_POST['salary'];

    $update_query = "UPDATE employee SET name='$name', email='$email', gender='$gender', dob='$dob', salary='$salary' WHERE id='$employee_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Employee details updated successfully.'); window.location.href='manage_employee.php';</script>";
    } else {
        echo "<script>alert('Error updating employee details: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Employee</h2>
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
                <input type="text" id="gender" name="gender" value="<?php echo $employee['gender']; ?>">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $employee['dob']; ?>">
            </div>
            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" value="<?php echo $employee['salary']; ?>" required>
            </div>
            <button type="submit" class="btn">Update Employee</button>
        </form>
    </div>
</body>
</html>
