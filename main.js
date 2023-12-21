// Toggle
const toggle = document.querySelector("#toggle-navbar")
const navbar = document.querySelector("#menu-navbar")
if (toggle && navbar) {
    toggle.addEventListener("click", () => {
        navbar.classList.toggle("slide")
        console.log("tess")
    })
}

// Table Button
document.querySelectorAll(".btn.edit").forEach(element => {
    elementEditAlert(element);
});
document.querySelectorAll(".btn.delete").forEach(element => {
    elementDeleteAlert(element);
});

// Custom Option Input
document.querySelectorAll('.custom-option').forEach(element => {
    elementCustomOption(element, element.parentNode)
});


// Custom Option
function elementCustomOption(option, parrent) {
    parrent.onchange = (event) => {
        const input = event.target.value;
        if (input != option.value) {return}

        const container = parrent.parentNode
        let className = parrent.className
        let id = parrent.id
        parrent.outerHTML = `<input type="text" class="${className}" id="${id}" name="${parrent.name}">`

        const nParrent = container.querySelector(`#${id}`)
        nParrent.focus()
    }
}

// Edit Alert
function elementEditAlert(button) {
    const href = button.getAttribute("href")

    button.addEventListener("click", () => {
        location.href = href
    })
}

// Delete Alert
function elementDeleteAlert(button) {
    const href = button.getAttribute("href")

    button.addEventListener("click", () => {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data yang sudah dihapus tidak bisa kembali",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = href
            }
        });
    })
}