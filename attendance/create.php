<?php
require_once '../config/database.php';

$pageTitle = "Add Attendance";
$error = '';

$empStmt = $pdo->query("SELECT id, employee_no, first_name, last_name FROM employees ORDER BY first_name ASC");
$employees = $empStmt->fetchAll();

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
            INSERT INTO attendance (employee_id, attendance_date, time_in, time_out, attendance_status, remarks)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        try {
            $stmt->execute([
                $employee_id,
                $attendance_date,
                $time_in ?: null,
                $time_out ?: null,
                $attendance_status,
                $remarks ?: null
            ]);

            header("Location: index.php?success=Attendance added successfully.");
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
                    <option value="<?= $employee['id'] ?>">
                        <?= htmlspecialchars($employee['employee_no'] . ' - ' . $employee['first_name'] . ' ' . $employee['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Attendance Date</label>
            <input type="date" name="attendance_date" required>
        </div>

        <div class="form-group">
            <label>Time In</label>
            <input type="time" name="time_in">
        </div>

        <div class="form-group">
            <label>Time Out</label>
            <input type="time" name="time_out">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="attendance_status" required>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Late">Late</option>
                <option value="On Leave">On Leave</option>
            </select>
        </div>

        <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks"></textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>