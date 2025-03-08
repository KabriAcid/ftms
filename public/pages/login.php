<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user from database
    $stmt = $pdo->prepare("SELECT * FROM members WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check if family ID exists in members table
        $stmt = $pdo->prepare("SELECT * FROM members WHERE email = ? && password = ?");
        $stmt->execute([$email, $password]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($member) {
            $_SESSION['user'] = $member;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "No matching family member found.";
        }
    } else {
        $error = "Email does not exist.";
    }
}
?>


<?php require __DIR__ . '/../partials/header.php' ?>

<body>

    <main class="container-fluid p-5">
        <div class="container">
            <h2 class="text-center my-5">Please log in with your details</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <p class="text-center"><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="box-shadow p-5">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">Family Code</label>
                        <input type="text" placeholder="Family Code" class="input-field" id="email" name="email" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" placeholder="Password" class="input-field" id="password" name="password" required>
                    </div>
                </div>
                <div class="my-3 d-flex justify-content-center">
                    <button type="submit" class="button w-100">Sign in</button>
                </div>
                <div class="text-center">
                    <p>Don't have an account? <a href="../../index.php" class="link">Register</a></p>
                </div>
            </form>
        </div>

    </main>
    <!-- Bootstrap JS & dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>