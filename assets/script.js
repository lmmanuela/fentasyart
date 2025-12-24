document.addEventListener('DOMContentLoaded', function() {

    // ========================================================
    // 1. FUNGSI INTI: Toggle Menu Mobile
    // ========================================================
    function toggleMobileMenu() {
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');
        const navLinks = document.querySelectorAll('.nav-link');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                this.classList.toggle('active');
            });

            navLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                        navToggle.classList.remove('active');
                    }
                });
            });

            document.addEventListener('click', function(e) {
                if (navMenu.classList.contains('active') && 
                    !navMenu.contains(e.target) && 
                    !navToggle.contains(e.target)) {
                    navMenu.classList.remove('active');
                    navToggle.classList.remove('active');
                }
            });
        }
    }

    // ========================================================
    // 2. FUNGSI INTI: Smooth Scroll
    // ========================================================
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        links.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    const offsetTop = targetElement.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // ========================================================
    // 3. FUNGSI INTI: Modal Booking
    // ========================================================
    function initModal() {
        const modal = document.getElementById('bookingModal');
        if (!modal) return;

        const closeModalButton = modal.querySelector('.close');
        const bookingButtons = document.querySelectorAll('.space-book, .workshop-book');
        const cancelBookingButton = modal.querySelector('#cancelBooking');
        const closeSuccessMessageButton = modal.querySelector('#closeSuccessMessage');
        const bookingForm = modal.querySelector('#bookingForm');
        const successMessage = modal.querySelector('#bookingSuccessMessage');
        const modalTitle = modal.querySelector('#modalTitle');
        const summaryItemName = modal.querySelector('#summaryItemName');
        const summaryItemDetail = modal.querySelector('#summaryItemDetail');
        const summaryItemPrice = modal.querySelector('#summaryItemPrice');
        const datePickerGroup = modal.querySelector('#date-picker-group');
        const bookingDateInput = modal.querySelector('#bookingDate');

        function openModal() {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('show'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = ' ';
                if (bookingForm) {
                    bookingForm.reset();
                    bookingForm.style.display = 'block';
                }
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 300);
        }

// Listener untuk tombol "Book Now" / "Register Now"
        bookingButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // --- [TAMBAHAN BARU] CEK LOGIN DULU ---
                // Jika variabel isLoggedIn bernilai false (belum login)
                if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
                    // Tampilkan pesan
                    alert('You must be logged in to make a booking.');
                    // Redirect (pindahkan) user ke halaman login
                    window.location.href = 'login.php'; 
                    return; // Hentikan proses, jangan buka modal
                }
                // -------------------------------------

                const card = this.closest('.space-card, .workshop-card');
                if (!card) return;

                // Mengisi data modal berdasarkan kartu yang diklik
                if (card.classList.contains('space-card')) {
                    modalTitle.textContent = 'Space Booking Form';
                    summaryItemName.textContent = card.querySelector('h3').textContent;
                    summaryItemDetail.textContent = 'Daily Rental';
                    summaryItemPrice.textContent = card.querySelector('.space-price').textContent;
                    if (datePickerGroup) datePickerGroup.style.display = 'block';
                    if (bookingDateInput) bookingDateInput.required = true;
                } else if (card.classList.contains('workshop-card')) {
                    modalTitle.textContent = 'Workshop Registration Form';
                    summaryItemName.textContent = card.querySelector('h3').textContent;
                    summaryItemDetail.textContent = `${card.querySelector('.workshop-instructor').textContent} | Date: ${card.querySelector('.workshop-date').textContent}`;
                    summaryItemPrice.textContent = card.querySelector('.workshop-price').textContent;
                    if (datePickerGroup) datePickerGroup.style.display = 'none';
                    if (bookingDateInput) bookingDateInput.required = false;
                }
                openModal();
            });
        });

        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                const submitButton = bookingForm.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.textContent = 'Submitting...';

                const formData = new FormData(bookingForm);
                formData.append('itemName', summaryItemName.textContent);
                formData.append('itemPrice', summaryItemPrice.textContent);

                fetch('handlers/booking_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (successMessage) {
                            bookingForm.style.display = 'none';
                            successMessage.style.display = 'block';
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Confirm Booking';
                });
            });
        }

        if (closeModalButton) closeModalButton.addEventListener('click', closeModal);
        if (cancelBookingButton) cancelBookingButton.addEventListener('click', closeModal);
        if (closeSuccessMessageButton) closeSuccessMessageButton.addEventListener('click', closeModal);
        window.addEventListener('click', e => (e.target === modal) && closeModal());
        document.addEventListener('keydown', e => (e.key === 'Escape') && closeModal());
    }

    // ========================================================
    // 4. FUNGSI INTI: Validasi Form Kontak
    // ========================================================
    function initContactForm() {
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const subject = document.getElementById('subject').value.trim();
                const message = document.getElementById('message').value.trim();

                if (name === '' || email === '' || subject === '' || message === '') {
                    alert('Please fill in all required fields.');
                    e.preventDefault();
                    return;
                }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    alert('Please enter a valid email address.');
                    e.preventDefault();
                    return;
                }
            });
        }
    }

    // ========================================================
    // 5. [BARU] FUNGSI AUTH: Validasi Login & Register
    // ========================================================
    function initAuthForms() {
        // A. Validasi Form Login
        // Kita cari form berdasarkan action-nya agar aman
        const loginForm = document.querySelector('form[action="handlers/login_handler.php"]');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                const email = loginForm.querySelector('input[name="email"]').value.trim();
                const password = loginForm.querySelector('input[name="password"]').value.trim();

                if (!email || !password) {
                    alert('Please enter both email and password.');
                    e.preventDefault();
                }
            });
        }

        // B. Validasi Form Register
        const registerForm = document.querySelector('form[action="handlers/register_handler.php"]');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                const name = registerForm.querySelector('input[name="name"]').value.trim();
                const email = registerForm.querySelector('input[name="email"]').value.trim();
                const password = registerForm.querySelector('input[name="password"]').value;
                const confirmPassword = registerForm.querySelector('input[name="confirm_password"]').value;

                if (!name || !email || !password || !confirmPassword) {
                    alert('Please fill in all fields.');
                    e.preventDefault();
                    return;
                }

                // Cek apakah password cocok
                if (password !== confirmPassword) {
                    alert('Passwords do not match! Please check again.');
                    e.preventDefault();
                    return;
                }
                
                // Cek panjang password (opsional)
                if (password.length < 6) {
                    alert('Password is too short (min. 6 characters).');
                    e.preventDefault();
                    return;
                }
            });
        }
    }

    // ========================================================
    // 6. [BARU] FUNGSI HELPER: Notifikasi URL
    // Menampilkan alert jika ada parameter ?error= atau ?success= di URL
    // ========================================================
