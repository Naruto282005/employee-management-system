<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Department ID is required.");
}

try {
    $stmt = $pdo->prepare("DELETE FROM departments WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?success=Department deleted successfully.");
    exit;
} catch (PDOException $e) {
    header("Location: index.php?success=Cannot delete department because it may still be assigned to employees.");
    exit;
}