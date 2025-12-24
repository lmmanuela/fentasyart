<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$booking_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

$pageTitle = 'Payment Confirmation';
include 'includes/head.php';
include 'includes/header.php';
?>

<main class="container" style="padding: 60px 20px;">
    <div style="max-width: 550px; margin: 0 auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: var(--primary-dark); margin-bottom: 10px;">Payment Confirmation</h2>
            <p style="color: #666; font-size: 0.95rem;">Please complete your payment to secure your booking.</p>
        </div>

        <div style="background: #fdf2f2; padding: 20px; border-radius: 12px; margin-bottom: 30px; border: 1px dashed var(--primary-color);">
            <p style="margin: 0 0 10px 0; font-size: 0.85rem; color: #888; text-transform: uppercase; letter-spacing: 1px;">Transfer To:</p>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-weight: 700; color: #333; font-size: 1.1rem;">Bank BCA</p>
                    <p style="margin: 5px 0; font-size: 1.4rem; color: var(--primary-color); font-weight: 800; letter-spacing: 1px;">1234-567-890</p>
                    <p style="margin: 0; font-size: 0.9rem; color: #555;">a/n FENtasyArt Creative</p>
                </div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" alt="BCA" style="height: 30px; opacity: 0.8;">
            </div>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(126, 38, 37, 0.1); display: flex; justify-content: space-between;">
                <span style="color: #666;">Amount to Pay:</span>
                <span style="font-weight: 700; color: var(--primary-color);">IDR <?php echo $booking['item_price']; ?></span>
            </div>
        </div>

        <form action="handlers/payment_handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #444;">Upload Transfer Receipt</label>
                <div id="drop-area" style="position: relative; border: 2px dashed #ddd; border-radius: 10px; padding: 30px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor='var(--primary-color)'" onmouseout="this.style.borderColor='#ddd'">
                    <input type="file" id="payment-file" name="payment_proof" accept="image/*" required 
                           style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                    <img src="https://cdn-icons-png.flaticon.com/512/338/338864.png" alt="icon" style="width: 40px; opacity: 0.4; margin-bottom: 10px;">
                    <p id="file-label" style="margin: 0; color: #888; font-size: 0.9rem;">Click or drag and drop your image here</p>
                    <p style="margin: 5px 0 0 0; color: #bbb; font-size: 0.75rem;">Supports: JPG, PNG, WEBP</p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(126, 38, 37, 0.2);">
                I Have Paid My Booking
            </button>
            
            <a href="profile.php" style="display:block; text-align:center; margin-top:20px; font-size: 0.9rem; color: #999; text-decoration: none;">Maybe Later</a>
        </form>
    </div>
</main>

<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('payment-file');
    const fileLabel = document.getElementById('file-label');

    // Mencegah browser membuka gambar saat di-drag
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Efek saat file ditarik di atas area
    dropArea.addEventListener('dragover', () => {
        dropArea.style.borderColor = 'var(--primary-color)';
        dropArea.style.background = '#fff8f8';
    });

    // Efek saat file keluar dari area
    dropArea.addEventListener('dragleave', () => {
        dropArea.style.borderColor = '#ddd';
        dropArea.style.background = 'transparent';
    });

    // Saat file "dijatuhkan" (Dropped)
    dropArea.addEventListener('drop', e => {
        dropArea.style.borderColor = '#ddd';
        dropArea.style.background = 'transparent';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files; // Memasukkan file yang di-drop ke dalam input
            fileLabel.innerText = "File selected: " + files[0].name;
            fileLabel.style.color = "var(--primary-color)";
            fileLabel.style.fontWeight = "bold";
        }
    });

    // Update label saat memilih file lewat klik (manual)
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileLabel.innerText = "File selected: " + this.files[0].name;
            fileLabel.style.color = "var(--primary-color)";
            fileLabel.style.fontWeight = "bold";
        }
    });
</script>

<?php include 'includes/footer.php'; ?>