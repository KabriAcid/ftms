<?php
require __DIR__ . '/../../config/database.php';

session_start();
$familyId = $_SESSION['family_id']; // Assuming family_id is stored in session

// Fetch family members
try {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE family_id = :family_id");
    $stmt->execute([':family_id' => $familyId]);
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $members = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Management System Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Family Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Family Members</h2>
                <table class="table table-striped" id="membersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Birth Date</th>
                            <th>Relationship</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['name']); ?></td>
                                <td><?php echo htmlspecialchars($member['birth_date']); ?></td>
                                <td><?php echo htmlspecialchars($member['relationship']); ?></td>
                                <td>
                                    <!-- Add any action buttons like Edit or Delete here -->
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($members)) : ?>
                            <tr>
                                <td colspan="4">No members found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/dashboard.js"></script>
</body>

</html>