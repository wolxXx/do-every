function captureConfirmElements() {
    document.querySelectorAll('.confirm').forEach(element => {
        if (element.getAttribute('data-captured')) {
            return;
        } else {
            element.setAttribute('data-captured', 'true');
        }

        element.addEventListener('click', (e) => {
            let message = element.getAttribute('data-message');
            if (null === message) {
                message = Translations['are you sure?'];
            }
            if (!confirm(message)) {
                e.stopPropagation();
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
        }, 4000)
    });
    if (0 === container.querySelectorAll('div').length) {
        container.remove();
    }
}

function captureElements() {
    checkFlashMessages();
    captureCloseButtons();
    captureConfirmElements();
    initRowAdder();
    initRowRemover();
    initDropHAndler();
}

function initRowAdder() {
    document.querySelectorAll('.rowAdder').forEach(function (element) {
        element.addEventListener('click', function () {
            let index = element.parentElement.querySelectorAll('.rowRemover').length + 1;
            index = '' + index;
            let newRow = document.createElement('div');
            newRow.innerHTML = element.parentElement.querySelector('template').innerHTML.replaceAll('__INDEX__', index);
            element.parentElement.appendChild(newRow);
            // Re-bind dynamic behaviors for newly added content
            initRowRemover();
            initDropHAndler();
        });
    });
}

function initRowRemover() {
    document.querySelectorAll('.rowRemover').forEach(function (element) {
        if ('1' === element.dataset['bound']) {
            return;
        }
        element.addEventListener('click', function () {
            element.closest('.row')?.remove();
            element.closest('.rowSimple')?.remove();
        });
        element.dataset['bound'] = '1';
    });
}


function initDropHAndler() {
    sortable('.rows', {})
}


function reactOnScroll() {
    let menu = document.getElementById('menu');
    menu.style.top = (window.scrollY - 20) + 'px';
}

addEventListener("scroll", (event) => {
    reactOnScroll();
});


document.addEventListener('DOMContentLoaded', (event) => {
    reactOnScroll();
    captureElements();
});

class Translations {

}