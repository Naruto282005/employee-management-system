<?php
require_once 'config/database.php';

$pageTitle = "Dashboard";
include 'includes/header.php';

$departmentCount = $pdo->query("SELECT COUNT(*) AS total FROM departments")->fetch()['total'];
$employeeCount = $pdo->query("SELECT COUNT(*) AS total FROM employees")->fetch()['total'];
$attendanceCount = $pdo->query("SELECT COUNT(*) AS total FROM attendance")->fetch()['total'];
$activeEmployeeCount = $pdo->query("SELECT COUNT(*) AS total FROM employees WHERE status = 'Active'")->fetch()['total'];
?>

<div class="card-grid">
    <div class="card">
        <h3>Total Departments</h3>
        <p><?= htmlspecialchars($departmentCount) ?></p>
    </div>
    <div class="card">
        <h3>Total Employees</h3>
        <p><?= htmlspecialchars($employeeCount) ?></p>
    </div>
    <div class="card">
        <h3>Total Attendance Records</h3>
        <p><?= htmlspecialchars($attendanceCount) ?></p>
    </div>
    <div class="card">
        <h3>Active Employees</h3>
        <p><?= htmlspecialchars($activeEmployeeCount) ?></p>
    </div>
</div>

<div class="table-container">
    <div class="section-header">
        <h2>Recent Attendance</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("
                SELECT attendance.*, employees.first_name, employees.last_name
                FROM attendance
                INNER JOIN employees ON attendance.employee_id = employees.id
                ORDER BY attendance.id DESC
                LIMIT 5
            ");
            $records = $stmt->fetchAll();

            if ($records):
                foreach ($records as $row):
                    $badgeClass = 'badge-present';
                    if ($row['attendance_status'] === 'Late') $badgeClass = 'badge-late';
                    if ($row['attendance_status'] === 'Absent') $badgeClass = 'badge-absent';
                    if ($row['attendance_status'] === 'On Leave') $badgeClass = 'badge-leave';
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['attendance_date']) ?></td>
                    <td><?= htmlspecialchars($row['time_in'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['time_out'] ?? '-') ?></td>
                    <td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['attendance_status']) ?></span></td>
                    <td><?= htmlspecialchars($row['remarks'] ?? '-') ?></td>
                </tr>
            <?php
                endforeach;
            else:
            ?>
                <tr>
                    <td colspan="6">No attendance records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>