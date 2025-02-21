document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("verifyCode").addEventListener("click", function (e) {
        e.preventDefault();

        let familyCode = document.getElementById("family_code").value.trim();
        let errorMessage = document.getElementById("error-message");

        if (familyCode === "") {
            errorMessage.textContent = "Family code is required.";
            return;
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "public/scripts/verify-code.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    setTimeout(() => {
                        window.location.href = "register.php";
                    }, 2000);
                } else {
                    errorMessage.textContent = response.message;
                }
            }
        };

        xhr.send("family_code=" + encodeURIComponent(familyCode));
    });
});
