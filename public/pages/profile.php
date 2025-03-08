<?php
require __DIR__ . '/../../config/database.php';

session_start();
$userId = $_SESSION['user']['id']; // Assuming user_id is stored in session
// Fetch user details
$message = false;
try {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die('User not found.');
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching user details.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $relationship = $_POST['relationship'];
    $birthDate = $_POST['birth_date'];
    $address = $_POST['address'];
    $profilePicture = $user['profile_picture']; // Default to the current profile picture

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            $profilePicture = $uploadFile;
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE members SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, gender = :gender, relationship = :relationship, birth_date = :birth_date, address = :address, profile_picture = :profile_picture WHERE id = :user_id");
        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':phone' => $phone,
            ':gender' => $gender,
            ':relationship' => $relationship,
            ':birth_date' => $birthDate,
            ':address' => $address,
            ':profile_picture' => $profilePicture,
            ':user_id' => $userId
        ]);

        // Update the session variables
        $_SESSION['user']['first_name'] = $firstName;
        $_SESSION['user']['last_name'] = $lastName;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['gender'] = $gender;
        $_SESSION['user']['relationship'] = $relationship;
        $_SESSION['user']['birth_date'] = $birthDate;
        $_SESSION['user']['address'] = $address;
        $_SESSION['user']['profile_picture'] = $profilePicture;

        $message = true;

        header('Location: profile.php');
        exit();
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die('An error occurred while updating profile.');
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
                <h4 class="mb-3 py-4 font-weight-bold">Profile</h4>
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
                        <h2>Profile</h2>
                        <p>You may choose to edit your profile.</p>
                    </div>
                </div>
                <!-- -->
                <div class="container mt-5 box-shadow">
                    <h2>Profile</h2>
                    <?php
                    if ($message):
                        echo "<p class='text-center text-success'>Profile Updated Successfully</p>";
                    endif;
                    ?>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture:</label>
                            <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                            <?php if ($user['profile_picture']): ?>
                                <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="img-thumbnail mt-2" width="150">
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="Male" <?php if ($user['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($user['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($user['gender'] === 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="relationship">Relationship:</label>
                            <select id="relationship" name="relationship" class="form-control" required>
                                <option value="Father" <?php if ($user['relationship'] === 'Father') echo 'selected'; ?>>Father</option>
                                <option value="Mother" <?php if ($user['relationship'] === 'Mother') echo 'selected'; ?>>Mother</option>
                                <option value="Brother" <?php if ($user['relationship'] === 'Brother') echo 'selected'; ?>>Brother</option>
                                <option value="Sister" <?php if ($user['relationship'] === 'Sister') echo 'selected'; ?>>Sister</option>
                                <option value="Uncle" <?php if ($user['relationship'] === 'Uncle') echo 'selected'; ?>>Uncle</option>
                                <option value="Aunt" <?php if ($user['relationship'] === 'Aunt') echo 'selected'; ?>>Aunt</option>
                                <option value="Niece" <?php if ($user['relationship'] === 'Niece') echo 'selected'; ?>>Niece</option>
                                <option value="Nephew" <?php if ($user['relationship'] === 'Nephew') echo 'selected'; ?>>Nephew</option>
                                <option value="Cousin" <?php if ($user['relationship'] === 'Cousin') echo 'selected'; ?>>Cousin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birth_date">Birth Date:</label>
                            <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?php echo htmlspecialchars($user['birth_date']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea id="address" name="address" class="form-control"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>
                        <button type="submit" class="button">Update Profile</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>