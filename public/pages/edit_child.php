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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $birthDate = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $bloodType = $_POST['blood_type'];
    $status = $_POST['status']; // Alive or dead

    try {
        $stmt = $pdo->prepare("UPDATE children SET name = :name, phone_number = :phone_number, birth_date = :birth_date, gender = :gender, blood_type = :blood_type, status = :status WHERE id = :child_id AND family_id = :family_id");
        $stmt->execute([
            ':name' => $name,
            ':phone_number' => $phone_number,
            ':birth_date' => $birthDate,
            ':gender' => $gender,
            ':blood_type' => $bloodType,
            ':status' => $status,
            ':child_id' => $childId,
            ':family_id' => $familyId
        ]);
        header('Location: child_details.php?id=' . $childId);
        exit();
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die('An error occurred while updating child details.');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Child</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main>
        <div class="container mt-5">
            <h2 class="mb-4 primary">Edit Child</h2>
            <form method="POST" action="" class="box-shadow p-5">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($child['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($child['phone_number']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="birth_date">Birth Date:</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?php echo htmlspecialchars($child['birth_date']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="Male" <?php echo $child['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $child['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $child['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="blood_type">Blood Type:</label>
                    <select id="blood_type" name="blood_type" class="form-control" required>
                        <option value="A+" <?php echo $child['blood_type'] === 'A+' ? 'selected' : ''; ?>>A+</option>
                        <option value="A-" <?php echo $child['blood_type'] === 'A-' ? 'selected' : ''; ?>>A-</option>
                        <option value="B+" <?php echo $child['blood_type'] === 'B+' ? 'selected' : ''; ?>>B+</option>
                        <option value="B-" <?php echo $child['blood_type'] === 'B-' ? 'selected' : ''; ?>>B-</option>
                        <option value="AB+" <?php echo $child['blood_type'] === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                        <option value="AB-" <?php echo $child['blood_type'] === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                        <option value="O+" <?php echo $child['blood_type'] === 'O+' ? 'selected' : ''; ?>>O+</option>
                        <option value="O-" <?php echo $child['blood_type'] === 'O-' ? 'selected' : ''; ?>>O-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status:</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusAlive" value="1" <?php echo $child['status'] == 1 ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="statusAlive">Alive</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusDead" value="0" <?php echo $child['status'] == 0 ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="statusDead">Dead</label>
                    </div>
                </div>
                <button type="submit" class="button">Update Child</button>
            </form>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>