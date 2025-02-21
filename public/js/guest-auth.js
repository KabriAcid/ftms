function sendAjaxRequest(url, data, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log(xhr.responseText); // Log raw response

            try {
                let response = JSON.parse(xhr.responseText);
                console.log(response); // Check if it's a valid JSON object
                callback(response); // Pass parsed response to callback
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

        let familyCode = document.getElementById("family_code").value;
        let errorMessage = document.getElementById("error-message");

        if (familyCode.trim() === "") {
            errorMessage.textContent = "Family code is required.";
            return;
        }

        let formData = "family_code=" + encodeURIComponent(familyCode);

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
