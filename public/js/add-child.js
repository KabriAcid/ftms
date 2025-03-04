document.getElementById('addChildForm').addEventListener('submit', function (event) {
    event.preventDefault();

    var name = document.getElementById('name').value;
    var phone_number = document.getElementById('phone_number').value;
    var birthDate = document.getElementById('birth_date').value;
    var gender = document.getElementById('gender').value;
    var errorMessage = document.getElementById('error-message');

    if (!name || !phone_number || !birthDate || !gender) {
        errorMessage.textContent = 'Please fill in all fields.';
        return;
    }

    var data = {
        name: name,
        phone_number: phone_number,
        birth_date: birthDate,
        gender: gender,
    };

    sendAjaxRequest('../scripts/process_add_child.php', data, function (response) {
        if (response.success) {
            window.location.href = 'dashboard.php';
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
