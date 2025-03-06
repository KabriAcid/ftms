<?php
require __DIR__ . '/../../config/database.php';

session_start();

// Get the member ID from the URL
$memberId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = false;

// Fetch member details
try {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE id = :id");
    $stmt->execute([':id' => $memberId]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$member) {
        die('Member not found.');
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching member details.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birth_date'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $profilePicture = $member['profile_picture']; // Default to the current profile picture

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            $profilePicture = $uploadFile;
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE members SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, gender = :gender, birth_date = :birth_date, address = :address, status = :status, profile_picture = :profile_picture WHERE id = :id");
        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':phone' => $phone,
            ':gender' => $gender,
            ':birth_date' => $birthDate,
            ':address' => $address,
            ':status' => $status,
            ':profile_picture' => $profilePicture,
            ':id' => $memberId
        ]);

        $message = true;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die('An error occurred while updating member details.');
    }
}
?>
<?php require __DIR__ . '/../partials/header.php'; ?>

<body class="dashboard-body">
    <!-- Sidebar (your existing markup) -->
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>
    <!-- Main Container -->
    <div id="main-container">
        <!-- Navbar -->
        <header id="navbar">
            <div class="navbar-content">
                <h4>Edit</h4>
                <div class="user-info">
                    <!-- Avatar Placeholder -->
                    <a href="profile.php" class="text-light">
                        <span class="user-name mx-2">
                            <?php
                            if (isset($_SESSION['user']['first_name'])) {
                                echo "Hi, " . $_SESSION['user']['first_name'];
                            } else {
                                echo 'Guest';
                            }
                            ?>
                        </span>
                        <img src="<?php echo $_SESSION['user']['profile_picture'] ?? 'uploads/avatar.jpg'; ?>" alt="Avatar" class="user-avatar">
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main id="content">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2>Edit Member Details</h2>
                        <p>Update the details of the selected member.</p>
                    </div>
                </div>
                <!-- Form to edit member details -->
                <div class="container mt-5 box-shadow">
                    <h2>Edit Member</h2>
                    <?php
                    if ($message):
                        echo "<p class='text-center text-success'>Member Details Updated Successfully</p>";
                    endif;
                    ?>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($member['first_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($member['last_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($member['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($member['phone']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture:</label>
                            <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                            <?php if ($member['profile_picture']): ?>
                                <img src="<?php echo htmlspecialchars($member['profile_picture']); ?>" alt="Profile Picture" class="img-thumbnail mt-2" width="150">
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="Male" <?php if ($member['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($member['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($member['gender'] === 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birth_date">Birth Date:</label>
                            <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?php echo htmlspecialchars($member['birth_date']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea id="address" name="address" class="form-control"><?php echo htmlspecialchars($member['address']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="1" <?php if ($member['status'] == 1) echo 'selected'; ?>>Alive</option>
                                <option value="0" <?php if ($member['status'] == 0) echo 'selected'; ?>>Deceased</option>
                            </select>
                        </div>
                        <button type="submit" class="button">Update Member</button>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>