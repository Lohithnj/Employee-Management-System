<?php
require '../connection.php';
session_start();

// Redirect to login if not logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch leave requests
$current_date = date("Y-m-d");
$query = "SELECT * FROM emp_leave WHERE status='Pending' AND start_date>='$current_date'";
$result = mysqli_query($conn, $query);

if (isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == 'accept') {
        $status = 'Accepted';
    } elseif ($action == 'reject') {
        $status = 'Rejected';
    } else {
        $status = 'Pending';
    }

    $update_query = "UPDATE emp_leave SET status='$status' WHERE id='$id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Leave request has been $status.'); window.location.href='manage_leave.php';</script>";
    } else {
        echo "<script>alert('Error updating leave status: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employee Leave</title>
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
        <h2>Manage Employee Leave</h2>
        <table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Employee Email</th>
                    <th>Reason</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Days</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $start_date = new DateTime($row['start_date']);
                        $end_date = new DateTime($row['last_date']);
                        $interval = $start_date->diff($end_date);
                        $total_days = $interval->days + 1;
                        echo "<tr>
                                <td>{$sno}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['reason']}</td>
                                <td>{$row['start_date']}</td>
                                <td>{$row['last_date']}</td>
                                <td>{$total_days}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <form method='POST' action='' style='display:inline-block;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' name='action' value='accept' class='btn'>Accept</button>
                                    </form>
                                    <form method='POST' action='' style='display:inline-block;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' name='action' value='reject' class='btn'>Reject</button>
                                    </form>
                                </td>
                            </tr>";
                        $sno++;
                    }
                } else {
                    echo "<tr><td colspan='8'>No leave requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
