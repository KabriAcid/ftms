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
                    <span class="user-name">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo $_SESSION['username'];
                        } else {
                            echo 'Guest';
                        }
                        ?>
                    </span>
                    <img src="../IMG/avatar.jpg" alt="User Avatar" class="user-avatar">
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main id="content">
            <div class="container mt-4">
                <!-- Header: Welcome Message -->
                <div class="row mb-4">
                    <div class="col">
                        <h2>Welcome, <?php echo isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : 'Guest'; ?>!</h2>
                        <p>Here's a quick overview of your family tree.</p>
                    </div>
                </div>

                <!-- Family Overview Section -->
                <div class="row">
                    <!-- Family Summary Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Family Summary</h5>
                                <p class="card-text">Family Name: <?php echo htmlspecialchars($family_summary['family_name']); ?></p>
                                <p class="card-text">Family Code: <?php echo htmlspecialchars($family_summary['family_code']); ?></p>
                                <p class="card-text">Members: <?php echo htmlspecialchars($family_summary['member_count']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent Activities</h5>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($recent_activities as $activity): ?>
                                        <li class="list-group-item"><?php echo htmlspecialchars($activity['description']); ?> - <?php echo htmlspecialchars($activity['created_at']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Events Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Upcoming Events</h5>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($upcoming_events as $event): ?>
                                        <li class="list-group-item"><?php echo htmlspecialchars($event['event_name']); ?> - <?php echo htmlspecialchars($event['event_date']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

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
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>