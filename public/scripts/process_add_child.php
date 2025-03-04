<?php
require __DIR__ . '/../../config/database.php';
header("Content-Type: application/json");

session_start();
$familyId = $_SESSION['family_id'] = 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? '');
    $phone_number = trim($_POST["phone_number"] ?? '');
    $birthDate = trim($_POST["birth_date"] ?? '');
    $gender = trim($_POST["gender"] ?? '');

    try {
        $stmt = $pdo->prepare("INSERT INTO children (family_id, name, phone_number, birth_date, gender, created_at) VALUES (:family_id, :name, :phone_number, :birth_date, :gender, NOW())");
        $stmt->execute([
            ':family_id' => $familyId,
            ':name' => $name,
            ':phone_number' => $phone_number,
            ':birth_date' => $birthDate,
            ':gender' => $gender,
        ]);

        echo json_encode(["success" => true, "message" => "Child added successfully."]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "An error occurred while adding the child."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
