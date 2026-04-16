<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Employee ID is required.");
}

$stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php?success=Employee deleted successfully.");
exit;