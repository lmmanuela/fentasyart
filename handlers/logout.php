<?php
session_start();
session_unset();
session_destroy();

// Redirect kembali ke halaman login setelah logout
header("Location: ../login.php");
exit;
?>