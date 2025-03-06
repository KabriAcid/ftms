<?php
session_start();
require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../helpers/helpers.php';

// var_dump($_SESSION['user']);
?>

<?php require __DIR__ . '/../partials/header.php'; ?>
<style>
    td {
        vertical-align: middle;
    }
</style>
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
                <!-- Header: Welcome Message -->
                <div class="row">
                    <div class="col">
                        <h2>Welcome, <?php echo isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : 'Guest'; ?>!</h2>
                        <p>Here's a quick overview of your family tree.</p>
                    </div>
                </div>

                <!-- Family Overview Section -->
                <div class="container-fluid mt-4">
                    <div class="row">
                        <!-- Total Males Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-male text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Males</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <!-- Placeholder value -->
                                            40
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Females Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-female text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Females</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <!-- Placeholder value -->
                                            35
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Alive Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-heartbeat text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Alive</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <!-- Placeholder value -->
                                            60
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Deceased Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-cross text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Deceased</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <!-- Placeholder value -->
                                            15
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="container mt-4 box-shadow">
                    <!-- Members List Section -->
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3 py-4 font-weight-bold">Members List</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Birth Date</th>
                                                <th>Gender</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Placeholder rows for children -->
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <img src="https://randomuser.me/api/portraits/men/6.jpg" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                </td>
                                                <td>John Doe</td>
                                                <td>2005-06-15</td>
                                                <td>Male</td>
                                                <td>Active</td>
                                                <td>
                                                    <!-- Actions can include buttons like Edit, View, Delete, etc. -->
                                                    <a href="child_details.php?id<?= 1; ?>" class="badge badge-sm bg-secondary border-0">View</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>
                                                    <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                </td>
                                                <td>Jane Doe</td>
                                                <td>2010-09-23</td>
                                                <td>Female</td>
                                                <td>Active</td>
                                                <td>
                                                    <!-- Actions can include buttons like Edit, View, Delete, etc. -->
                                                    <a href="child_details.php?id<?= 1; ?>" class="badge badge-sm bg-secondary border-0">View</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>
                                                    <img src="https://randomuser.me/api/portraits/men/3.jpg" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                </td>
                                                <td>Michael Smith</td>
                                                <td>2013-12-05</td>
                                                <td>Male</td>
                                                <td>Inactive</td>
                                                <td>
                                                    <!-- Actions can include buttons like Edit, View, Delete, etc. -->
                                                    <a href="child_details.php?id<?= 1; ?>" class="badge badge-sm bg-secondary border-0">View</a>
                                                </td>
                                            </tr>
                                            <!-- Add more placeholder rows as needed -->
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