<?php
require_once '../config/database.php';

$pageTitle = "Attendance";
include '../includes/header.php';

$stmt = $pdo->query("
    SELECT attendance.*, employees.employee_no, employees.first_name, employees.last_name
    FROM attendance
    INNER JOIN employees ON attendance.employee_id = employees.id
    ORDER BY attendance.id DESC
");
$records = $stmt->fetchAll();
?>

<?php if (isset($_GET['success'])): ?>
    <div class="message success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="section-header">
        <h2>Attendance Records</h2>
        <a href="create.php" class="btn btn-primary">Add Attendance</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee No</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
                <th>Remarks</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($records): ?>
                <?php foreach ($records as $row): ?>
                    <?php
                    $badgeClass = 'badge-present';
                    if ($row['attendance_status'] === 'Late') $badgeClass = 'badge-late';
                    if ($row['attendance_status'] === 'Absent') $badgeClass = 'badge-absent';
                    if ($row['attendance_status'] === 'On Leave') $badgeClass = 'badge-leave';
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['employee_no']) ?></td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['attendance_date']) ?></td>
                        <td><?= htmlspecialchars($row['time_in'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['time_out'] ?? '-') ?></td>
                        <td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['attendance_status']) ?></span></td>
                        <td><?= htmlspecialchars($row['remarks'] ?? '-') ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Delete this attendance record?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No attendance records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>