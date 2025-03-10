<?php
session_start();
require __DIR__ . '/../../config/database.php';
$message = false;

function sanitizeAndValidateEvent($eventData)
{
    $sanitizedData = [];
    $errors = [];

    // Sanitize and validate event title
    if (isset($eventData['event_title'])) {
        $sanitizedData['event_title'] = trim(strip_tags($eventData['event_title']));
        if (empty($sanitizedData['event_title'])) {
            $errors[] = "Event title is required.";
        } elseif (strlen($sanitizedData['event_title']) > 255) {
            $errors[] = "Event title must be less than 255 characters.";
        }
    } else {
        $errors[] = "Event title is required.";
    }

    // Sanitize and validate event description
    if (isset($eventData['event_description'])) {
        $sanitizedData['event_description'] = trim(strip_tags($eventData['event_description']));
        if (empty($sanitizedData['event_description'])) {
            $errors[] = "Event description is required.";
        }
    } else {
        $errors[] = "Event description is required.";
    }

    return ['data' => $sanitizedData, 'errors' => $errors];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = sanitizeAndValidateEvent($_POST);

    if (empty($result['errors'])) {
        $eventTitle = $result['data']['event_title'];
        $eventDescription = $result['data']['event_description'];
        $eventDate = $_POST['event_date'];
        $eventTime = $_POST['event_time'];

        try {
            $stmt = $pdo->prepare("INSERT INTO events (event_title, event_description, event_date, event_time) VALUES (:event_title, :event_description, :event_date, :event_time)");
            $stmt->execute([
                ':event_title' => $eventTitle,
                ':event_description' => $eventDescription,
                ':event_date' => $eventDate,
                ':event_time' => $eventTime
            ]);

            $message = "Event added successfully!";
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $message = "An error occurred while adding the event.";
        }
    } else {
        $message = implode(", ", $result['errors']);
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
                <h4>Events</h4>
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
                        <h2>Add New Event</h2>
                        <p>Upload the details of the event.</p>
                    </div>
                </div>
                <div class="container mt-3 box-shadow">
                    <?php if ($message): ?>
                        <p class='text-center text-success'><?php echo $message; ?> <b>Refresh page</b></p>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="event_title">Event Title:</label>
                            <input type="text" id="event_title" placeholder="Event Title" name="event_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="event_description">Event Description:</label>
                            <textarea id="event_description" placeholder="Event Description" name="event_description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="event_date">Event Date:</label>
                            <input type="date" id="event_date" name="event_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="event_time">Event Time:</label>
                            <input type="time" id="event_time" name="event_time" class="form-control" required>
                        </div>
                        <button type="submit" class="button">Add Event</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>