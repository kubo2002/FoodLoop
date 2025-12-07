function confirmDeletePhoto() {

    // confirm() zobrazí natívne JS dialógové okno.
    // Vráti true → OK, false → Cancel.
    if (confirm('Naozaj chcete zmazať profilovú fotku?')) {

        // Ak používateľ potvrdil mazanie,
        // programovo odošlem skrytý formulár pomocou submit().
        //
        // Tento formulár má ID "delete-photo-form" v editProfile.blade.php
        // a v Laraveli používa @method('DELETE').
        document.getElementById('delete-photo-form').submit();
    }

    // Ak používateľ klikne "Cancel", funkcia jednoducho skončí
    // a žiadna akcia sa nevykoná (formulár sa neodošle).
}

/**
 * Sem ešte do budúcna doplním ďalšie funkcie súvisiace s profilom, napríklad:
 *
 * - náhľad nahranej fotky pred uložením (preview cez FileReader)
 * - validáciu formulára na strane klienta
 * - AJAX zmenu údajov bez reloadu
 *
 * Aktuálne tu mám implementovanú iba funkciu pre potvrdenie mazania.
 */
