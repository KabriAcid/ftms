<?php
session_start();
require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../helpers/helpers.php';

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
                <h4>Dashboard</h4>
                <div class="user-info">
                    <!-- Avatar Placeholder -->
                    <a href="profile.php" class="text-light">
                        <span class="user-name mx-2">
                            <?php
                            if (isset($_SESSION['username'])) {
                                echo $_SESSION['username'];
                            } else {
                                echo 'Guest';
                            }
                            ?>
                        </span>
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Avatar" class="user-avatar">
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
                <div class="container-fluid mt-4">

                </div>
            </div>

        </main>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>