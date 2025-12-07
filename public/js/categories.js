/**
 * Tento skript rieši dynamické načítanie ponúk podľa zvolenej kategórie.
 *
 * Logika:
 * 1. Nájde všetky karty kategórií (.category-card)
 * 2. Po kliknutí na kategóriu sa pošle AJAX (fetch) na backend
 * 3. Backend vráti HTML partial (_list.blade.php)
 * 4. Tento partial vložím do #offers-wrapper bez reloadu stránky
 * 5. Znovu aktivujem delete tlačidlá (bindOfferDelete),
 *    pretože nový HTML obsah neobsahuje JS eventy
 *
 * Toto je kľúčové pre dynamickú aplikáciu → stránka sa neobnovuje
 * a všetko prebieha cez AJAX.
 */
function bindCategoryClicks() {

    // Nájdeme všetky kategórie (HTML prvky s class .category-card)
    document.querySelectorAll('.category-card').forEach(card => {

        // Každej kategórii priradím klik udalost
        card.addEventListener('click', function () {

            /**
             * Najprv odstránim zvýraznenie zo všetkých kariet
             * - teda vizuálne odznačím predchádzajúcu kategóriu
             */
            document.querySelectorAll('.category-card')
                .forEach(el => el.classList.remove('border', 'border-primary'));

            /**
             * Zvýrazním kategóriu, na ktorú používateľ klikol.
             * Toto je len vizuálna spätná väzba.
             */
            this.classList.add('border', 'border-primary');

            // Z HTML atribútu data-category-id získam ID kategórie
            let categoryId = this.dataset.categoryId;

            /**
             * AJAX request cez fetch()
             * Backend route: GET /categories/{id}/offers
             *
             * Backend vráti čisté HTML (nie JSON),
             * preto použijeme response.text()
             */
            fetch(`/categories/${categoryId}/offers`)
                .then(response => response.text())

                // Tu vložím HTML partial do wrappera
                .then(html => {
                    document.getElementById('offers-wrapper').innerHTML = html;

                    /**
                     * Po vložení nového HTML sú všetky pôvodné event listenery fuč.
                     *
                     * Preto musím opäť naviazať funkciu pre mazanie ponúk,
                     * ktorá sa nachádza v offers.js.
                     *
                     * Funkcia bindOfferDelete je dostupná globálne cez window.
                     */
                    if (window.bindOfferDelete) {
                        window.bindOfferDelete();
                    }
                })

                // Ak fetch zlyhá (napr. server neodpovedá)
                .catch(err => {
                    console.error("Chyba pri načítaní ponúk:", err);
                    document.getElementById('offers-wrapper').innerHTML =
                        "<p class='text-danger'>Nepodarilo sa načítať ponuky.</p>";
                });
        });

    });
}

/**
 * Po načítaní celej stránky spustím hlavnú funkciu,
 * aby kategórie reagovali na kliknutie.
 */
document.addEventListener('DOMContentLoaded', bindCategoryClicks);
