function captureConfirmElements() {
    

document.querySelectorAll('.confirm').forEach(element => {
    if (element.getAttribute('data-captured')) {
        return;
    } else {
        element.setAttribute('data-captured', 'true');
    }
    
    element.addEventListener('click', (e) => {
        if (!confirm('Bist du sicher?')) {
            e.preventDefault();
        }
    });
});
}

document.addEventListener('DOMContentLoaded', (event) => {
   captureConfirmElements();
});