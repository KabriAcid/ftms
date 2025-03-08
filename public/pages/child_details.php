<?php
require __DIR__ . '/../../config/database.php';

session_start();

// Get the member ID from the URL
$memberId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch member details
try {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE id = :id");
    $stmt->execute([':id' => $memberId]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$member) {
        die('Member not found.');
        header("Location: dashboard.php?message=Member%20not%20found");
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching member details.');
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
                <h4>Details</h4>
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
                        <h2>Member details</h2>
                        <p>Here, you can view a member's profile.</p>
                    </div>
                </div>
                <!-- -->
                <!-- Member Details -->
                <div class="container mt-5 box-shadow">
                    <h3><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></h3>
                    <div class="row">
                        <div class="col-md-3">
                            <?php if ($member['profile_picture']): ?>
                                <img src="<?php echo htmlspecialchars($member['profile_picture']); ?>" alt="Profile Picture" class="img-thumbnail" style="width: 150px; height: 150px;">
                            <?php else: ?>
                                <img src="uploads/user.png" alt="Profile Picture" class="img-thumbnail" style="width: 150px; height: 150px;">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-striped">
                                <tr>
                                    <th>First Name:</th>
                                    <td><?php echo htmlspecialchars($member['first_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Last Name:</th>
                                    <td><?php echo htmlspecialchars($member['last_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?php echo htmlspecialchars($member['email']); ?></td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td><?php echo htmlspecialchars($member['phone']); ?></td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td><?php echo htmlspecialchars($member['gender']); ?></td>
                                </tr>
                                <tr>
                                    <th>Birth Date:</th>
                                    <td><?php echo htmlspecialchars($member['birth_date']); ?></td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td><?php echo htmlspecialchars($member['address']); ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td><?php echo $member['status'] == 1 ? 'Alive' : 'Late'; ?></td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end">
                                <a href="delete_member.php?id=<?php echo $member['id']; ?>" class="mx-2 py-1 btn-danger d-inline button">Delete</a>
                                <a href="edit_member.php?id=<?php echo $member['id']; ?>" class="py-1 d-inline button">Edit</a>
                            </div>
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