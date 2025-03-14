function sendAjaxRequest(url, data, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log(xhr.responseText); // Log raw response

            try {
                let response = JSON.parse(xhr.responseText);
                console.log(response);
                callback(response);
            } catch (error) {
                console.error("Invalid JSON response:", xhr.responseText);
                callback({ success: false, message: "Invalid server response." });
            }
        }
    };

    xhr.send(data);
}


document.addEventListener("DOMContentLoaded", function () {
    const submit = document.getElementById('submit');
    submit.addEventListener("click", function () {

        let family_code = document.getElementById("family_code").value;
        let errorMessage = document.getElementById("error-message");

        sessionStorage.setItem('family_code', family_code);

        if (family_code.trim() === "") {
            errorMessage.textContent = "Family code is required.";
            return;
        }

        let formData = "family_code=" + encodeURIComponent(family_code);

        sendAjaxRequest("public/scripts/guest_auth.php", formData, function (response) {
            if (response.success) {
                window.location.href = "public/pages/register.php";
            } else {
                errorMessage.textContent = response.message;
                document.getElementById('family_code').classList.add('err')
            }
        });
    });
});
