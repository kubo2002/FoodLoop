function confirmDeletePhoto() {
    if (confirm('Naozaj chcete zmazať profilovú fotku?')) {
        document.getElementById('delete-photo-form').submit();
    }
}

