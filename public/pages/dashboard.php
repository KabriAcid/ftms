<?php
require __DIR__ . '/../../config/database.php';

session_start();
<<<<<<< HEAD
$userId = $_SESSION['user']['id']; // Assuming user_id is stored in session

try {
    // Fetch counts
    $maleCountStmt = $pdo->prepare("SELECT COUNT(*) FROM members WHERE gender = 'Male'");
    $maleCountStmt->execute();
    $maleCount = $maleCountStmt->fetchColumn();

    $femaleCountStmt = $pdo->prepare("SELECT COUNT(*) FROM members WHERE gender = 'Female'");
    $femaleCountStmt->execute();
    $femaleCount = $femaleCountStmt->fetchColumn();

    $aliveCountStmt = $pdo->prepare("SELECT COUNT(*) FROM members WHERE status = 1");
    $aliveCountStmt->execute();
    $aliveCount = $aliveCountStmt->fetchColumn();

    $deceasedCountStmt = $pdo->prepare("SELECT COUNT(*) FROM members WHERE status = 0");
    $deceasedCountStmt->execute();
    $deceasedCount = $deceasedCountStmt->fetchColumn();
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching counts.');
}

try {
    // Fetch all members
    $stmt = $pdo->prepare("SELECT * FROM members");
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('An error occurred while fetching members.');
}

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
                            if (isset($_SESSION['user']['first_name'])) {
                                echo "Hi, " . $_SESSION['user']['first_name'];
                            } else {
                                echo 'Guest';
                            }
                            ?>
                        </span>
                        <img src="<?php echo $_SESSION['user']['profile_picture'] ?? 'uploads/avatar.jpg'; ?>" alt="Avatar" class="user-avatar">
                    </a>
=======
$family_code = $_SESSION['user']['family_code'];
foreach($_SESSION['user'] as $key => $val){
    echo $key . ": " . $val;
    echo "<br>";
}
try {
    $stmt = $pdo->prepare("SELECT * FROM family WHERE family_code = :family_code");
    $stmt->execute([':family_code' => $family_code]);
    $family = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($family) {
        $familyId = $family['id'];
    } else {
        $familyId = 0;
    }
} catch (PDOException $e) {
    echo "Database Error" . $e->getMessage();
    $family = [];
}
// Fetch family overview
try {
    $stmt = $pdo->prepare("SELECT * FROM family WHERE id = :family_id");
    $stmt->execute([':family_id' => $familyId]);
    $family = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $family = [];
}

// Fetch children
try {
    $stmt = $pdo->prepare("SELECT * FROM children WHERE family_id = :family_id");
    $stmt->execute([':family_id' => $familyId]);
    $children = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $children = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Management System Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?> <!-- Include the navbar -->

    <main>
        <div class="container mt-5">
            <!-- Family Overview -->
            <div class="row">
                <div class="col-md-12">
                    <h2>Family Overview</h2>
                    <div class="card">
                        <div class="card-header">
                            <img src="../img/avatar.jpg" alt="family-pic" class="avatar">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($family['family_name']); ?></h3>
                            <p class="card-text"><?php echo htmlspecialchars($family['family_code']); ?></p>
                            <a href="biography.php" class="btn btn-secondary">View Biography</a>
                        </div>
                    </div>
>>>>>>> 3205cbadc014cd35721f8bd3435d47490e787d27
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main id="content">
            <div class="container">
                <!-- Header: Welcome Message -->
                <div class="row">
                    <div class="col">
                        <h2>Welcome, <?php echo isset($_SESSION['user']['first_name']) ? htmlspecialchars($_SESSION['user']['first_name']) : 'Guest'; ?>!</h2>
                        <p>Here's a quick overview of your family tree.</p>
                    </div>
                </div>

                <!-- Family Overview Section -->
                <div class="container-fluid mt-4">
                    <div class="row">
                        <!-- Total Males Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0" onclick="window.location.href='males.php'">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-male text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Males</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <?php echo $maleCount; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Females Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0" onclick="window.location.href='females.php'">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-female text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Females</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <?php echo $femaleCount; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Alive Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0" onclick="window.location.href='alive.php'">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-heartbeat text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Alive</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <?php echo $aliveCount; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Deceased Card -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card mb-3 mb-xl-0" onclick="window.location.href='deceased.php'">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <div class="icon icon-shape bg-gradient-dark text-center border-radius-md mb-2">
                                            <i class="fa fa-cross text-lg" aria-hidden="true"></i>
                                        </div>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Deceased</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            <?php echo $deceasedCount; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
                                                        <img src="<?php echo htmlspecialchars($member['profile_picture']); ?>" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                    <?php else: ?>
                                                        <img src="https://randomuser.me/api/portraits/men/<?php echo $index + 1; ?>.jpg" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></td>
                                                <td><?php echo htmlspecialchars($member['birth_date']); ?></td>
                                                <td><?php echo htmlspecialchars($member['phone']); ?></td>
                                                <td><?php echo htmlspecialchars($member['gender']); ?></td>
                                                <td><?php echo $member['status'] == 1 ? 'Alive' : 'Late'; ?></td>
                                                <td>
                                                    <a href="child_details.php?id=<?php echo $member['id']; ?>" class="badge badge-sm bg-secondary border-0">View</a>
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