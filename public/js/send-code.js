document.getElementById('sendCode').addEventListener('click', function () {
    var email = document.getElementById('email').value;
    var familyName = document.getElementById('family_name').value;
    var errorMessage = document.getElementById('error-message');
    var spinner = document.getElementById('spinner');

    if (!email || !familyName) {
        errorMessage.textContent = 'Please fill in all fields.';
        return;
    }

    spinner.classList.remove('d-none');

    var data = {
        email: email,
        family_name: familyName
    };

    sendAjaxRequest('../scripts/send-code.php', data, function (response) {
        spinner.classList.add('d-none');
        if (response.success) {
            alert('Family code sent to your email!');
            window.location.href = response.redirect;
        } else {
            errorMessage.textContent = response.message;
        }
    });
});



function sendAjaxRequest(url, data, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            try {
                const response = JSON.parse(xhr.responseText);
                callback(response);
            } catch (e) {
                console.error("Invalid JSON response:", xhr.responseText);
                callback({ success: false, message: "An unexpected error occurred." });
            }
        }
    };

    xhr.onerror = function () {
        callback({ success: false, message: "Network error. Please try again." });
    };

    xhr.send(new URLSearchParams(data).toString());
}