<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Access Denied");
}

function uploadImage($fileInputName) {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] != 0) {
        return "https://via.placeholder.com/400x300?text=No+Image"; 
    }
    $targetDir = "../assets/uploads/";
    if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
    $fileName = time() . "_" . basename($_FILES[$fileInputName]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFilePath)) {
            return "assets/uploads/" . $fileName; 
        }
    }
    return "https://via.placeholder.com/400x300?text=Upload+Failed";
}

if (isset($_GET['action'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] == 'delete_space') {
        $pdo->prepare("DELETE FROM spaces WHERE id = ?")->execute([$id]);
        header("Location: ../admin_dashboard.php?msg=Space Deleted");
    } 
    elseif ($_GET['action'] == 'delete_workshop') {
        $pdo->prepare("DELETE FROM workshops WHERE id = ?")->execute([$id]);
        header("Location: ../admin_dashboard.php?msg=Workshop Deleted");
    }
    elseif ($_GET['action'] == 'delete_booking') {
        $pdo->prepare("DELETE FROM bookings WHERE id = ?")->execute([$id]);
        header("Location: ../admin_dashboard.php?msg=Booking Record Removed");
    }
    elseif ($_GET['action'] == 'verify_payment') {
        $pdo->prepare("UPDATE bookings SET status = 'verified' WHERE id = ?")->execute([$id]);
        header("Location: ../admin_dashboard.php?msg=Payment Verified Successfully");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'add_space') {
        $imgUrl = uploadImage('image');
        $sql = "INSERT INTO spaces (name, description, price_per_day, image_url, stock) VALUES (?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$_POST['name'], $_POST['description'], $_POST['price'], $imgUrl, $_POST['stock']]);
        header("Location: ../admin_dashboard.php?msg=Space Added");
    } 
    elseif ($action == 'update_stock_space') {
        $pdo->prepare("UPDATE spaces SET stock = ? WHERE id = ?")->execute([$_POST['stock'], $_POST['id']]);
        header("Location: ../admin_dashboard.php?msg=Space Stock Updated");
    }
    elseif ($action == 'update_stock_workshop') {
        $pdo->prepare("UPDATE workshops SET stock = ? WHERE id = ?")->execute([$_POST['stock'], $_POST['id']]);
        header("Location: ../admin_dashboard.php?msg=Workshop Stock Updated");
    }
    exit;
}