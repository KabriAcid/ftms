<?php
require __DIR__ . '/../../config/database.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $family_code = trim($_POST["family_code"]);

    if (empty($family_code)) {
        echo json_encode(["success" => false, "message" => "Family code is required."]);
        exit;
    }
    try {
        $stmt = $pdo->prepare("SELECT * FROM families WHERE family_code = :family_code");
        $stmt->execute(["family_code" => $family_code]);
        $family = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        throw $th->getMessage();
    }
    
    if ($family) {
        session_start();
        $_SESSION["family_code"] = $family['family_code'];
        echo json_encode(["success" => true]);
    } else {

        echo json_encode(["success" => false, "message" => "Invalid family code. Generate new one."]);
    }
}
