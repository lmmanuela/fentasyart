<?php
session_start();
// 1. Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';
$pageTitle = 'My Profile - FENtasyArt';

// 2. Ambil data User yang sedang login
try {
    // Ambil data diri
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // Ambil riwayat booking berdasarkan EMAIL user
    $stmt_bookings = $pdo->prepare("SELECT * FROM bookings WHERE email = ? ORDER BY submitted_at DESC");
    $stmt_bookings->execute([$user['email']]);
    $bookings = $stmt_bookings->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

include 'includes/head.php';
include 'includes/header.php';
?>

<main class="container" style="padding: 40px 20px; min-height: 80vh;">
    <div style="max-width: 950px; margin: 0 auto;">
        
        <div style="display: flex; align-items: center; gap: 25px; margin-bottom: 40px; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <div style="width: 80px; height: 80px; background-color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: bold;">
                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
            </div>
            
            <div style="flex-grow: 1;">
                <h1 style="margin: 0; font-size: 1.8rem; color: var(--dark-color);"><?php echo htmlspecialchars($user['name']); ?></h1>
                <p style="color: var(--gray-color); margin: 5px 0;"><?php echo htmlspecialchars($user['email']); ?></p>
                <div style="margin-top: 10px;">
                    <span style="background: #e2e6ea; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; color: #495057; text-transform: uppercase; letter-spacing: 0.5px;">
                        <?php echo htmlspecialchars($user['role']); ?>
                    </span>
                    <span style="margin-left: 10px; font-size: 12px; color: #aaa;">Member since <?php echo date('Y', strtotime($user['created_at'])); ?></span>
                </div>
            </div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 15px; border: 2px dashed #ffc107; margin-bottom: 35px; display: flex; align-items: center; gap: 20px; box-shadow: 0 5px 15px rgba(255,193,7,0.1);">
            <div style="font-size: 40px;">💳</div>
            <div>
                <h4 style="margin: 0; color: #856404; font-weight: 800;">IMPORTANT: Please Complete Your Payment</h4>
                <p style="margin: 10px 0; color: #555; font-size: 1rem; line-height: 1.6;">
                    To confirm your reservation, please transfer the total amount to:<br>
                    <b>BCA 1234-567-890 (a/n FENtasyArt Creative)</b>.<br>
                    After your transaction is complete, please click the <strong>"Upload Proof"</strong> button below.
                </p>
            </div>
        </div>

        <h3 style="margin-bottom: 20px; color: var(--primary-dark); padding-bottom: 10px; border-bottom: 2px solid #f1f1f1;">My Booking History</h3>
        
        <?php if (isset($_GET['msg'])): ?>
            <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; font-size: 0.9rem;">
                <strong>Success!</strong> <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <?php if (count($bookings) > 0): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
                    <thead style="background-color: #f8f9fa; color: var(--dark-color);">
                        <tr>
                            <th style="padding: 18px 15px; text-align: left; border-bottom: 2px solid #eee;">Item / Activity</th>
                            <th style="padding: 18px 15px; text-align: left; border-bottom: 2px solid #eee;">Date</th>
                            <th style="padding: 18px 15px; text-align: left; border-bottom: 2px solid #eee;">Price</th>
                            <th style="padding: 18px 15px; text-align: center; border-bottom: 2px solid #eee;">Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr style="transition: background 0.2s;">
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                <strong style="color: var(--primary-dark);"><?php echo htmlspecialchars($booking['item_name']); ?></strong>
                                <div style="font-size: 11px; color: #aaa; margin-top: 4px;">
                                    ID: #<?php echo $booking['id']; ?> | Ordered: <?php echo date('d M, H:i', strtotime($booking['submitted_at'])); ?>
                                </div>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; color: #555; font-size: 0.9rem;">
                                <?php 
                                    if ($booking['booking_date']) {
                                        echo date('d M Y', strtotime($booking['booking_date']));
                                    } else {
                                        echo "<span style='color:#999; font-style:italic;'>Check Details</span>"; 
                                    }
                                ?>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: 600; color: var(--primary-color);">
                                <?php echo $booking['item_price']; ?>
                            </td>
                            
                            <td style="padding: 15px; border-bottom: 1px solid #eee; text-align: center;">
                                <?php if ($booking['status'] == 'pending'): ?>
                                    <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase;">
                                        Pending
                                    </span>
                                    <div style="margin-top: 10px;">
                                        <a href="payment.php?id=<?php echo $booking['id']; ?>" 
                                           style="display: inline-block; padding: 5px 12px; background: var(--primary-color); color: white; border-radius: 6px; font-size: 11px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 8px rgba(126, 38, 37, 0.2);">
                                           Upload Proof
                                        </a>
                                    </div>
                                <?php elseif ($booking['status'] == 'paid'): ?>
                                    <span style="background: #cff4fc; color: #055160; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase;">
                                        Waiting Verification
                                    </span>
                                <?php elseif ($booking['status'] == 'verified'): ?>
                                    <span style="background: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase;">
                                        Verified / Success
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px dashed #ccc;">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="Empty" style="width: 60px; opacity: 0.5; margin-bottom: 15px;">
                <p style="color: var(--gray-color); margin-bottom: 20px;">You haven't made any bookings yet.</p>
                <a href="index.php#spaces" class="btn btn-primary">Browse Spaces & Workshops</a>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 50px; text-align: center;">
             <a href="handlers/logout.php" class="btn btn-outline" style="border-color: #dc3545; color: #dc3545; padding: 10px 40px; border-radius: 8px; text-decoration: none;">Sign Out</a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>