function isEmpty(str) {
    return (str.trim() == '')
}

function debounce(func, delay) {
    let timerId;
    return function(...args) {
        clearTimeout(timerId);
        timerId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
}

function formFill(target, filltg) {
    const url = window.location.href
    const elmntNik = document.querySelector(`#fgroup-${target}-nik`)
    const elmntNama = document.querySelector(`#fgroup-${target}-nama`)
    const inputNik = elmntNik.querySelector("input")
    const inputNama = elmntNama.querySelector("input")
    const statusNik = elmntNik.querySelector(".check-status")
    const statusNama = elmntNama.querySelector(".check-status")
    const parrent = document.querySelector(`#fill-${target}`)
    
    const fillForm = async() => {
        let nik = inputNik.value
        let nama = inputNama.value
        let formData = new FormData()
        formData.append('nik', nik)
        formData.append('nama', nama)
        formData.append(filltg, target)
        const param = new URLSearchParams(formData);
        let resp = await fetch(
            `${url}?${param}`, 
            {method: 'GET'}
        )
        
        // Get
        resp = await resp.text()
        if (resp.indexOf("<!-- check-status-nik-true -->") != -1) {
            statusNik.innerHTML = "<i class='ri-check-line ri-xl text-primary'></i>"
        } else {
            statusNik.innerHTML = "<i class='ri-close-line ri-xl text-secondary'></i>"
        }
        if (resp.indexOf("<!-- check-status-nama-true -->") != -1) {
            statusNama.innerHTML = "<i class='ri-check-line ri-xl text-primary'></i>"
        } else {
            statusNama.innerHTML = "<i class='ri-close-line ri-xl text-secondary'></i>"
        }
        parrent.innerHTML = resp
    }

    inputNik.addEventListener("input", debounce(fillForm, 500))
    inputNama.addEventListener("input", debounce(fillForm, 500))   
}