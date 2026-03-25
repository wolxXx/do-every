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

function captureInputs() {
    const elements = document.querySelectorAll('button, input[type="submit"], a');
    for (const input of elements) {
        if (input.getAttribute('data-captured-hover')) {
            continue;
        } else {
            input.setAttribute('data-captured-hover', 'true');
        }

        input.addEventListener('mouseenter', () => {
            animate(input, {
                scale: 1.5,             // Minimales "Entgegenkommen"
                duration: 10,
                delay: 0,
                easing: 'easeOutExpo'
            });
        })
        input.addEventListener('mouseleave', () => {
            animate(input, {
                scale: 1.0,             // Minimales "Entgegenkommen"
                duration: 10,
                delay: 0,
                easing: 'easeOutExpo'
            });
        })
    }

    const inputs = document.querySelectorAll('input, textarea, select');
    for (const input of inputs) {
        return;
        if (input.getAttribute('data-captured')) {
            continue;
        } else {
            input.setAttribute('data-captured', 'true');
        }

        let initialWidth = window.getComputedStyle(input).getPropertyValue('width');
        console.log(initialWidth);
        if('auto' === initialWidth) {
            initialWidth = '100';
        }
        initialWidth = parseInt(initialWidth);
        initialWidth = initialWidth + 'px';
        input.addEventListener('focus', () => {
         /*   let backdrop = document.createElement('div');
            backdrop.id = 'input-backdrop';
            backdrop.style.position = 'fixed';
            backdrop.style.top = '0';
            backdrop.style.left = '0';
            backdrop.style.width = '100%';
            backdrop.style.height = '100%';
            backdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            backdrop.style.zIndex = '12340';
            document.body.appendChild(backdrop);*/


            animate(input, {
                width: '500px',          // Wird breiter
                scale: 1.05,             // Minimales "Entgegenkommen"
                boxShadow: '0px 10px 20px rgba(55, 53, 237, 0.3)', // Weicher Schatten
                borderColor: '#3735ed',
                duration: 100,
                //position: 'absolute',
                delay: 0,
                'z-index': '12345',
                easing: 'easeOutExpo'
            });
        });

        // Animation beim Verlassen (Raus-Klicken)
        input.addEventListener('blur', () => {
            let backdrop = document.getElementById('input-backdrop');
            if (backdrop) {
                backdrop.remove();
            }

            animate(input, {
                width: initialWidth,          // Zurück zur Basisbreite
                scale: 1,
                position: 'relative',
                boxShadow: '0px 0px 0px rgba(0,0,0,0)',
                borderColor: '#ccc',
                'z-index': 1,
                duration: 200,
                delay: 0,
                easing: 'easeInSine'
            });
        });

    }

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
    captureInputs();
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
            captureInputs();
            console.log('added');
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
    if (0 === window.scrollY){
        menu.style.top = (window.scrollY - 20) + 'px';
        return
    }
    animate('#menu', {
        translateY: [(window.scrollY + 10)],          // Startet 20px tiefer und gleitet auf 0
        opacity: [0.8, 1],              // Von unsichtbar zu sichtbar
        delay: stagger(100),    // Jedes Element wartet 150ms länger als das vorherige
        duration: 500,
        ease: 'outExpo'
    });
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