
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("register-form");
    if (!form) return;

    form.addEventListener("submit", function (e) {

        document.querySelectorAll(".error-message").forEach(el => el.textContent = "");
        document.querySelectorAll(".form-control").forEach(el => el.classList.remove("is-invalid"));

        let valid = true;

        const name = document.getElementById("name");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const confirm = document.getElementById("password_confirmation");

        if (name.value.trim().length < 3) {
            document.getElementById("error-name").textContent = window.translations.error_name;
            name.classList.add("is-invalid");
            valid = false;
        }

        if (!email.value.includes("@") && !email.value.includes(".")) {
            document.getElementById("error-email").textContent = window.translations.error_email_format;
            email.classList.add("is-invalid");
            valid = false;
        }

        if (password.value.length < 6) {
            document.getElementById("error-password").textContent = window.translations.error_password_length;
            password.classList.add("is-invalid");
            valid = false;
        }

        if (password.value !== confirm.value) {
            document.getElementById("error-confirm").textContent = window.translations.error_password_match;
            confirm.classList.add("is-invalid");
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
