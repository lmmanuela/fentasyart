<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password']; // Password yang diinput user saat login

    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=empty_fields");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // --- BAGIAN YANG DIUBAH ---
        // HAPUS: password_verify($password, $user['password'])
        // GANTI: Cek apakah string password sama persis
        
        if ($user && $password === $user['password']) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // --- PERBAIKAN LOGIC REDIRECT ---
            if ($user['role'] === 'admin') {
                // Jika admin, langsung ke dashboard
                header("Location: ../admin_dashboard.php");
            } else {
                // Jika user biasa, ke halaman utama
                header("Location: ../index.php?login=success");
            }
            // --------------------------------
            
            exit;
        } else {
            header("Location: ../login.php?error=wrong_credentials");
            exit;
        }
        // --------------------------

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        exit;
    }
}
?>