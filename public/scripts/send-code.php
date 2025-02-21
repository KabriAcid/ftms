<?php

require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../helpers/send-mail.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $familyName = $_POST["family_name"] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email address."]);
        exit;
    }

    if (empty($familyName)) {
        echo json_encode(["success" => false, "message" => "Family name is required."]);
        exit;
    }

    // Generate Family Code
    function generateFamilyCode($familyName)
    {
        $prefix = strtoupper(substr($familyName, 0, 4));

        while (strlen($prefix) < 4) {
            $prefix .= chr(rand(65, 90)); // Fill missing letters with uppercase letters
        }

        $randomCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4)); // Generate 4 random alphanumeric characters

        return $prefix . '-' . $randomCode;
    }

    $familyCode = generateFamilyCode($familyName);

    try {
        // Store Family Code in Database (Ensure unique family codes)
        $stmt = $pdo->prepare("INSERT INTO family (family_name, family_code) VALUES (?, ?)");
        $stmt->execute([$familyName, $familyCode]);

        // Send Family Code Email
        $subject = "Your Family Code";
        $body = "
            <div style='font-family: Arial, sans-serif; max-width: 500px; margin: auto; border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; background-color: #f9f9f9;'>
                <h2 style='color: #94241E;'>Family Code Registration</h2>
                <p style='font-size: 16px; color: #555;'>Use the family code below to register your family:</p>
                <h1 style='font-size: 28px; font-weight: bold; background: #94241E; color: #fff; padding: 10px; border-radius: 5px; display: inline-block;'>$familyCode</h1>
                <p style='color: #888; font-size: 14px;'>Keep this family code safe and share it with family members.</p>
                <hr style='margin: 20px 0; border: none; border-top: 1px solid #ddd;'>
                <p style='font-size: 12px; color: #999;'>If you did not request this, please ignore this email.</p>
            </div>
        ";

        sendMail($email, $subject, $body);

        session_start();
        $_SESSION['family_code'] = $familyCode;

        echo json_encode(["success" => true, "message" => "Family code has been sent.", "redirect" => "register.php"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
