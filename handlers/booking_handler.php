<?php
// handlers/booking_handler.php
header('Content-Type: application/json');
require_once '../config/db.php';

$response = ['success' => false, 'message' => 'Invalid request.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil Data
    $itemName = trim(filter_input(INPUT_POST, 'itemName', FILTER_SANITIZE_STRING));
    $itemPrice = trim(filter_input(INPUT_POST, 'itemPrice', FILTER_SANITIZE_STRING)); // String harga (bisa diabaikan untuk logic stok)
    $name = trim(filter_input(INPUT_POST, 'bookingName', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'bookingEmail', FILTER_SANITIZE_EMAIL));
    $phone = trim(filter_input(INPUT_POST, 'bookingPhone', FILTER_SANITIZE_STRING));
    $notes = trim(filter_input(INPUT_POST, 'bookingNotes', FILTER_SANITIZE_STRING));
    
    $bookingDate = trim($_POST['bookingDate']);
    if (empty($bookingDate)) $bookingDate = null;

    if (empty($name) || empty($email) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        exit;
    }

    try {
        // MULAI TRANSAKSI (Penting agar data konsisten)
        $pdo->beginTransaction();

        // 2. Cek Stok di SPACES dulu
        $stmtSpace = $pdo->prepare("SELECT id, stock FROM spaces WHERE name = ? LIMIT 1");
        $stmtSpace->execute([$itemName]);
        $space = $stmtSpace->fetch();

        $itemFound = false;
        $isSpace = false;
        
        if ($space) {
            $itemFound = true;
            $isSpace = true;
            $currentStock = $space['stock'];
            $itemId = $space['id'];
        } else {
            // 3. Kalau bukan Space, cek di WORKSHOPS
            $stmtWs = $pdo->prepare("SELECT id, stock FROM workshops WHERE title = ? LIMIT 1");
            $stmtWs->execute([$itemName]);
            $workshop = $stmtWs->fetch();
            
            if ($workshop) {
                $itemFound = true;
                $isSpace = false;
                $currentStock = $workshop['stock'];
                $itemId = $workshop['id'];
            }
        }

        // 4. Validasi Stok
        if (!$itemFound) {
            throw new Exception("Item not found in database.");
        }

        if ($currentStock <= 0) {
            throw new Exception("Sorry, fully booked! No stock available.");
        }

        // 5. Kurangi Stok
        if ($isSpace) {
            $updateStmt = $pdo->prepare("UPDATE spaces SET stock = stock - 1 WHERE id = ?");
        } else {
            $updateStmt = $pdo->prepare("UPDATE workshops SET stock = stock - 1 WHERE id = ?");
        }
        $updateStmt->execute([$itemId]);

        // 6. Simpan Data Booking
        $sql = "INSERT INTO bookings (item_name, item_price, full_name, email, phone, booking_date, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $pdo->prepare($sql);
        $stmtInsert->execute([$itemName, $itemPrice, $name, $email, $phone, $bookingDate, $notes]);

        // COMMIT TRANSAKSI
        $pdo->commit();

        $response['success'] = true;
        $response['message'] = 'Booking successful! Stock updated.';

    } catch (Exception $e) {
        // Rollback jika ada error (stok tidak jadi berkurang)
        $pdo->rollBack();
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
exit;
?>