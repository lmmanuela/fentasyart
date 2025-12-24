<?php
session_start();
require_once '../config/db.php';

// 1. Pastikan User sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// 2. Proses hanya jika ada request POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    
    // Pengaturan folder penyimpanan
    // Kita simpan di assets/uploads/payments/
    $targetDir = "../assets/uploads/payments/";
    
    // Buat folder otomatis jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // 3. Logika Upload File
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
        $fileExtension = strtolower(pathinfo($_FILES["payment_proof"]["name"], PATHINFO_EXTENSION));
        // Beri nama unik agar tidak bentrok (waktu + id booking)
        $newFileName = "PAY_" . time() . "_" . $booking_id . "." . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;

        // Validasi format file
        $allowedTypes = array('jpg', 'jpeg', 'png', 'webp');
        if (in_array($fileExtension, $allowedTypes)) {
            // Pindahkan file dari folder sementara ke folder tujuan
            if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $targetFilePath)) {
                
                // 4. Update Database
                // Status diubah menjadi 'paid' agar muncul di dashboard admin untuk diverifikasi
                try {
                    $stmt = $pdo->prepare("UPDATE bookings SET status = 'paid', payment_proof = ? WHERE id = ?");
                    $stmt->execute([$newFileName, $booking_id]);
                    
                    // Redirect kembali ke profil dengan pesan sukses
                    header("Location: ../profile.php?msg=Bukti pembayaran berhasil diunggah. Mohon tunggu verifikasi admin.");
                } catch (PDOException $e) {
                    // Jika database error
                    header("Location: ../profile.php?error=Gagal memperbarui database.");
                }
            } else {
                header("Location: ../payment.php?id=$booking_id&error=Gagal mengupload file ke server.");
            }
        } else {
            header("Location: ../payment.php?id=$booking_id&error=Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.");
        }
    } else {
        header("Location: ../payment.php?id=$booking_id&error=Silakan pilih file bukti transfer.");
    }
    exit;
} else {
    // Jika diakses langsung tanpa POST
    header("Location: ../index.php");
    exit;
}