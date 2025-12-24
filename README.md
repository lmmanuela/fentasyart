<div align="center">

  <img src="https://via.placeholder.com/1200x300?text=FENtasyArt+Project+Banner" alt="FENtasyArt Banner" width="100%">

  # 🎨 FENtasyArt
  **Integrated Creative Space & Workshop Management Platform**

  <p>
    <a href="#-tech-stack">
      <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version" />
    </a>
    <a href="#-tech-stack">
      <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap Version" />
    </a>
    <a href="#-tech-stack">
      <img src="https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    </a>
     <a href="#-license">
      <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License" />
    </a>
  </p>

  <p>
    <a href="#-about-the-project">About</a> •
    <a href="#-key-features">Features</a> •
    <a href="#-installation--setup">Installation</a> •
    <a href="#-usage">Usage</a> •
    <a href="#-contributing">Contributing</a>
  </p>
</div>

---

## 📖 About The Project

**FENtasyArt** adalah platform manajemen berbasis web yang dirancang khusus untuk memfasilitasi para seniman dan kreator dalam menemukan serta memesan ruang kerja kreatif (*creative space*) serta mendaftarkan diri pada berbagai workshop seni secara instan dan terorganisir.

Di era digital ini, akses terhadap ruang fisik untuk berkarya seringkali menjadi hambatan. FENtasyArt hadir sebagai jembatan ekosistem seni yang efisien dan modern.

### 🚩 Masalah yang Dipecahkan (Problem Statement)
Proyek ini dikembangkan untuk menjawab tantangan nyata dalam komunitas kreatif:
* **Fragmentasi Informasi:** Mengatasi sulitnya menemukan jadwal workshop seni yang akurat karena informasi yang seringkali tercecer di berbagai platform media sosial.
* **Proses Reservasi Konvensional:** Menghilangkan friksi dalam pemesanan studio yang masih dilakukan secara manual (chat/telepon) dengan beralih ke sistem *booking* otomatis.
* **Manajemen Kuota:** Membantu penyelenggara workshop mengelola jumlah peserta secara sistematis (validasi otomatis) untuk menghindari masalah *over-capacity*.

---

## 🛠 Tech Stack

Sistem ini dibangun menggunakan kombinasi teknologi modern untuk memastikan performa yang stabil, antarmuka yang responsif, dan pengelolaan data yang aman.

