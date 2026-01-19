
function bindCategoryClicks() {

    document.querySelectorAll('.category-card').forEach(card => {

        card.addEventListener('click', function () {

            document.querySelectorAll('.category-card')
                .forEach(el => el.classList.remove('is-active'));

            this.classList.add('is-active');


            let categoryId = this.dataset.categoryId;


            fetch(`/categories/${categoryId}/offers`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('offers-wrapper').innerHTML = html;
                    if (window.bindOfferDelete) {
                        window.bindOfferDelete();
                    }
                })
                .catch(err => {
                    console.error("Chyba pri načítaní ponúk:", err);
                    document.getElementById('offers-wrapper').innerHTML =
                        "<p class='notice notice-error'>Nepodarilo sa načítať ponuky.</p>";
                });
        });

    });
}

// Po načítaní celej stránky
document.addEventListener('DOMContentLoaded', bindCategoryClicks);
