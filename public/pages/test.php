<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        main {
            width: 50%;
            margin: auto;
        }
    </style>
</head>

<body>
    <main>
        <form action="" method="post">
            <input type="search" class="input-field" id="search" placeholder="Search">
        </form>
        <div id="search-result"></div>
    </main>
    <script>
        function sendAjaxRequest(url, data, callback) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    console.log(xhr.responseText); // Log raw response

                    try {
                        let response = JSON.parse(xhr.responseText);
                        console.log(response);
                        callback(response);
                    } catch (error) {
                        console.error("Invalid JSON response:", xhr.responseText);
                        callback({
                            success: false,
                            message: "Invalid server response."
                        });
                    }
                }
            };

            xhr.send(data);
        }

        sendAjaxRequest('test.php', search, function(){
            
        });
    </script>
</body>

</html>