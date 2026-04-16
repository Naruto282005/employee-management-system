<?php
require_once '../config/database.php';

$pageTitle = "Edit Department";
$error = '';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Department ID is required.");
}

$stmt = $pdo->prepare("SELECT * FROM departments WHERE id = ?");
$stmt->execute([$id]);
$department = $stmt->fetch();

if (!$department) {
    die("Department not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department_name = trim($_POST['department_name'] ?? '');
    $department_code = trim($_POST['department_code'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($department_name === '' || $department_code === '') {
        $error = "Department name and department code are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE departments SET department_name = ?, department_code = ?, description = ? WHERE id = ?");
        try {
            $stmt->execute([$department_name, $department_code, $description ?: null, $id]);
            header("Location: index.php?success=Department updated successfully.");
            exit;
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>

<?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label>Department Name</label>
            <input type="text" name="department_name" value="<?= htmlspecialchars($department['department_name']) ?>" required>
        </div>

        <div class="form-group">
            <label>Department Code</label>
            <input type="text" name="department_code" value="<?= htmlspecialchars($department['department_code']) ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($department['description']) ?></textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>