| Component | Technology | Description |
| :--- | :--- | :--- |
| **Backend** | ![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white) | PHP 8.x untuk logika bisnis dan pemrosesan data server-side. |
| **Database** | ![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white) | Relational Database Management System untuk penyimpanan data. |
| **Frontend** | ![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?logo=bootstrap&logoColor=white) | Framework CSS untuk desain responsif dan *mobile-first*. |
| **Scripting** | ![jQuery](https://img.shields.io/badge/jQuery-0769AD?logo=jquery&logoColor=white) | Manipulasi DOM dan interaktivitas UI yang dinamis. |
| **Assets** | ![FontAwesome](https://img.shields.io/badge/Font_Awesome-339AF0?logo=fontawesome&logoColor=white) | Ikon vektor dan tipografi Google Fonts. |

---

## ✨ Key Features

Berikut adalah fitur unggulan yang diimplementasikan dalam FENtasyArt:

1.  🗓️ **Smart Booking System**
    Fitur pemesanan ruang kreatif secara *real-time* dengan algoritma pengecekan ketersediaan slot otomatis, mencegah *double-booking*.

2.  🎨 **Workshop Discovery & Registration**
    Katalog workshop interaktif yang memudahkan user mengeksplorasi kelas seni berdasarkan kategori dan melakukan pendaftaran langsung dalam satu platform.

3.  📊 **Centralized Admin Dashboard**
    Panel kendali komprehensif bagi pengelola untuk memantau statistik pemesanan, mengelola inventaris ruang, dan memvalidasi peserta workshop.

4.  🔄 **Automated Status Tracking**
    Transparansi alur transaksi dengan sistem pelacakan status pesanan (*Pending, Verified, Success*) yang memberikan notifikasi visual bagi pengguna.

5.  📱 **Responsive Art Gallery**
    Antarmuka katalog ruang dan kegiatan yang dioptimalkan untuk perangkat *mobile* maupun desktop dengan estetika visual yang tinggi.

---

## 🚀 Installation & Setup

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda (Localhost).

### Prerequisites
Pastikan Anda telah menginstal software berikut:
* **XAMPP / Laragon** (Pastikan PHP v8.x dan MySQL berjalan).
* **Web Browser** (Chrome, Firefox, Edge).
* **Git** (Opsional, untuk cloning).

### Langkah Instalasi

1.  **Clone Repository**
    Buka terminal (Git Bash/CMD) dan arahkan ke folder `htdocs` (jika menggunakan XAMPP).
    ```bash
    cd C:/xampp/htdocs
    git clone [https://github.com/username-anda/fentasyart.git](https://github.com/username-anda/fentasyart.git)
    ```

2.  **Konfigurasi Database**
    * Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
    * Buat database baru dengan nama: `db_fentasyart`.
    * Import file database yang disertakan di dalam folder project:
        `database/db_fentasyart.sql`

3.  **Konfigurasi Koneksi (Opsional)**
    Jika Anda menggunakan password database yang berbeda (bukan default kosong), edit file `config/database.php` (atau file koneksi Anda):
    ```php
    $host = "localhost";
    $user = "root";      // Username database
    $pass = "";          // Password database
    $db   = "db_fentasyart";
    ```

4.  **Jalankan Aplikasi**
    Buka browser dan akses URL berikut:
    ```
    http://localhost/fentasyart
    ```

---

## 💻 Usage

### Untuk Pengunjung (User)
1.  **Register/Login:** Buat akun baru untuk mulai memesan.
2.  **Eksplorasi:** Lihat katalog "Creative Space" atau "Workshop".
3.  **Booking:** Pilih tanggal dan slot waktu yang tersedia, lalu konfirmasi pesanan.
4.  **Cek Status:** Pantau status persetujuan admin melalui menu "Riwayat Pesanan".

### Untuk Administrator
1.  Login melalui halaman `/admin` (Gunakan kredensial admin default jika ada).
2.  Gunakan **Dashboard** untuk melihat ringkasan pendapatan.
3.  Masuk ke menu **Validasi** untuk menyetujui atau menolak bukti pembayaran user.
4.  Gunakan menu **Kelola Workshop** untuk menambah jadwal acara baru.

---

## 📂 Project Structure

Struktur direktori proyek disusun dengan pola yang rapi untuk memudahkan pengembangan:

```text
fentasyart/
├── assets/             # File statis (CSS, JS, Images, Fonts)
├── config/             # Konfigurasi koneksi database & helper
├── controllers/        # Logika pemrosesan data (Backend)
├── database/           # File backup SQL (db_fentasyart.sql)
├── views/              # Tampilan antarmuka (User & Admin views)
│   ├── admin/          # Folder khusus view admin
│   └── user/           # Folder khusus view user
├── uploads/            # Direktori penyimpanan bukti bayar/gambar
├── index.php           # Entry point aplikasi
└── README.md           # Dokumentasi Proyek

```

---

## 🤝 Contributing

Kontribusi sangat diterima untuk pengembangan fitur masa depan!

1. Fork repository ini.
2. Buat branch fitur baru (`git checkout -b fitur-keren`).
3. Commit perubahan Anda (`git commit -m 'Menambahkan fitur keren'`).
4. Push ke branch (`git push origin fitur-keren`).
5. Buat **Pull Request**.

---

## 📄 License

Proyek ini didistribusikan di bawah lisensi **MIT**. Lihat file `LICENSE` untuk informasi lebih lanjut.

---

## 👤 Author

**[Nama Lengkap Anda]**

* **Role:** Lead Developer & System Analyst
* **Institution:** [Nama Universitas/Kampus]
* **Connect with me:**


---

<div align="center">
<i>Dibuat dengan ❤️ sebagai tugas Final Project / UAS 2025.</i>
</div>

```

-----

### Tips Tambahan dari Sisi *Technical Writer*:

1.  **Placeholder Gambar:** Pada bagian paling atas (`<img src="... via.placeholder.com ...">`), ganti URL tersebut dengan *screenshot* nyata dari *landing page* website FENtasyArt Anda. Visual adalah kunci daya tarik utama.
2.  **Struktur Folder:** Saya membuatkan struktur folder imajiner (Project Structure) yang umum digunakan pada PHP Native/MVC. **Pastikan** Anda menyesuaikannya dengan struktur folder asli di komputer Anda agar akurat.
3.  **Kredensial:** Jika ada akun admin default (misal: admin/admin123), sebaiknya tuliskan di bagian **Usage** agar dosen/penguji bisa langsung masuk tanpa harus membuka database.

Apakah Anda ingin saya bantu buatkan file `.sql` dummy atau deskripsi untuk tabel database-nya juga?

```
