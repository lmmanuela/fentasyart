<?php
session_start();
// index.php

// 1. Sertakan koneksi database
require_once 'config/db.php';

// 2. Setel judul halaman
$pageTitle = 'FENtasyArt: Home for Creative Souls';

// 3. Inisialisasi array
$spaces = [];
$workshops = [];
$exhibitions = [];

// 4. Ambil semua data dari database
try {
    // Ambil Spaces
    $stmt_spaces = $pdo->query("SELECT * FROM spaces ORDER BY id");
    $spaces = $stmt_spaces->fetchAll();

    // Ambil Workshops
    $stmt_workshops = $pdo->query("SELECT * FROM workshops ORDER BY id");
    $workshops = $stmt_workshops->fetchAll();

    // Ambil Exhibitions
    $stmt_exhibitions = $pdo->query("SELECT * FROM exhibitions ORDER BY id");
    $exhibitions = $stmt_exhibitions->fetchAll();

} catch (PDOException $e) {
    error_log("Database query failed: " . $e->getMessage());
}

// 5. Sertakan template head dan header
include 'includes/head.php';
include 'includes/header.php';
?>

<main>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="container" style="margin-top: 30px;">
        <div style="background: #fff3cd; border-left: 6px solid #ffc107; padding: 25px; border-radius: 12px; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <div style="font-size: 35px;">📢</div>
            <div style="flex-grow: 1;">
                <h4 style="margin: 0; color: #856404; font-size: 1.2rem; font-weight: 800;">Booking Successful!</h4>
                <p style="margin: 8px 0 0 0; color: #856404; font-size: 1rem; line-height: 1.6;">
                    Your reservation has been received. <strong>Please don't forget to complete your payment</strong> and upload the transfer receipt in your <b>Profile Page</b> to secure your spot.
                </p>
            </div>
            <div>
                <a href="profile.php" class="btn btn-primary" style="background-color: #856404; border: none; padding: 12px 25px; font-weight: bold; text-decoration: none; border-radius: 8px; white-space: nowrap;">Go to My Profile</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <section id="home" class="hero">
        <div class="hero-background">
            <img src="https://i.pinimg.com/736x/fa/70/d7/fa70d7227499e5377d4992b632684d3e.jpg" alt="FENtasyArt Creative Space" class="hero-bg-img">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <h1 class="hero-title">Welcome to FENtasyArt</h1>
                <p class="hero-subtitle">A Home for Creative Souls</p>
                <p class="hero-description">We are a platform that connects artists with clients, collectors, and art lovers from various backgrounds. Through this space, every artist can showcase their best work, build a professional portfolio, and expand their creative network. Find inspiration, collaboration, and new opportunities with FENtasy Art.</p>
                <div class="hero-buttons">
                    <a href="#exhibitions" class="btn btn-primary">View Gallery</a>
                    <a href="#spaces" class="btn btn-secondary">Explore Spaces</a>
                </div>
            </div>
        </div>
    </section>

    <section id="spaces" class="spaces section-dark">
        <div class="container">
            <h2 class="section-title">Available Spaces</h2>
            <p class="section-subtitle">Choose a workspace that suits your creative needs and budget</p>
            <div class="spaces-grid">
                <?php foreach ($spaces as $space): ?>
                <div class="space-card">
                    <div class="space-image"><img src="<?php echo htmlspecialchars($space['image_url']); ?>" alt="<?php echo htmlspecialchars($space['name']); ?>"></div>
                    <div class="space-content">
                        <h3><?php echo htmlspecialchars($space['name']); ?></h3>
                        <p><?php echo htmlspecialchars($space['description']); ?></p>
                        
                        <ul class="space-features">
                            <?php
                            try {
                                $stmt_features = $pdo->prepare("SELECT * FROM space_features WHERE space_id = ?");
                                $stmt_features->execute([$space['id']]);
                                $features = $stmt_features->fetchAll();
                                foreach ($features as $feature):
                                    echo "<li>" . htmlspecialchars($feature['feature']) . "</li>";
                                endforeach; 
                            } catch (PDOException $e) {
                                echo "<li>Feature information unavailable</li>";
                            }
                            ?>
                        </ul>
                        
                        <div class="space-price">IDR <?php echo number_format($space['price_per_day'], 0, ',', '.'); ?>/day</div>
                        <p style="font-size: 0.9rem; color: var(--gray-color); margin-bottom: 15px;">
                            Available: <strong><?php echo $space['stock']; ?> units</strong>
                        </p>
                        <?php if ($space['stock'] > 0): ?>
                            <button class="btn btn-primary space-book">Book Now</button>
                        <?php else: ?>
                            <button class="btn" disabled style="background-color: #ccc; cursor: not-allowed; color: #666; border: 1px solid #bbb;">Fully Booked</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="workshops" class="workshops">
        <div class="container">
            <h2 class="section-title">Upcoming Workshops</h2>
            <p class="section-subtitle">Enhance your skills with workshops from experienced artists</p>
            <div class="workshops-grid">
                <?php foreach ($workshops as $workshop): ?>
                <div class="workshop-card">
                    <div class="workshop-image"><img src="<?php echo htmlspecialchars($workshop['image_url']); ?>" alt="<?php echo htmlspecialchars($workshop['title']); ?>"></div>
                    <div class="workshop-content">
                        <div class="workshop-category"><?php echo htmlspecialchars($workshop['category']); ?></div>
                        <h3><?php echo htmlspecialchars($workshop['title']); ?></h3>
                        <p class="workshop-instructor"><?php echo htmlspecialchars($workshop['instructor']); ?></p>
                        <div class="workshop-details">
                            <div class="workshop-date"><?php echo date('d M Y', strtotime($workshop['date_text'])); ?></div>
                            <div class="workshop-duration"><?php echo htmlspecialchars($workshop['duration_text']); ?></div>
                        </div>
                        <div class="workshop-price">IDR <?php echo number_format($workshop['price'], 0, ',', '.'); ?></div>
                        <p style="font-size: 0.9rem; color: var(--gray-color); margin-bottom: 15px;">
                            Seats Left: <strong><?php echo $workshop['stock']; ?></strong>
                        </p>
                        <?php if ($workshop['stock'] > 0): ?>
                            <button class="btn btn-primary workshop-book">Register Now</button>
                        <?php else: ?>
                            <button class="btn" disabled style="background-color: #ccc; cursor: not-allowed; color: #666; border: 1px solid #bbb;">Sold Out</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="exhibitions" class="exhibitions section-dark">
        <div class="container">
            <h2 class="section-title">Current Exhibitions</h2>
            <p class="section-subtitle">Explore the latest artworks from local and international artists</p>
            <div class="exhibitions-grid">
                <?php foreach ($exhibitions as $exhibition): ?>
                <div class="exhibition-card">
                    <div class="exhibition-image">
                        <img src="<?php echo htmlspecialchars($exhibition['image_url']); ?>" alt="<?php echo htmlspecialchars($exhibition['title']); ?>">
                    </div>
                    <div class="exhibition-content">
                        <h3><?php echo htmlspecialchars($exhibition['title']); ?></h3>
                        <p class="exhibition-artist"><?php echo htmlspecialchars($exhibition['artist']); ?></p>
                        <p class="exhibition-duration"><?php echo htmlspecialchars($exhibition['duration_text']); ?></p>
                        <p class="exhibition-description"><?php echo htmlspecialchars($exhibition['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php
include 'includes/footer.php';
?>