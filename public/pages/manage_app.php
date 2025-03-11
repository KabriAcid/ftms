<?php
session_start();
require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user']) && $_SESSION['role'] != 'Admin') {
    header("Location: logout.php");
} else {
    $user_id = $_SESSION['user']['id'];
}

$message = '';
// Ensure the user is logged in and is an admin
$familyId = $_SESSION['user']['family_id'];

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_members'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM members WHERE family_id = :family_id && id != :id");
            $stmt->execute([':family_id' => $familyId, ':id' => $user_id]);
            $message = "All family members have been deleted successfully.";
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $message = "An error occurred while deleting family members.";
        }
    } elseif (isset($_POST['delete_events'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM events WHERE family_id = :family_id");
            $stmt->execute([':family_id' => $familyId]);
            $message = "All events have been deleted successfully.";
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $message = "An error occurred while deleting events.";
        }
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
                <h4>Manage Family</h4>
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
                        <h2>Manage App</h2>
                        <p>Here you can choose to manage your family as the admin.</p>
                        <?php if ($message): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <button type="submit" name="delete_members" class="btn btn-danger">Delete All Family Members</button>
                            <button type="submit" name="delete_events" class="btn btn-danger">Delete All Events</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>