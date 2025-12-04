/**
 * PROFILE.JS - JavaScript funkcie pre správu používateľského profilu
 *
 * Tento súbor obsahuje všetky JavaScript funkcie súvisiace s profilom používateľa.
 * Je externý (oddelený od HTML/Blade šablón) pre lepšiu organizáciu kódu.
 */

/**
 * NETRIVIÁLNY JAVASCRIPT - Potvrdenie zmazania profilovej fotky
 *
 * Funkcia zabezpečuje používateľskú interakciu pred vykonaním DELETE operácie
 * - Zobrazí natívne JavaScript confirm() dialógové okno
 * - Ak používateľ potvrdí (klikne OK), formulár sa odošle na server
 * - Ak používateľ zruší (klikne Cancel), neurobí sa nič
 *
 * Volá sa pri kliknutí na tlačidlo "Odstrániť fotku" v editProfile.blade.php
 * Toto je súčasť požiadavky na "Netriviálny JavaScript" pre Termín 2
 */
function confirmDeletePhoto() {
    // confirm() je natívna JavaScript funkcia, ktorá:
    // - Zobrazí dialógové okno s textom a dvoma tlačidlami (OK/Cancel)
    // - Vráti true ak používateľ klikne OK
    // - Vráti false ak používateľ klikne Cancel alebo zatvorí okno
    if (confirm('Naozaj chcete zmazať profilovú fotku?')) {
        // document.getElementById() - DOM metóda pre získanie HTML elementu podľa ID
        // 'delete-photo-form' - ID formulára v editProfile.blade.php
        // .submit() - JavaScript metóda pre programové odoslanie formulára
        // Formulár sa odošle na server s DELETE metódou (Laravel @method('DELETE'))
        document.getElementById('delete-photo-form').submit();
    }
    // Ak používateľ klikol Cancel, funkcia skončí bez vykonania akcie
    // (implicitný return, neurobí sa nič)
}

/**
 * Ďalšie JavaScript funkcie pre profil môžu byť pridané tu
 * Napríklad:
 * - Preview obrázka pred uploadom
 * - Validácia formulára na strane klienta
 * - AJAX requesty
 * atď.
 */
