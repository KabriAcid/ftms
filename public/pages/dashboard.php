<?php
require __DIR__ . '/../../config/database.php';
session_start();
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