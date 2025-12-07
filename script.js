// Toggle the navbar menu when hamburger icon is clicked
const navbarNav = document.querySelector('.navbar-nav');
const extra = document.querySelector('#menu');

extra.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent event from bubbling to document
    navbarNav.classList.toggle('active'); // Toggle 'active' class on .navbar-nav
});

// Close the menu if user clicks outside of it
document.addEventListener('click', (e) => {
    if (!navbarNav.contains(e.target) && !extra.contains(e.target)) {
        navbarNav.classList.remove('active'); // Remove 'active' class
    }
});

// Pastikan file script.js terhubung ke file HTML
document.querySelectorAll('.contact-link').forEach(link => {
    link.addEventListener('click', (e) => {
        console.log('Link kontak diklik!');
        // Jika Anda ingin mencegah aksi default untuk keperluan uji coba:
    });
});



const navLinks = document.querySelectorAll('.navbar-nav a');
navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        if (link.href.startsWith('https://wa.me/')) return; // Biarkan default untuk link eksternal

        const targetId = link.getAttribute('href');
        const targetSection = document.querySelector(targetId);

        if (targetSection) { // Hanya cegah default jika target ditemukan
            e.preventDefault();
            window.scrollTo({
                top: targetSection.offsetTop - 80,
                behavior: 'smooth'
            });
            navLinks.forEach(navLink => navLink.classList.remove('active'));
            link.classList.add('active');
        }
    });
});

// ===== UPDATE MODAL UNTUK PAKET =====
function openPaketModal(id, paket, harga) {
    document.getElementById('updateId').value = id;
    document.getElementById('updatePaket').value = paket;
    document.getElementById('updateHarga').value = harga;
    document.getElementById('updateModal').style.display = 'block';
}

// ===== UPDATE MODAL UNTUK TOKEN =====
function openTokenModal(id, isi, harga) {
    document.getElementById('updateId').value = id;
    document.getElementById('updateToken').value = isi;
    document.getElementById('updateHarga').value = harga;
    document.getElementById('updateModal').style.display = 'block';
}

// ===== UPDATE MODAL UNTUK E-WALLET =====
function openEwalletModal(id, isi, harga) {
    document.getElementById('updateId').value = id;
    document.getElementById('updateEwallet').value = isi;
    document.getElementById('updateHarga').value = harga;
    document.getElementById('updateModal').style.display = 'block';
}

// ===== UPDATE MODAL UNTUK PULSA =====
function openPulsaModal(id, isi, harga) {
    document.getElementById('updateId').value = id;
    document.getElementById('updatePulsa').value = isi;
    document.getElementById('updateHarga').value = harga;
    document.getElementById('updateModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('updateModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('updateModal');
    if (event.target === modal) {
        closeModal();
    }

    const cartSidebar = document.getElementById("cartSidebar");
const cartIcon = document.querySelector(".cart-icon");
const closeCartBtn = document.getElementById("closeCartBtn");

cartIcon.addEventListener("click", function (e) {
    e.preventDefault();
    cartSidebar.classList.add("active");
});

closeCartBtn.addEventListener("click", function () {
    cartSidebar.classList.remove("active");
});
};