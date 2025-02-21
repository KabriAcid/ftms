<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Authentication</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <main>
        <div class="container">
            <div class="container-header">
                <h2>GUEST AUTHENTICATION</h2>
                <p>Enter your family code below or generate a new one.</p>
            </div>
            <form id="guestAuthForm">
                <input type="text" id="family_code" name="family_code" placeholder="Enter Your Family Code" class="input-field" required>
                <p id="error-message"></p>
                <div class="between">
                    <a href="public/pages/generate-code.php" class="btn-secondary" id="generateCode">Generate</a>
                    <button type="submit" class="button">Proceed</button>
                </div>
            </form>
        </div>
    </main>
    <script src="public/js/guest-auth.js"></script>
</body>


</html>