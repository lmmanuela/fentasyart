<?php
// handlers/contact_handler.php

// 1. Periksa apakah metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Sertakan koneksi database
    require_once '../config/db.php';

    // 3. Ambil dan bersihkan data
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING));
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));

    // 4. Validasi (Sederhana)
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Gagal validasi, kembalikan ke kontak dengan error
        header("Location: ../contact.php?status=error");
        exit;
    }

    // 5. Masukkan ke database menggunakan prepared statements
    try {
        $sql = "INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $subject, $message]);

        // 6. Redirect kembali ke halaman kontak dengan pesan sukses
        header("Location: ../contact.php?status=success");
        exit;

    } catch (PDOException $e) {
        // Tangani error database
        // Sebaiknya catat error ini: error_log($e->getMessage());
        header("Location: ../contact.php?status=dberror");
        exit;
    }

} else {
    // Jika diakses langsung, redirect ke halaman utama
    header("Location: ../index.php");
    exit;
}
?>