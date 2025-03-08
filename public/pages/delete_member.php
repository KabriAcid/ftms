<?php
require __DIR__ . '/../../config/database.php';

session_start();

// Get the member ID from the URL
$memberId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Delete member
try {
    $stmt = $pdo->prepare("DELETE FROM members WHERE id = :id");
    $stmt->execute([':id' => $memberId]);

    if ($stmt->rowCount() > 0) {
        // Member deleted successfully
        header('Location: dashboard.php?message=Member%20deleted%20successfully');
        exit();
    } else {
        
        // Member not found
        header('Location: dashboard.php?message=Member%20not%20found');
        exit();
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while deleting member.');
}
