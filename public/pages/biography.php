<?php
require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user'])) {
    header("Location: logout.php");
}

session_start();

$family_code = $_SESSION['user']['family_code'];

try {
    $stmt = $pdo->prepare("SELECT * FROM family WHERE family_code = :family_code");
    $stmt->execute([':family_code' => $family_code]);
    $family = $stmt->fetch(PDO::FETCH_ASSOC);
    $familyId = $family['id'];
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $family = [];
}

// Fetch family biography
try {
    $stmt = $pdo->prepare("SELECT * FROM family_biography WHERE family_id = :family_id");
    $stmt->execute([':family_id' => $familyId]);
    $biography = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$biography) {
        die('Family biography not found.');
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching family biography.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Biography</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include_once '../partials/navbar.php'; ?>
    <main>
        <div class="container mt-5">
            <h2 class="mb-4">Family Biography</h2>
            <div class="card mt-4">
                <div class="card-body">
                    <h3 class="card-title">Biography of the Family</h3>
                    <p class="card-text"><?php echo htmlspecialchars($biography['biography']); ?></p>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>