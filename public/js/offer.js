/**
* bindOfferDelete()
* -----------------
* Funkcia, ktorá priradí klik udalosti všetkým tlačidlám .delete-offer.
* Toto potrebujem preto, lebo ponuky sa načítavajú aj dynamicky (cez AJAX)
* a klasický jeden event listener by nestačil.
*
* Funkcia sa spustí:
    *  - pri načítaní stránky
*  - aj neskôr, keď sa cez AJAX nahrá nový zoznam ponúk
*/
function bindOfferDelete() {

    // Nájde všetky tlačidlá určené na mazanie ponuky
    document.querySelectorAll('.delete-offer').forEach(btn => {

        // Každému tlačidlu pridám klik event
        btn.addEventListener('click', function () {

            // Získam ID ponuky z HTML atribútu data-id
            let id = this.dataset.id;

            console.log("Klikol som na delete:", id); // Pomocný výpis pri debugovaní

            // Bezpečnostná otázka – aby používateľ omylom nič nevymazal
            if (!confirm("Naozaj chceš vymazať ponuku?")) return;

            /**
             * AJAX DELETE požiadavka
             * ----------------------
             * Tu neobnovujem celú stránku.
             * Namiesto toho posielam DELETE request cez fetch()
             * a očakávam JSON odpoveď od Laravel kontroléra.
             */
            fetch(`/offers/${id}`, {
                method: 'DELETE',
                headers: {
                    /**
                     * Laravel chráni všetky POST/PUT/DELETE požiadavky cez CSRF ochranu.
                     * Preto musím poslať X-CSRF-TOKEN, inak request padne.
                     *
                     * Rovnako posielam X-Requested-With, aby Laravel vedel,
                     * že ide o AJAX request a mal v controllery správnu odpoveď.
                     */
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                // Prevedenie odpovede na JSON
                .then(res => res.json())

                // Spracovanie JSON odpovede
                .then(data => {

                    if (data.success) {
                        /**
                         * Ak server potvrdí vymazanie,
                         * nájdem HTML prvok s ID offer-{id}
                         * a odstránim ho z DOM-u.
                         *
                         * Tým pádom ponuka zmizne okamžite
                         * bez reloadu stránky.
                         */
                        const card = document.getElementById(`offer-${id}`);
                        if (card) card.remove();
                    } else {
                        alert("Nepodarilo sa vymazať ponuku.");
                    }
                })

                // Zachytenie chýb (napríklad server neodpovedá)
                .catch(err => {
                    console.error("Chyba pri mazaní:", err);
                    alert("Nastala chyba pri mazaní ponuky.");
                });

        });

    });

}

/**
 * Pri načítaní celej stránky spustím bindOfferDelete(),
 * aby tlačidlá fungovali aj bez AJAX načítania.
 */
document.addEventListener('DOMContentLoaded', bindOfferDelete);

/**
 * Sprístupním funkciu aj do globálneho priestoru,
 * aby ju categories.js vedel zavolať,
 * keď načíta nový obsah cez AJAX.
 */
window.bindOfferDelete = bindOfferDelete;
