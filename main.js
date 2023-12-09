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