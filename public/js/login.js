// Počkáme, kým sa celá stránka načíta (aby boli všetky HTML prvky dostupné)
document.addEventListener("DOMContentLoaded", function () {

    // Nájdeme login formulár podľa ID
    // Ak som na inej stránke (napr. /offers), formulár neexistuje → skript skončí
    const form = document.getElementById("login-form");
    if (!form) return;

    // Pri odoslaní formulára spustím vlastnú validáciu
    form.addEventListener("submit", function (e) {

        /**
         * Pred začiatkom validácie vyčistím staré chyby:
         * - vymažem texty chýb (.error-message)
         * - odstránim červené orámovanie z inputov (.is-invalid)
         */
        document.querySelectorAll(".error-message").forEach(el => el.textContent = "");
        document.querySelectorAll(".form-control").forEach(el => el.classList.remove("is-invalid"));

        // Premenná, ktorá sleduje, či je formulár platný
        let valid = true;

        // Načítam si email a heslo
        const email = document.getElementById("login-email");
        const password = document.getElementById("login-password");

        /**
         * VALIDÁCIA EMAILU
         * ----------------
         * 1. Email nesmie byť prázdny
         * 2. Musí obsahovať "@"
         */
        if (email.value.trim() === "") {

            // Zobrazím chybovú hlášku z prekladov
            document.getElementById("login-error-email").textContent = window.translations.error_email_required;

            // Zvýrazním input červenou (Bootstrap .is-invalid)
            email.classList.add("is-invalid");

            valid = false;

        } else if (!email.value.includes("@")) {

            // Ak email neobsahuje @, zobrazím chybu formátu
            document.getElementById("login-error-email").textContent = window.translations.error_email_format;

            email.classList.add("is-invalid");
            valid = false;
        }

        /**
         * VALIDÁCIA HESLA
         * ---------------
         * - Heslo nesmie byť prázdne
         */
        if (password.value.trim() === "") {

            // Hláška skopírovaná z prekladov (SK/EN)
            document.getElementById("login-error-password").textContent = window.translations.error_password_required;

            password.classList.add("is-invalid");
            valid = false;
        }

        /**
         * Ak bola nájdená akákoľvek chyba v emaili alebo hesle,
         * zabráni sa odoslaniu formulára na server (Laravel).
         */
        if (!valid) {
            e.preventDefault(); // stop submission
        }
    });
});
