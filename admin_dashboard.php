<?php
session_start();
require_once 'config/db.php';

// 1. Proteksi Halaman Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$pageTitle = 'Admin Dashboard - FENtasyArt';
include 'includes/head.php';
include 'includes/header.php';

// 2. Ambil Data
$spaces = $pdo->query("SELECT * FROM spaces ORDER BY id DESC")->fetchAll();
$workshops = $pdo->query("SELECT * FROM workshops ORDER BY id DESC")->fetchAll();
$bookings = $pdo->query("SELECT * FROM bookings ORDER BY submitted_at DESC")->fetchAll();
?>

<style>
    /* Style Tab & UI */
    .tab-btn {
        padding: 10px 20px;
        border: 2px solid var(--primary-color);
        background-color: transparent;
        color: var(--primary-color);
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 10px;
    }
    .tab-btn:hover, .tab-btn.active {
        background-color: var(--primary-color);
        color: white;
    }

    /* Badge Status Transaksi */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .status-paid { background: #cff4fc; color: #055160; border: 1px solid #bbeeef; }
    .status-verified { background: #d1e7dd; color: #0f5132; border: 1px solid #c3e6cb; }

    /* Thumbnail Bukti Transfer */
    .proof-thumb {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #eee;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .proof-thumb:hover {
        transform: scale(1.1);
        border-color: var(--primary-color);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .placeholder-icon {
        width: 50px;
        height: 40px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #adb5bd;
    }
    
    table img {
        border-radius: 4px;
        object-fit: cover;
    }
</style>

<div class="container" style="padding: 40px 20px;">
    <h1 class="section-title">Admin Dashboard</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 15px; background: #d4edda; color: #155724; margin-bottom: 20px; border-radius: 8px; border: 1px solid #c3e6cb;">
            <strong>Success!</strong> <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 15px;">
        <button id="btn-spaces" onclick="showSection('spaces')" class="tab-btn active">Manage Spaces</button>
        <button id="btn-workshops" onclick="showSection('workshops')" class="tab-btn">Manage Workshops</button>
        <button id="btn-bookings" onclick="showSection('bookings')" class="tab-btn">Incoming Bookings & Payments</button>
    </div>

    <div id="section-spaces">
        <h2 style="color: var(--primary-color); margin-bottom: 15px;">Spaces Management</h2>
        <div style="overflow-x: auto; margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <thead style="background: var(--primary-color); color: white;">
                    <tr>
                        <th style="padding: 12px;">Image</th>
                        <th style="padding: 12px;">Name</th>
                        <th style="padding: 12px;">Price</th>
                        <th style="padding: 12px;">Stock</th>
                        <th style="padding: 12px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($spaces as $space): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><img src="<?= htmlspecialchars($space['image_url']) ?>" width="80" height="60"></td>
                        <td style="padding: 10px;"><strong><?= htmlspecialchars($space['name']) ?></strong></td>
                        <td style="padding: 10px;">IDR <?= number_format($space['price_per_day']) ?></td>
                        <td style="padding: 10px;">
                            <form action="handlers/admin_handler.php" method="POST" style="display: flex; gap: 5px;">
                                <input type="hidden" name="action" value="update_stock_space">
                                <input type="hidden" name="id" value="<?= $space['id'] ?>">
                                <input type="number" name="stock" value="<?= $space['stock'] ?>" style="width: 50px; padding: 5px;">
                                <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.7rem;">Save</button>
                            </form>
                        </td>
                        <td style="padding: 10px;"><a href="handlers/admin_handler.php?action=delete_space&id=<?= $space['id'] ?>" onclick="return confirm('Delete this space?')" style="color: red;">Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="section-workshops" style="display: none;">
        <h2 style="color: var(--secondary-color); margin-bottom: 15px;">Workshops Management</h2>
        <div style="overflow-x: auto; margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <thead style="background: var(--secondary-color); color: white;">
                    <tr>
                        <th style="padding: 12px;">Image</th>
                        <th style="padding: 12px;">Title</th>
                        <th style="padding: 12px;">Instructor</th>
                        <th style="padding: 12px;">Stock</th>
                        <th style="padding: 12px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($workshops as $ws): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><img src="<?= htmlspecialchars($ws['image_url']) ?>" width="80" height="60"></td>
                        <td style="padding: 10px;"><strong><?= htmlspecialchars($ws['title']) ?></strong></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($ws['instructor']) ?></td>
                        <td style="padding: 10px;">
                            <form action="handlers/admin_handler.php" method="POST" style="display: flex; gap: 5px;">
                                <input type="hidden" name="action" value="update_stock_workshop">
                                <input type="hidden" name="id" value="<?= $ws['id'] ?>">
                                <input type="number" name="stock" value="<?= $ws['stock'] ?>" style="width: 50px; padding: 5px;">
                                <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.7rem;">Save</button>
                            </form>
                        </td>
                        <td style="padding: 10px;"><a href="handlers/admin_handler.php?action=delete_workshop&id=<?= $ws['id'] ?>" onclick="return confirm('Delete workshop?')" style="color: red;">Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="section-bookings" style="display: none;">
        <h2 style="color: #333; margin-bottom: 20px;">Transactions & Booking Management</h2>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <thead style="background: #333; color: white;">
                    <tr>
                        <th style="padding: 15px; text-align: left;">User Info</th>
                        <th style="padding: 15px; text-align: left;">Item Booked</th>
                        <th style="padding: 15px; text-align: center;">Proof</th>
                        <th style="padding: 15px; text-align: center;">Status</th>
                        <th style="padding: 15px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $bk): ?>
                    <tr style="border-bottom: 1px solid #f1f1f1;">
                        <td style="padding: 15px;">
                            <strong style="color: #333;"><?= htmlspecialchars($bk['full_name']) ?></strong><br>
                            <span style="font-size: 0.8rem; color: #666;"><?= htmlspecialchars($bk['email']) ?></span><br>
                            <small style="color: #999;"><?= date('d M Y, H:i', strtotime($bk['submitted_at'])) ?></small>
                        </td>

                        <td style="padding: 15px;">
                            <span style="color: var(--primary-color); font-weight: 600;"><?= htmlspecialchars($bk['item_name']) ?></span><br>
                            <small style="color: #666;">IDR <?= $bk['item_price'] ?></small>
                        </td>

                        <td style="padding: 15px; text-align: center;">
                            <?php if (!empty($bk['payment_proof'])): ?>
                                <a href="assets/uploads/payments/<?= htmlspecialchars($bk['payment_proof']) ?>" target="_blank" title="Click to view full size">
                                    <img src="assets/uploads/payments/<?= htmlspecialchars($bk['payment_proof']) ?>" class="proof-thumb">
                                </a>
                            <?php else: ?>
                                <div class="placeholder-icon">📷</div>
                                <span style="font-size: 0.7rem; color: #adb5bd;">Waiting...</span>
                            <?php endif; ?>
                        </td>

                        <td style="padding: 15px; text-align: center;">
                            <span class="status-badge status-<?= $bk['status'] ?>">
                                <?= $bk['status'] ?>
                            </span>
                        </td>

                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <?php if ($bk['status'] == 'paid'): ?>
                                    <a href="handlers/admin_handler.php?action=verify_payment&id=<?= $bk['id'] ?>" 
                                       class="btn btn-primary" 
                                       style="padding: 6px 12px; font-size: 0.75rem; background: #28a745; border: none;">
                                       Verify
                                    </a>
                                <?php endif; ?>
                                
                                <a href="handlers/admin_handler.php?action=delete_booking&id=<?= $bk['id'] ?>" 
                                   onclick="return confirm('Remove this record?')" 
                                   style="padding: 6px 12px; font-size: 0.75rem; color: #dc3545; border: 1px solid #dc3545; border-radius: 4px; text-decoration: none;">
                                   Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(empty($bookings)) echo "<p style='padding:40px; text-align:center; color:#999;'>No booking records yet.</p>"; ?>
        </div>
    </div>

</div>

<script>
    function showSection(section) {
        // Sembunyikan semua
        document.getElementById('section-spaces').style.display = 'none';
        document.getElementById('section-workshops').style.display = 'none';
        document.getElementById('section-bookings').style.display = 'none';
        
        // Reset tombol
        document.getElementById('btn-spaces').classList.remove('active');
        document.getElementById('btn-workshops').classList.remove('active');
        document.getElementById('btn-bookings').classList.remove('active');

        // Tampilkan yang dipilih
        document.getElementById('section-' + section).style.display = 'block';
        document.getElementById('btn-' + section).classList.add('active');
    }
</script>

<?php include 'includes/footer.php'; ?>