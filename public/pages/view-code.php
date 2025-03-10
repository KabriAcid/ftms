<?php

if (isset($_GET['family_name'])) {
    $family_name = $_GET['family_name'];
}

function generateFamilyCode($family_name)
{
    $prefix = strtoupper(substr($family_name, 0, 4));

    // Ensure prefix is exactly 4 characters
    $prefix = str_pad($prefix, 4, chr(rand(65, 90)));

    // Generate a 4-digit random number
    $randomCode = random_int(1000, 9999);

    return $prefix . '-' . $randomCode;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Authentication</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Add icon library -->

</head>

<body>
    <main>
        <div class="container box-shadow mt-5">
            <div class="container-header">
                <h2>GENERATED FAMILY CODE</h2>
                <p>Below is your auto-generated family code.</p>
            </div>
            <form action="register.php" method="get">
                <p id="error-message"></p>
                <div class="code-container">
                    <div class="code-inner-container">
                        <h2 id="code">
                            <?php
                            if (isset($_GET['family_name'])) {
                                $family_code = generateFamilyCode($family_name);
                                echo $family_code;
                            }
                            ?>
                        </h2>
                    </div>
                </div>
                <!--  -->
                <input type="hidden" name="family_code" value="<?php echo $family_code; ?>">
                <input type="hidden" name="family_name" value="<?php echo $family_name; ?>">
                <!--  -->
                <div class="center">
                    <button type="submit" class="button" id="sendCode">Register</button>
                </div>
            </form>
        </div>
    </main>
    <!-- <script src="../js/send-code.js"></script> -->
</body>


</html>