// ========================================================
    // FUNGSI BARU: Membuat Notifikasi Estetik
    // ========================================================
    function showToast(title, message, type) {
        // 1. Buat elemen HTML
        const toast = document.createElement('div');
        toast.classList.add('custom-toast', type); // type bisa 'success' atau 'error'
        
        // Icon berdasarkan tipe
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

        toast.innerHTML = `
            <i class="fas ${iconClass}"></i>
            <div class="toast-content">
                <span class="toast-title">${title}</span>
                <span class="toast-msg">${message}</span>
            </div>
        `;

        // 2. Masukkan ke dalam body website
        document.body.appendChild(toast);

        // 3. Tampilkan dengan animasi (kasih delay dikit biar transisi jalan)
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // 4. Hapus otomatis setelah 4 detik
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 500); // Tunggu animasi keluar selesai baru hapus elemen
        }, 4000);
    }

    // ========================================================
    // Handle Alerts Pakai Toast
    // ========================================================
    function handleAuthAlerts() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // A. LOGIN BERHASIL
        if (urlParams.has('login') && urlParams.get('login') === 'success') {
            showToast('Welcome Back!', 'Anda berhasil login.', 'success');
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        // B. ERROR (Login/Register)
        if (urlParams.has('error')) {
            const error = urlParams.get('error');
            
            if (error === 'wrong_credentials') {
                showToast('Login Failed', 'Email atau Password salah.', 'error');
            } else if (error === 'email_taken') {
                showToast('Registration Failed', 'Email ini sudah terdaftar.', 'error');
            } else if (error === 'password_mismatch') {
                showToast('Registration Failed', 'Password tidak cocok.', 'error');
            } else if (error === 'empty_fields') {
                showToast('Warning', 'Mohon isi semua kolom.', 'error');
            } else if (error === 'db_error') {
                showToast('System Error', 'Gangguan koneksi database.', 'error');
            }
            
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        // C. REGISTRASI SUKSES
        if (urlParams.has('success') && urlParams.get('success') === 'registered') {
            showToast('Success!', 'Akun berhasil dibuat. Silakan login.', 'success');
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }

    // ========================================================
    // INISIALISASI
    // ========================================================
    function init() {
        toggleMobileMenu();
        initSmoothScroll();
        initModal();
        initContactForm();
        
        // Panggil fungsi baru untuk Auth
        initAuthForms();
        handleAuthAlerts();

        const bookingDateInput = document.getElementById('bookingDate');
        if (bookingDateInput) {
            bookingDateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
        }
    }

    init();
});