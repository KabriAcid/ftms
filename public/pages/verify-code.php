<?php
session_start();
var_dump($_SESSION['family_code']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <main>
        <div class="container box-shadow w-50 m-auto">
            <div class="container-header">
                <h2>VERIFY FAMILY CODE</h2>
                <p>Enter the family code that has been sent to your email.</p>
            </div>
            <form>
                <div class="form-row">
                    <input type="text" id="family_code" name="family_code" placeholder="Verify your family code" class="input-field" required maxlength="9">
                </div>
                <p id="error-message"></p>
                <div class="center">
                    <button type="button" class="button" id="verifyCode">
                        <i class="fa fa-circle-o-notch fa-spin d-none" id="spinner"></i> Verfy Code
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script src="../js/verify-code.js"></script>
</body>

</html>