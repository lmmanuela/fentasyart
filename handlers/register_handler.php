<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (Validasi input sama seperti sebelumnya) ...
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password)) {
        header("Location: ../register.php?error=empty_fields");
        exit;
    }

    if ($password !== $confirm_password) {
        header("Location: ../register.php?error=password_mismatch");
        exit;
    }

    try {
        // Cek email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            header("Location: ../register.php?error=email_taken");
            exit;
        }

        // --- BAGIAN YANG DIUBAH ---
        // HAPUS: $hashed_password = password_hash(...);
        // GANTI: Langsung simpan $password mentah
        
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt = $pdo->prepare($sql);
        
        // Perhatikan parameter ke-3 sekarang adalah $password (bukan $hashed_password)
        $stmt->execute([$name, $email, $password]); 
        // --------------------------

        header("Location: ../login.php?success=registered");
        exit;

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        exit;
    }
}
?>