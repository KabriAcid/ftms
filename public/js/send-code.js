function sendAjaxRequest(url, data, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            try {
                let response = JSON.parse(xhr.responseText);
                callback(response);
            } catch (error) {
                console.error("Invalid JSON response:", xhr.responseText);
            }
        }
    };

    xhr.send(data);
}

document.addEventListener("DOMContentLoaded", function () {
    const sendCodeBtn = document.getElementById("sendCode");
    const emailInput = document.getElementById("email");
    const familyName = document.getElementById("family_name");
    const errorMessage = document.getElementById("error-message");
    const spinner = document.getElementById('spinner');

    sendCodeBtn.addEventListener("click", function () {
        let email = emailInput.value.trim();
        let family = familyName.value.trim();

        if (!email || !family) {
            errorMessage.textContent = "Both email and family name are required.";
            return;
        }

        // Prepare AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../scripts/send-code.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Handle response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                try {
                    let response = JSON.parse(xhr.responseText);
                    console.log(response)
                    if (response.success) {
                        spinner.classList.remove('d-none');
                        setTimeout(() => {
                            window.location.href = "../scripts/verify-code.php";
                        }, 200);
                    } else {
                        errorMessage.textContent = response.message;
                    }
                } catch (error) {
                    console.error("Invalid JSON response:", xhr.responseText);
                    errorMessage.textContent = "An unexpected error occurred.";
                }
            }
        };

        // Send data
        let formData = "email=" + encodeURIComponent(email) + "&family_name=" + encodeURIComponent(familyName);
        xhr.send(formData);
    });
});
