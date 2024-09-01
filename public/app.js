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

function captureCloseButtons() {
    document.querySelectorAll('.btn-close').forEach(element => {
        if (element.getAttribute('data-captured')) {
            return;
        } else {
            element.setAttribute('data-captured', 'true');
        }

        element.addEventListener('click', (e) => {
            element.parentElement.remove();
            checkFlashMessages();
        });
    });
}

function checkFlashMessages() {
    let container = document.getElementById('messageContainer');
    if (null === container) {
        return;
    }
    container.querySelectorAll('.btn-close').forEach(function (element) {
        window.setTimeout(function () {
            element.click();
        }, 5000)
    });
    if (0 === container.querySelectorAll('div').length) {
        container.remove();
    }
}

function captureElements() {
    checkFlashMessages();
    captureCloseButtons();
    captureConfirmElements();
}

document.addEventListener('DOMContentLoaded', (event) => {
    captureElements();
});