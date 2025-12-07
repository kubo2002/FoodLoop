// Počkáme, kým sa celá stránka načíta (HTML je pripravené)
document.addEventListener("DOMContentLoaded", function () {

    // Nájdeme registračný formulár podľa ID.
    // Ak na stránke neexistuje (napr. som na inej stránke), script sa ukončí.
    const form = document.getElementById("register-form");
    if (!form) return;

    // Po kliknutí na "Registrovať" budeme najprv robiť vlastnú validáciu
    form.addEventListener("submit", function (e) {

        // Pred každou validáciou si vymažem staré chybové hlášky a červené orámovania
        document.querySelectorAll(".error-message").forEach(el => el.textContent = "");
        document.querySelectorAll(".form-control").forEach(el => el.classList.remove("is-invalid"));

        // Premenná, ktorá určuje, či je formulár OK
        let valid = true;

        // Načítanie jednotlivých inputov
        const name = document.getElementById("name");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const confirm = document.getElementById("password_confirmation");

        // ---------- VALIDÁCIA MENA ----------
        // Meno musí mať aspoň 3 znaky
        if (name.value.trim().length < 3) {
            document.getElementById("error-name").textContent = window.translations.error_name;
            name.classList.add("is-invalid");
            valid = false;
        }

        // ---------- VALIDÁCIA EMAILU ----------
        // Overujem, či obsahuje '@' a '.'
        if (!email.value.includes("@") && !email.value.includes(".")) {
            document.getElementById("error-email").textContent = window.translations.error_email_format;
            email.classList.add("is-invalid");
            valid = false;
        }

        // ---------- VALIDÁCIA HESLA ----------
        // Heslo musí mať min. 6 znakov
        if (password.value.length < 6) {
            document.getElementById("error-password").textContent = window.translations.error_password_length;
            password.classList.add("is-invalid");
            valid = false;
        }

        // ---------- VALIDÁCIA POTVRDENIA HESLA ----------
        // Musí sa rovnať pôvodnému heslu
        if (password.value !== confirm.value) {
            document.getElementById("error-confirm").textContent = window.translations.error_password_match;
            confirm.classList.add("is-invalid");
            valid = false;
        }

        // Ak niečo z validácie neprešlo → zastavím odoslanie formulára
        if (!valid) {
            e.preventDefault();
        }
    });
});
