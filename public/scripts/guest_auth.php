<?php
require __DIR__ . '/../../config/database.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $familyCode = trim($_POST["family_code"]);

    if (empty($familyCode)) {
        echo json_encode(["success" => false, "message" => "Family code is required."]);
        exit;
    }
    try {
        $stmt = $pdo->prepare("SELECT * FROM families WHERE family_code = :family_code");
        $stmt->execute(["family_code" => $familyCode]);
        $family = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        throw $th->getMessage();
    }
    
    if ($family) {
        session_start();
        $_SESSION["family_id"] = $family['id'];
        echo json_encode(["success" => true]);
    } else {

        echo json_encode(["success" => false, "message" => "Invalid family code. Generate new one."]);
    }
}
