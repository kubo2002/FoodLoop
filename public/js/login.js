
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("login-form");
    if (!form) return;

    form.addEventListener("submit", function (e) {

        document.querySelectorAll(".error-message").forEach(el => el.textContent = "");
        document.querySelectorAll(".form-control").forEach(el => el.classList.remove("is-invalid"));

        let valid = true;

        const email = document.getElementById("login-email");
        const password = document.getElementById("login-password");

        if (email.value.trim() === "") {

            document.getElementById("login-error-email").textContent = window.translations.error_email_required;

            email.classList.add("is-invalid");

            valid = false;

        } else if (!email.value.includes("@")) {

            document.getElementById("login-error-email").textContent = window.translations.error_email_format;

            email.classList.add("is-invalid");
            valid = false;
        }

        if (password.value.trim() === "") {

            document.getElementById("login-error-password").textContent = window.translations.error_password_required;

            password.classList.add("is-invalid");
            valid = false;
        }


        if (!valid) {
            e.preventDefault();
        }
    });
});
