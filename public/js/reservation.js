async function createReservation(button, offerId) {
    console.log('addToCart clicked', offerId);

    // tlacidlo pre rezervaciu zmeni farbu na sedu
    button.disabled = true;
    button.classList.remove('btn-success');
    button.classList.add('btn-secondary');
    button.innerText = 'Rezervované';

    const res = await fetch(`/cart/add/${offerId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    });

    console.log('response status:', res.status);

    const data = await res.json().catch(() => ({}));
    console.log('response data:', data);

    if (res.ok) {
        alert('Ponuka bola uložená.');
    } else {
        alert(data.message ?? 'Chyba pri ukladaní.');
    }
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
