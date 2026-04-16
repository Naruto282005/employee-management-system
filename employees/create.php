<?php
require_once '../config/database.php';

$pageTitle = "Add Employee";
$error = '';

$deptStmt = $pdo->query("SELECT id, department_name FROM departments ORDER BY department_name ASC");
$departments = $deptStmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_no = trim($_POST['employee_no'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $job_title = trim($_POST['job_title'] ?? '');
    $hire_date = trim($_POST['hire_date'] ?? '');
    $salary = trim($_POST['salary'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');
    $department_id = trim($_POST['department_id'] ?? '');

    if (
        $employee_no === '' || $first_name === '' || $last_name === '' ||
        $email === '' || $job_title === '' || $hire_date === '' ||
        $salary === '' || $department_id === ''
    ) {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO employees
            (employee_no, first_name, last_name, email, phone, job_title, hire_date, salary, status, department_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        try {
            $stmt->execute([
                $employee_no,
                $first_name,
                $last_name,
                $email,
                $phone ?: null,
                $job_title,
                $hire_date,
                $salary,
                $status,
                $department_id
            ]);

            header("Location: index.php?success=Employee added successfully.");
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
            <label>Employee Number</label>
            <input type="text" name="employee_no" required>
        </div>

        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone">
        </div>

        <div class="form-group">
            <label>Job Title</label>
            <input type="text" name="job_title" required>
        </div>

        <div class="form-group">
            <label>Hire Date</label>
            <input type="date" name="hire_date" required>
        </div>

        <div class="form-group">
            <label>Salary</label>
            <input type="number" step="0.01" name="salary" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label>Department</label>
            <select name="department_id" required>
                <option value="">Select Department</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?= $department['id'] ?>"><?= htmlspecialchars($department['department_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>