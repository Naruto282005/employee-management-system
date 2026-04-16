<?php
if (!isset($pageTitle)) {
    $pageTitle = "Employee Management System";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/employee-management-system/assets/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Employee Management System</h2>
        <a href="/employee-management-system/index.php">Dashboard</a>
        <a href="/employee-management-system/departments/index.php">Departments</a>
        <a href="/employee-management-system/employees/index.php">Employees</a>
        <a href="/employee-management-system/attendance/index.php">Attendance</a>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h1><?= htmlspecialchars($pageTitle) ?></h1>
        </div>