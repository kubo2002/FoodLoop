
function bindOfferDelete() {

    // Nájde všetky tlačidlá určené na mazanie ponuky
    document.querySelectorAll('.delete-offer').forEach(btn => {

        // Každému tlačidlu pridám klik event
        btn.addEventListener('click', function () {

            // Získam ID ponuky z HTML atribútu data-id
            let id = this.dataset.id;

            // Bezpečnostná otázka – aby používateľ omylom nič nevymazal
            if (!confirm("Naozaj chceš vymazať ponuku?")) return;


            fetch(`/offers/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                // Prevedenie odpovede na JSON
                .then(res => res.json())

                // Spracovanie JSON odpovede
                .then(data => {

                    if (data.success) {

                        const card = document.getElementById(`offer-${id}`);
                        if (card) {
                            card.remove();
                        } else {

                            window.location.href = '/my-offers';
                        }
                    } else {
                        alert("Nepodarilo sa vymazať ponuku.");
                    }
                })

                .catch(err => {
                    console.error("Chyba pri mazaní:", err);
                    alert("Nastala chyba pri mazaní ponuky.");
                });

        });

    });

}

document.addEventListener('DOMContentLoaded', bindOfferDelete);

window.bindOfferDelete = bindOfferDelete;
