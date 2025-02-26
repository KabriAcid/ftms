<?php
require __DIR__ . '/../../config/database.php';

session_start();
$familyId = $_SESSION['family_id'] = 1; // Assuming family_id is stored in session

// Fetch family overview
try {
    $stmt = $pdo->prepare("SELECT * FROM family WHERE id = :family_id");
    $stmt->execute([':family_id' => $familyId]);
    $family = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $family = [];
}

// Fetch children
try {
    $stmt = $pdo->prepare("SELECT * FROM children WHERE family_id = :family_id");
    $stmt->execute([':family_id' => $familyId]);
    $children = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $children = [];
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
    <style>
        td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?> <!-- Include the navbar -->

    <main>
        <div class="container mt-5">
            <!-- Family Overview -->
            <div class="row">
                <div class="col-md-12">
                    <h2>Family Overview</h2>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($family['family_name']); ?></h3>
                            <p class="card-text"><?php echo htmlspecialchars($family['family_code']); ?></p>
                            <a href="biography.php" class="btn btn-secondary">View Biography</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Children -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h2>Children</h2>
                    <table class="table table-striped" id="childrenTable">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Birth Date</th>
                                <th>Gender</th>
                                <th>Blood Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($children as $child) : ?>
                                <tr>
                                    <td><img src="../pages/uploads/avatar.jpg<?php htmlspecialchars($child['photo']); ?>" alt="Profile Photo" class="img-thumbnail" width="50"></td>
                                    <td><?php echo htmlspecialchars($child['name']); ?></td>
                                    <td><?php echo htmlspecialchars($child['birth_date']); ?></td>
                                    <td><?php echo htmlspecialchars($child['gender']); ?></td>
                                    <td><?php echo htmlspecialchars($child['blood_type']); ?></td>
                                    <td><?php echo $child['status'] == 1 ? 'Alive' : 'Dead'; ?></td>
                                    <td>
                                        <a href="child_details.php?id=<?php echo $child['id']; ?>" class="badge badge-info">View</a>
                                        <a href="edit_child.php?id=<?php echo $child['id']; ?>" class="badge badge-warning">Edit</a>
                                        <a href="delete_child.php?id=<?php echo $child['id']; ?>" class="badge badge-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($children)) : ?>
                                <tr>
                                    <td colspan="7">No children found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery

    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>