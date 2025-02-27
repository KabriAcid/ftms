<?php
require __DIR__ . '/../../config/database.php';
session_start();
$family_code = $_SESSION['user']['family_code'];
foreach($_SESSION['user'] as $key => $val){
    echo $key . ": " . $val;
    echo "<br>";
}
try {
    $stmt = $pdo->prepare("SELECT * FROM family WHERE family_code = :family_code");
    $stmt->execute([':family_code' => $family_code]);
    $family = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($family) {
        $familyId = $family['id'];
    } else {
        $familyId = 0;
    }
} catch (PDOException $e) {
    echo "Database Error" . $e->getMessage();
    $family = [];
}
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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
                        <div class="card-header">
                            <img src="../img/avatar.jpg" alt="family-pic" class="avatar">
                        </div>
                        <div class="card-body">
                        <h3 class="card-title"><?php echo isset($family['family_name']) ? htmlspecialchars($family['family_name']) : 'No Family Name'; ?></h3>
                        <p class="card-text"><?php echo isset($family['family_code']) ? htmlspecialchars($family['family_code']) : 'No Family Code'; ?></p>

                            <a href="biography.php" class="btn btn-secondary">View Biography</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12 d-flex">
                    <input type="search" name="search" placeholder="Search Family Member" id="search" class="input-field">
                    <button type="button" class="button ml-2" id="button">Search</button>
                </div>
                <div class="response-container">
                    <p class="text-center" id="response"></p>
                </div>
            </div>
            <!-- Children -->
            <div class="row mt-4" id="childrenTable">
                <div class="col-md-12">
                    <h2>Children</h2>
                    <table class="table table-striped">
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

    <script>
        const searchInput = document.getElementById('search');
        const searchButton = document.getElementById('button');
        const responseMessage = document.getElementById('response');

        searchButton.addEventListener('click', function() {
            const searchValue = searchInput.value;

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '../scripts/search-member.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            responseMessage.innerHTML = response.message;
                            document.getElementById('childrenTable').style.display = 'none'
                        } else {
                            responseMessage.innerHTML = response.message;
                            responseMessage.classList.add('error')
                        }
                    } catch (e) {
                        console.error("Invalid JSON response: ", xhr.responseText);
                        responseMessage.innerHTML = "An unexpected error occurred.";
                    }
                }
            };
            xhr.onerror = function() {
                responseMessage.innerHTML = "Network error. Please try again.";
            };
            xhr.send('search=' + encodeURIComponent(searchValue));
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>