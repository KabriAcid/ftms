<?php
require __DIR__ . '/../../config/database.php';

session_start();
$familyId = $_SESSION['family_id']; // Assuming family_id is stored in session

// Get child ID from GET parameters
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Child ID not provided.');
}

$childId = $_GET['id'];

// Fetch child details
try {
    $stmt = $pdo->prepare("SELECT * FROM children WHERE id = :child_id AND family_id = :family_id");
    $stmt->execute([':child_id' => $childId, ':family_id' => $familyId]);
    $child = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$child) {
        die('Child not found or you do not have permission to view this child.');
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching child details.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include_once __DIR__ . '/../partials/navbar.php' ?>
    <main>
        <div class="container mt-5">
            <h2>Child Details</h2>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($child['name']); ?></h3>
                    <p class="card-text">
                        <strong>Birth Date:</strong> <?php echo htmlspecialchars($child['birth_date']); ?><br>
                        <strong>Gender:</strong> <?php echo htmlspecialchars($child['gender']); ?><br>
                        <strong>Blood Type:</strong> <?php echo htmlspecialchars($child['blood_type']); ?><br>
                        <strong>Status:</strong> <?php echo $child['status'] == 1 ? 'Alive' : 'Dead'; ?>
                    </p>
                    <a href="edit_child.php?id=<?php echo $child['id']; ?>" class="badge badge-primary">Edit</a>
                    <a href="delete_child.php?id=<?php echo $child['id']; ?>" class="badge badge-danger">Delete</a>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>