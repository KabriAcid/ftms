<?php
require __DIR__ . '/../../config/database.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: logout.php");
} else if (isset($_SESSION['user'])) {
    $family_code = $_SESSION['user']['family_code'];
}


$message = false;
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $family_id = $_SESSION['user']['family_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $relationship = $_POST['relationship'];
    $birthDate = $_POST['birth_date'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $profilePicture = "uploads/user.png";

    // User email is the default password
    $password = password_hash($email, PASSWORD_DEFAULT);

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            $profilePicture = $uploadFile;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO members (family_id, family_code, first_name, last_name, email, password, phone, gender, relationship, birth_date, address, status, profile_picture) VALUES (:family_id, :family_code, :first_name, :last_name, :email, :password, :phone, :gender, :relationship, :birth_date, :address, :status, :profile_picture)");
        $stmt->execute([
            ':family_id' => $family_id,
            ':family_code' => $family_code,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone,
            ':gender' => $gender,
            ':relationship' => $relationship,
            ':birth_date' => $birthDate,
            ':address' => $address,
            ':status' => $status,
            ':profile_picture' => $profilePicture
        ]);

        $message = true;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die('An error occurred while adding the new member.');
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
                        <h2>Add New Family Member</h2>
                        <p>Fill in the details below to add a new family member.</p>
                    </div>
                </div>
                <!-- -->
                <div class="container-fluid mt-4">
                    <!-- Form to add new member -->
                    <div class="container mt-5 box-shadow">
                        <h2>Add Member</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="profile_picture">Profile Picture:</label>
                                <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="relationship">Relationship:</label>
                                <select id="relationship" name="relationship" class="form-control" required>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Uncle">Uncle</option>
                                    <option value="Aunt">Aunt</option>
                                    <option value="Niece">Niece</option>
                                    <option value="Nephew">Nephew</option>
                                    <option value="Cousin">Cousin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="birth_date">Birth Date:</label>
                                <input type="date" id="birth_date" name="birth_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea id="address" name="address" class="form-control" placeholder="Home Address"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1">Alive</option>
                                    <option value="0">Deceased</option>
                                </select>
                            </div>
                            <button type="submit" class="button">Add Member</button>
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