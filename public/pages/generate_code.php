<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Family Code</title>
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <main>
        <div class="container box-shadow mt-4">
            <div class="container-header">
                <h2>GENERATE A FAMILY CODE</h2>
                <p>A custom family code will be sent to your email.</p>
            </div>
            <form>
                <div class="form-group">
                    <label for="" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email Address" class="input-field" required>
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Family name</label>
                    <input type="text" id="family_name" name="family_name" placeholder="Enter your family name" class="input-field" required>
                </div>
                <p id="error-message"></p>
                <div class="end">
                    <button type="button" class="button" id="sendCode">
                        <i class="fa fa-circle-o-notch fa-spin d-none" id="spinner"></i> Send Code
                    </button>
                </div>
            </form>
            <p class="text-sm text-secondary text-center">Copyright @Dreamcoders</p>
        </div>
    </main>
    <script src="../js/send-code.js"></script>
</body>


</html>