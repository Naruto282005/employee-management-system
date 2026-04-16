<?php
require_once '../config/database.php';

$pageTitle = "Employees";
include '../includes/header.php';

$stmt = $pdo->query("
    SELECT employees.*, departments.department_name
    FROM employees
    INNER JOIN departments ON employees.department_id = departments.id
    ORDER BY employees.id DESC
");
$employees = $stmt->fetchAll();
?>

<?php if (isset($_GET['success'])): ?>
    <div class="message success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="section-header">
        <h2>Employee List</h2>
        <a href="create.php" class="btn btn-primary">Add Employee</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Job Title</th>
                <th>Department</th>
                <th>Status</th>
                <th width="250">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($employees): ?>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= htmlspecialchars($employee['id']) ?></td>
                        <td><?= htmlspecialchars($employee['employee_no']) ?></td>
                        <td><?= htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) ?></td>
                        <td><?= htmlspecialchars($employee['email']) ?></td>
                        <td><?= htmlspecialchars($employee['phone'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($employee['job_title']) ?></td>
                        <td><?= htmlspecialchars($employee['department_name']) ?></td>
                        <td>
                            <span class="badge <?= $employee['status'] === 'Active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= htmlspecialchars($employee['status']) ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="view.php?id=<?= $employee['id'] ?>" class="btn btn-primary">View</a>
                            <a href="edit.php?id=<?= $employee['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $employee['id'] ?>" class="btn btn-danger" onclick="return confirm('Delete this employee?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No employees found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>