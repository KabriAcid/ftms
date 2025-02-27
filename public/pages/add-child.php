<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Child</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include_once '../partials/navbar.php'; ?>
    <main>
        <div class="container box-shadow">
            <div class="container-header">
                <h2>Add Child</h2>
            </div>
            <form id="addChildForm">
                <div class="form-row">
                    <label for="name" class="input-field-label">Name:</label>
                    <input type="text" id="name" name="name" class="input-field" required placeholder="Name">
                </div>
                <div class="form-row">
                    <label for="phone_number" class="input-field-label">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="input-field" required placeholder="Phone Number">
                </div>
                <div class="form-row">
                    <label for="birth_date" class="input-field-label">Birth Date:</label>
                    <input type="date" id="birth_date" name="birth_date" class="input-field" required>
                </div>
                <div class="form-row">
                    <label for="gender" class="input-field-label">Gender:</label>
                    <select id="gender" name="gender" class="input-field pr-3" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="blood_type" class="input-field-label">Blood Type:</label>
                    <select id="blood_type" name="blood_type" class="input-field" required>
                        <option value="">Select Blood Type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="end">
                    <button type="submit" class="button">Add Child</button>
                </div>
            </form>
            <p id="error-message"></p>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/add-child.js"></script>
</body>

</html>