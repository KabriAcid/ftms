<?php

require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../helpers/send-mail.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $familyName = trim($_POST["family_name"] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email address."]);
        exit;
    }

    if (empty($familyName) || !preg_match("/^[a-zA-Z ]+$/", $familyName)) {
        echo json_encode(["success" => false, "message" => "Invalid family name."]);
        exit;
    }

    // Generate Family Code
    function generateFamilyCode($familyName)
    {
        $prefix = strtoupper(substr(preg_replace("/[^a-zA-Z]/", "", $familyName), 0, 4)); // Remove non-letters

        while (strlen($prefix) < 4) {
            $prefix .= chr(rand(65, 90));
        }

        $randomCode = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4)); // Generate 4 random alphanumeric characters

        return $prefix . '-' . $randomCode;
    }

    $familyCode = generateFamilyCode($familyName);

    try {
        // Store Family Code in Database
        $stmt = $pdo->prepare("INSERT INTO family (family_name, family_code) VALUES (?, ?)");
        $stmt->execute([$familyName, $familyCode]);

        // Send Family Code Email
        $subject = "Your Family Code";
        $body = "
            <div style='font-family: Arial, sans-serif; max-width: 500px; margin: auto; border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; background-color: #f9f9f9;'>
                <h2 style='color: #138e00;'>Family Code Registration</h2>
                <p style='font-size: 16px; color: #555;'>Use the family code below to register your family:</p>
                <h1 style='font-size: 28px; font-weight: bold; background: #138e00; color: #fff; padding: 10px; border-radius: 5px; display: inline-block;'>$familyCode</h1>
                <p style='color: #888; font-size: 14px;'>Keep this family code safe and share it with family members.</p>
                <hr style='margin: 20px 0; border: none; border-top: 1px solid #ddd;'>
                <p style='font-size: 12px; color: #999;'>If you did not request this, please ignore this email.</p>
            </div>
        ";

        sendMail($email, $subject, $body);

        session_start();
        $_SESSION['family_code'] = $familyCode;

        echo json_encode(["success" => true, "message" => "Family code has been sent.", "redirect" => "verify-code.php"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
