<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Attendance ID is required.");
}

$stmt = $pdo->prepare("DELETE FROM attendance WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php?success=Attendance deleted successfully.");
exit;