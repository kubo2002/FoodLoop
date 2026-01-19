async function createReservation(button, offerId) {
    console.log('reserve clicked', offerId);

    // Dočasný UI stav
    button.disabled = true;
    button.classList.remove('btn-primary');
    button.classList.add('btn-secondary');
    button.innerText = 'Ukladám...';

    const res = await fetch(`/cart/add/${offerId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    });

    const data = await res.json().catch(() => ({}));

    if (res.ok && (data.ok === true || data.success === true)) {
        button.innerText = 'Rezervované';
        alert(data.message ?? 'Ponuka bola rezervovaná.');
    } else {
        // obnov tlačidlo, ak zlyhalo
        button.disabled = false;
        button.classList.remove('btn-secondary');
        button.classList.add('btn-primary');
        button.innerText = 'Rezervovať';
        alert(data.message ?? 'Chyba pri rezervovaní.');
    }
}

function addToCart(button, offerId) {
    return createReservation(button, offerId);
}

function csrf() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

// AJAX update
async function updateReservation(id) {
    const status = document.getElementById(`status-${id}`).value;
    const msg = document.getElementById(`msg-${id}`);
    msg.innerText = 'Ukladám...';

    const res = await fetch(`/reservations/${id}`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrf(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status })
    });

    if (res.ok) {
        msg.innerText = 'Uložené';
    } else {
        msg.innerText = 'Chyba';
    }
}

// AJAX delete
async function deleteReservation(id) {
    if (!confirm('Naozaj odstrániť rezerváciu?')) {
        return;
    }

    const msg = document.getElementById(`msg-${id}`);
    msg.innerText = 'Odstraňujem...';

    const res = await fetch(`/reservations/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrf(),
            'Accept': 'application/json'
        }
    });

    if (res.ok) {
        document.getElementById(`reservation-${id}`).remove();
    } else {
        msg.innerText = 'Chyba';
    }
}
