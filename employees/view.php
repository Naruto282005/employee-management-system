<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Employee ID is required.");
}

$stmt = $pdo->prepare("
    SELECT employees.*, departments.department_name
    FROM employees
    INNER JOIN departments ON employees.department_id = departments.id
    WHERE employees.id = ?
");
$stmt->execute([$id]);
$employee = $stmt->fetch();

if (!$employee) {
    die("Employee not found.");
}

$pageTitle = "Employee Details";
include '../includes/header.php';
?>

<div class="form-container">
    <div class="form-group"><label>Employee Number</label><input type="text" value="<?= htmlspecialchars($employee['employee_no']) ?>" readonly></div>
    <div class="form-group"><label>Full Name</label><input type="text" value="<?= htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) ?>" readonly></div>
    <div class="form-group"><label>Email</label><input type="text" value="<?= htmlspecialchars($employee['email']) ?>" readonly></div>
    <div class="form-group"><label>Phone</label><input type="text" value="<?= htmlspecialchars($employee['phone'] ?? '-') ?>" readonly></div>
    <div class="form-group"><label>Job Title</label><input type="text" value="<?= htmlspecialchars($employee['job_title']) ?>" readonly></div>
    <div class="form-group"><label>Hire Date</label><input type="text" value="<?= htmlspecialchars($employee['hire_date']) ?>" readonly></div>
    <div class="form-group"><label>Salary</label><input type="text" value="<?= htmlspecialchars($employee['salary']) ?>" readonly></div>
    <div class="form-group"><label>Status</label><input type="text" value="<?= htmlspecialchars($employee['status']) ?>" readonly></div>
    <div class="form-group"><label>Department</label><input type="text" value="<?= htmlspecialchars($employee['department_name']) ?>" readonly></div>

    <div class="actions">
        <a href="edit.php?id=<?= $employee['id'] ?>" class="btn btn-warning">Edit</a>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>