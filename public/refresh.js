document.addEventListener('DOMContentLoaded', function () {
    const currentUrl = window.location.href;

    let timeOut = 5000
    if (typeof local_timeout !== 'undefined') {
        timeOut = local_timeout
    }

    let elements = document.querySelectorAll('.replaceMe')
    let replaces = []
    elements.forEach(element => {
        let id = element.id;
        if ('' === String(id).trim()) {
            element.style.border = '2px solid red';
            element.style.background = 'red';
            element.style.color = 'blue';
            return
        }

        replaces.push(id)
    })
    if (0 === replaces.length){
        return
    }
    setInterval(function () {
        fetch(currentUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                return response.text();
            })
            .then(data => {
                const parser = new DOMParser()
                const doc = parser.parseFromString(data, "text/html")
                replaces.forEach(id => {
                    let replace = ''
                    if (doc.getElementById(id)) {
                        replace = doc.getElementById(id).innerHTML
                    }
                    document.getElementById(id).innerHTML = replace
                })
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    }, timeOut);
});
