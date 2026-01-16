async function addToCart(offerId) {
    console.log('addToCart clicked', offerId);

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
