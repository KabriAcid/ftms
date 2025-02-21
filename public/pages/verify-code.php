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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <main>
        <div class="container">
            <div class="container-header">
                <h2>VERIFY FAMILY CODE</h2>
                <p>Enter the family code that has been sent to your email.</p>
            </div>
            <form>
                <div class="form-row">
                    <label for="" class="input-field-label">Family Code</label>
                    <input type="text" id="family_code" name="family_code" placeholder="Verify your family code" class="input-field" required>
                </div>
                <p id="error-message"></p>
                <div class="center">
                    <button type="button" class="button" id="verifyCode">
                        <i class="fa fa-circle-o-notch fa-spin d-none" id="spinner"></i> Send Code
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script src="../js/verify-code.js"></script>
</body>


</html>