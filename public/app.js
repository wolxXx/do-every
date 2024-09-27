function captureConfirmElements() {
    document.querySelectorAll('.confirm').forEach(element => {
        if (element.getAttribute('data-captured')) {
            return;
        } else {
            element.setAttribute('data-captured', 'true');
        }

        element.addEventListener('click', (e) => {
            if (!confirm('Bist du sicher?')) {
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
}

function initRowAdder() {
    document.querySelectorAll('.rowAdder').forEach(function (element) {
        element.addEventListener('click', function () {
            let index = element.parentElement.querySelectorAll('.rowRemover').length + 1;
            index = '' + index;
            let newRow = document.createElement('div');
            newRow.innerHTML = element.parentElement.querySelector('template').innerHTML.replaceAll('__INDEX__', index);
            element.parentElement.appendChild(newRow);
            initRowRemover();
        });
    });
}

function initRowRemover() {
    document.querySelectorAll('.rowRemover').forEach(function (element) {
        if ('1' === element.dataset['bound']) {
            return;
        }
        element.addEventListener('click', function () {
            element.closest('.row').remove();
        });
        element.dataset['bound'] = '1';
    });
}

function dragstartHandler(ev) {
    // Add different types of drag data
    ev.dataTransfer.setData("text/plain", ev.target.innerText);
    ev.dataTransfer.setData("text/html", ev.target.outerHTML);
    ev.dataTransfer.setData(
        "text/uri-list",
        ev.target.ownerDocument.location.href,
    );
}



function initDragHAndler() {
    // Get the element by id
    document.querySelectorAll('*[draggable="true"]').forEach(function (element) {
        console.log(element)
        element.addEventListener("dragstart", dragstartHandler);
    });
}

function dragoverHandler(ev) {
    ev.preventDefault();
    ev.dataTransfer.dropEffect = "move";
}

function dropHandler(ev) {
    ev.preventDefault();
    // Get the id of the target and add the moved element to the target's DOM
    const data = ev.dataTransfer.getData("text/plain");
    ev.target.appendChild(document.getElementById(data));
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
    initDragHAndler();
});