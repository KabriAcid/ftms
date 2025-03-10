<?php
require __DIR__ . '/../../config/database.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: logout.php");
}

if (isset($_GET['message'])) {
    echo "<script>
            alert('" . $_GET['message'] . "');
            window.history.replaceState({}, document.title, window.location.pathname);
          </script>";
}

$userId = $_SESSION['user']['id']; // Assuming user_id is stored in session
$family_id = $_SESSION['user']['family_id']; // Assuming user_id is stored in session

try {
    // Fetch all members
    $stmt = $pdo->prepare("SELECT * FROM members WHERE family_id = ?");
    $stmt->execute([$family_id]);
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching members.');
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
                <h4>Members</h4>
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
                        <h2>Welcome, <?php echo isset($_SESSION['user']['first_name']) ? htmlspecialchars($_SESSION['user']['first_name']) : 'Guest'; ?>!</h2>
                        <p>Here's a list of all your family members.</p>
                    </div>
                </div>
                <!-- -->
                <!--  -->
                <div class="container mt-4 box-shadow">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3 py-4 font-weight-bold">Members List</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Birth Date</th>
                                            <th>Phone Number</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($members as $index => $member): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <?php if ($member['profile_picture']): ?>
                                                        <img src="<?php echo htmlspecialchars($member['profile_picture']); ?>" alt="Photo" class="img-thumbnail p-0" style="width: 50px; height: 50px;">
                                                    <?php else: ?>
                                                        <img src="uploads/user.png" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></td>
                                                <td><?php echo htmlspecialchars($member['birth_date']); ?></td>
                                                <td><?php echo htmlspecialchars($member['phone']); ?></td>
                                                <td><?php echo htmlspecialchars($member['gender']); ?></td>
                                                <td><?php echo $member['status'] == 1 ? 'Alive' : 'Late'; ?></td>
                                                <td>
                                                    <a href="member_details.php?id=<?php echo $member['id']; ?>" class="badge badge-sm bg-secondary border-0">View</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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