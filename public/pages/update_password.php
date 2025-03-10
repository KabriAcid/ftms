<?php
session_start();
require __DIR__ . '/../../config/database.php';

$message = '';

if (!isset($_SESSION['user'])) {
    header("Location: logout.php");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $userId = $_SESSION['user']['id'];

    if ($newPassword === $confirmPassword) {
        // Update the password
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE members SET password = ? WHERE id = ?");
            $stmt->execute([$hashedPassword, $userId]);
            $message = "Password updated successfully.";
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $message = "An error occurred while updating the password.";
        }
    } else {
        $message = "New password and confirm password do not match.";
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
                <h4>Update Password</h4>
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
                        <h2>Update Password</h2>
                        <p>Change your account password below.</p>
                        <?php if ($message): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <div class="container mt-3 box-shadow">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="new_password">New Password:</label>
                                    <input type="password" placeholder="Password" id="new_password" name="new_password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password:</label>
                                    <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" class="form-control" required>
                                </div>
                                <button type="submit" class="button">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>