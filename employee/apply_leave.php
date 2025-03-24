<?php
require '../connection.php';
session_start();

//$employee_email = $_SESSION['user'];
//$employee_id = $_SESSION['employee_id'];
$email = $_SESSION['user'];
$error = '';
$current_date = date("Y-m-d");
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = $_POST['reason'];
    $start_date = $_POST['start_date'];
    $last_date = $_POST['last_date'];
    $status = 'Pending';
    if($start_date > $last_date){
        $error = 'StartDate must be lesser than or equal to the LastDate';
    }
    else if($start_date < $current_date){
        $error = 'Startdate should be Greater than the current date';
    }
    else{
        $query = "INSERT INTO emp_leave (reason, start_date, last_date, email, status) VALUES ('$reason', '$start_date', '$last_date', '$email', '$status')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Leave request submitted successfully.'); window.location.href='leave_status.php';</script>";
        } else {
            echo "<script>alert('Error submitting leave request: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
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
    <div class="container" style="margin-top: 90px;padding:20px;">
        <h2>Apply for Leave</h2>
        <?php if ($error) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea id="reason" name="reason" required></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="last_date">Last Date:</label>
                <input type="date" id="last_date" name="last_date" required>
            </div>
            <button type="submit" class="btn">Apply</button>
        </form>
    </div>
</body>
</html>
