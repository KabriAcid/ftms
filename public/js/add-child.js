document.getElementById('addChildForm').addEventListener('submit', function (event) {
    event.preventDefault();

    var name = document.getElementById('name').value;
    var birthDate = document.getElementById('birth_date').value;
    var gender = document.getElementById('gender').value;
    var bloodType = document.getElementById('blood_type').value;
    var errorMessage = document.getElementById('error-message');

    if (!name || !birthDate || !gender || !bloodType) {
        errorMessage.textContent = 'Please fill in all fields.';
        return;
    }

    var data = {
        name: name,
        birth_date: birthDate,
        gender: gender,
        blood_type: bloodType
    };

    sendAjaxRequest('process_add_child.php', data, function (response) {
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
