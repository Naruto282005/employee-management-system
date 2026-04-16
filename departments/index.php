<?php
require_once '../config/database.php';

$pageTitle = "Departments";
include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM departments ORDER BY id DESC");
$departments = $stmt->fetchAll();
?>

<?php if (isset($_GET['success'])): ?>
    <div class="message success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="section-header">
        <h2>Department List</h2>
        <a href="create.php" class="btn btn-primary">Add Department</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Department Code</th>
                <th>Description</th>
                <th>Created At</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($departments): ?>
                <?php foreach ($departments as $department): ?>
                    <tr>
                        <td><?= htmlspecialchars($department['id']) ?></td>
                        <td><?= htmlspecialchars($department['department_name']) ?></td>
                        <td><?= htmlspecialchars($department['department_code']) ?></td>
                        <td><?= htmlspecialchars($department['description'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($department['created_at']) ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $department['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $department['id'] ?>" class="btn btn-danger" onclick="return confirm('Delete this department?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No departments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>