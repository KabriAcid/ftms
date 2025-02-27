<?php
// Include the database connection
require_once __DIR__ . '/../../config/database.php';

// Start session for CSRF protection
session_start();
if (isset($_SESSION['family_code'])) {
    $family_code = $_SESSION['family_code'];
} else {
    $family_code = 00000;
}

// Initialize variables
$errors = [];
$first_name = $last_name = $email = $phone = $password = $confirm_password = $gender = $birth_date = $address = $role = '';
$profile_picture = 'avatar.png';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // // CSRF Protection
    // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    //     $errors[] = "Invalid CSRF token.";
    // }

    // Collect form data
    $first_name = trim(ucwords($_POST['first_name']));
    $last_name = trim(ucwords($_POST['last_name']));
    $email = trim(strtolower($_POST['email']));
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : NULL;
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $gender = $_POST['gender'];
    $birth_date = isset($_POST['birth_date']) ? trim($_POST['birth_date']) : NULL;
    $address = isset($_POST['address']) ? trim($_POST['address']) : NULL;
    $role = isset($_POST['role']) ? $_POST['role'] : 'User';

    // Validate First Name
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }

    // Validate Last Name
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }

    // Validate Email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        // Check if email already exists in the database
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Email is already taken.";
        }
    }

    // Validate Phone (optional)
    if (!empty($phone) && !preg_match("/^[0-9]{11}$/", $phone)) {
        $errors[] = "Invalid phone number. It should be 11 digits.";
    }

    // Validate Password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password should be at least 6 characters long.";
    }

    // Validate Confirm Password
    if (empty($confirm_password)) {
        $errors[] = "Please confirm your password.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Validate Gender
    if (empty($gender)) {
        $errors[] = "Gender is required.";
    }

    // Validate Birth Date (optional)
    if (!empty($birth_date) && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $birth_date)) {
        $errors[] = "Invalid birth date format.";
    }

    // Profile Picture Upload Handling
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'heic'])) {
            $errors[] = "Invalid file type for profile picture. Only JPG, PNG, and GIF are allowed.";
        } elseif ($_FILES['profile_picture']['size'] > 2000000) {
            $errors[] = "Profile picture size should not exceed 2MB.";
        } else {
            $unique_id = uniqid();
            $profile_picture = $upload_dir . $unique_id;
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture)) {
                $errors[] = "Error uploading profile picture.";
            }
        }
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, family_code, email, phone, password, profile_picture, gender, birth_date, address, role)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Execute the query
            $stmt->execute([
                $first_name,
                $last_name,
                $family_code,
                $email,
                $phone,
                $hashed_password,
                $profile_picture,
                $gender,
                $birth_date,
                $address,
                $role
            ]);

            // Redirect to login page
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "An internal error occurred. Please try again." . $e->getMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Tree</title>
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>

    <main class="container-fluid p-5">
        <div class="container box-shadow">
            <h2 class="text-center my-5">Family Registration Form</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" placeholder="First Name" class="input-field" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" placeholder="Last Name" class="input-field" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" placeholder="Email" class="input-field" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone (optional)</label>
                        <input type="tel" placeholder="Phone Number" class="input-field" id="phone" name="phone" value="<?php echo $phone; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" placeholder="Password" class="input-field" id="password" name="password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" placeholder="Confirm Password" class="input-field" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Profile picture</label>
                        <input type="file" name="profile_picture" class="input-field">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="input-field" id="gender" name="gender" required>
                            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label">Date of Birth</label>
                        <input type="date" class="input-field" id="birth_date" name="birth_date" value="<?php echo $birth_date; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="address" class="form-label">Address (optional)</label>
                        <textarea class="input-field" id="address" name="address" rows="3"><?php echo $address; ?></textarea>
                    </div>
                </div>

                <div class="my-3 d-flex justify-content-center">
                    <button type="submit" class="button w-100">Register</button>
                </div>

                <div class="text-center">
                    <p>Already have an account? <a href="login.php" class="link">Login</a></p>
                </div>
            </form>
        </div>

    </main>
    <!-- Bootstrap JS & dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>