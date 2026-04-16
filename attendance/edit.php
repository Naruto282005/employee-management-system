<?php
require_once '../config/database.php';

$pageTitle = "Edit Attendance";
$error = '';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Attendance ID is required.");
}

$empStmt = $pdo->query("SELECT id, employee_no, first_name, last_name FROM employees ORDER BY first_name ASC");
$employees = $empStmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM attendance WHERE id = ?");
$stmt->execute([$id]);
$record = $stmt->fetch();

if (!$record) {
    die("Attendance record not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = trim($_POST['employee_id'] ?? '');
    $attendance_date = trim($_POST['attendance_date'] ?? '');
    $time_in = trim($_POST['time_in'] ?? '');
    $time_out = trim($_POST['time_out'] ?? '');
    $attendance_status = trim($_POST['attendance_status'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    if ($employee_id === '' || $attendance_date === '' || $attendance_status === '') {
        $error = "Employee, attendance date, and attendance status are required.";
    } else {
        $stmt = $pdo->prepare("
            UPDATE attendance
            SET employee_id = ?, attendance_date = ?, time_in = ?, time_out = ?, attendance_status = ?, remarks = ?
            WHERE id = ?
        ");

        try {
            $stmt->execute([
                $employee_id,
                $attendance_date,
                $time_in ?: null,
                $time_out ?: null,
                $attendance_status,
                $remarks ?: null,
                $id
            ]);

            header("Location: index.php?success=Attendance updated successfully.");
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
            <label>Employee</label>
            <select name="employee_id" required>
                <option value="">Select Employee</option>
                <?php foreach ($employees as $employee): ?>
                    <option value="<?= $employee['id'] ?>" <?= $record['employee_id'] == $employee['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($employee['employee_no'] . ' - ' . $employee['first_name'] . ' ' . $employee['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Attendance Date</label>
            <input type="date" name="attendance_date" value="<?= htmlspecialchars($record['attendance_date']) ?>" required>
        </div>

        <div class="form-group">
            <label>Time In</label>
            <input type="time" name="time_in" value="<?= htmlspecialchars($record['time_in']) ?>">
        </div>

        <div class="form-group">
            <label>Time Out</label>
            <input type="time" name="time_out" value="<?= htmlspecialchars($record['time_out']) ?>">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="attendance_status" required>
                <option value="Present" <?= $record['attendance_status'] === 'Present' ? 'selected' : '' ?>>Present</option>
                <option value="Absent" <?= $record['attendance_status'] === 'Absent' ? 'selected' : '' ?>>Absent</option>
                <option value="Late" <?= $record['attendance_status'] === 'Late' ? 'selected' : '' ?>>Late</option>
                <option value="On Leave" <?= $record['attendance_status'] === 'On Leave' ? 'selected' : '' ?>>On Leave</option>
            </select>
        </div>

        <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks"><?= htmlspecialchars($record['remarks']) ?></textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>