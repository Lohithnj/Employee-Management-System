<?php
require '../connection.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the employee
    $query = "DELETE FROM employee WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Employee deleted successfully.'); window.location.href='manage_employee.php';</script>";
    } else {
        echo "<script>alert('Error deleting employee: " . mysqli_error($conn) . "'); window.location.href='manage_employee.php';</script>";
    }
} else {
    header("Location: manage_employee.php");
}
?>
