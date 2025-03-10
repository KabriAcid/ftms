<?php

require __DIR__ . '/../../config/database.php';
session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $familyCode = $_POST["family_code"] ?? '';

    if (empty($familyCode)) {
        echo json_encode(["success" => false, "message" => "Family code is required."]);
        exit;
    }

    // Check if the family code matches the one stored in the session
    if (!isset($_SESSION['family_code']) || $_SESSION['family_code'] !== $familyCode) {
        echo json_encode(["success" => false, "message" => "Invalid family code."]);
        exit;
    }

    // Check if the family code exists in the database
    $stmt = $pdo->prepare("SELECT id FROM families WHERE family_code = ?");
    $stmt->execute([$familyCode]);
    $family = $stmt->fetch();

    if (!$family) {
        echo json_encode(["success" => false, "message" => "Family code not found."]);
        exit;
    }

    // Family code is valid, proceed to registration
    echo json_encode(["success" => true, "message" => "Code verified. Redirecting..."]);
    exit;
}
