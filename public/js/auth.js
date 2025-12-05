/**
 * AUTH.JS - JavaScript funkcie pre autentifikáciu a registráciu
 *
 * Tento súbor obsahuje validačné funkcie pre registračný a prihlasovací formulár
 * Je externý (oddelený od HTML/Blade šablón) pre lepšiu organizáciu kódu
 */

/**
 * VALIDÁCIA EMAILU NA STRANE KLIENTA
 *
 * Funkcia kontroluje formát emailovej adresy pomocou regex vzoru
 * Volá sa pri odoslaní registračného formulára (onsubmit event)
 *
 * Regex pattern vysvetlenie:
 * ^[^\s@]+    - Začiatok, jeden alebo viac znakov okrem medzery a @
 * @           - Musí obsahovať znak @
 * [^\s@]+     - Jeden alebo viac znakov okrem medzery a @
 * \.          - Musí obsahovať bodku
 * [^\s@]+$    - Jeden alebo viac znakov okrem medzery a @, koniec
 *
 * Príklady:
 * ✓ user@example.com
 * ✓ test.user@domain.co.uk
 * ✗ user@domain (chýba .com)
 * ✗ userdomain.com (chýba @)
 * ✗ @domain.com (chýba používateľské meno)
 *
 * @param {Event} event - Submit event z formulára
 * @returns {boolean} - true ak je email validný, false ak nie
 */
function validateEmail(event) {
    // Získanie email inputu z formulára pomocou name atribútu
    const emailInput = document.querySelector('input[name="email"]');

    // Získanie hodnoty z inputu a odstránenie medzier
    const emailValue = emailInput.value.trim();

    // Regex pattern pre validáciu emailu
    // ^ = začiatok stringu, $ = koniec stringu
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // test() metóda kontroluje, či email zodpovedá patternu
    if (!emailPattern.test(emailValue)) {
        // Zastavenie odoslania formulára
        event.preventDefault();

        // Pridanie Bootstrap "is-invalid" triedy pre vizuálnu chybu
        emailInput.classList.add('is-invalid');

        // Kontrola, či už existuje error message div
        let errorDiv = emailInput.nextElementSibling;

        // Ak neexistuje error div s triedou "invalid-feedback", vytvoríme ho
        if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            // Vloženie error divu za email input
            emailInput.parentNode.insertBefore(errorDiv, emailInput.nextSibling);
        }

        // Nastavenie chybovej správy
        errorDiv.textContent = 'Zadajte platný email vo formáte: meno@domena.sk';
        errorDiv.style.display = 'block';

        // Vrátenie false = formulár sa neodošle
        return false;
    }

    // Ak je email validný, odstránime error štýly (ak existujú)
    emailInput.classList.remove('is-invalid');
    const errorDiv = emailInput.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
        errorDiv.style.display = 'none';
    }

    // Vrátenie true = formulár sa môže odoslať
    return true;
}

/**
 * Event listener pre real-time validáciu
 * Spustí sa pri každom napísaní znaku do email inputu
 */
document.addEventListener('DOMContentLoaded', function() {
    // Získanie email inputu
    const emailInput = document.querySelector('input[name="email"]');

    // Ak existuje email input (sme na registračnej stránke)
    if (emailInput) {
        // Pridanie event listenera pre "input" event (real-time validácia)
        emailInput.addEventListener('input', function() {
            const emailValue = this.value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Ak používateľ začal písať a email nie je validný
            if (emailValue.length > 0 && !emailPattern.test(emailValue)) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
            // Ak je email validný
            else if (emailPattern.test(emailValue)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
            // Ak je pole prázdne
            else {
                this.classList.remove('is-invalid');
                this.classList.remove('is-valid');
            }
        });
    }
});
