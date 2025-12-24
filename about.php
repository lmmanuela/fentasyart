<?php
session_start();
// about.php

// 1. Sertakan koneksi database
require_once 'config/db.php';

// 2. Setel judul halaman
$pageTitle = 'About Us - FENtasyArt';

// 3. Inisialisasi array
$collaborations = [];
$team_members = [];

// 4. Ambil data
try {
    $stmt_collab = $pdo->query("SELECT * FROM collaborations ORDER BY id");
    $collaborations = $stmt_collab->fetchAll();

    $stmt_team = $pdo->query("SELECT * FROM team ORDER BY id");
    $team_members = $stmt_team->fetchAll();

} catch (PDOException $e) {
    error_log("Database query failed: " . $e->getMessage());
    // Biarkan array kosong
}

// 5. Sertakan template head
include 'includes/head.php';

// 6. Sertakan template header
include 'includes/header.php';
?>

<main class="about-page-new-model">
    <section class="vision-mission-section">
        <div class="container">
            <div class="about-header">
                <h1 class="section-title">About FENtasyArt</h1>
                <p class="section-subtitle">FENtasy Art was founded in 2024.
                    The idea arose from a desire to create a creative space that could help artists promote their work, build portfolios, and collaborate on a single, easily accessible platform.
                    We hope to create an environment that supports artists' development—a place where they can share inspiration, discover new opportunities, and unleash their creativity without limits.</p>
            </div>
            <div class="vm-grid">
                <div class="vm-card">
                    <h3>Vision</h3>
                    <p>Becoming a creative space that connects artists with the world, as well as a platform for the younger generation to create, collaborate, and grow through art.</p>
                </div>
                <div class="vm-card">
                    <h3>Mission</h3>
                    <ul>
                        <li>Providing a platform for artists to showcase and promote their work professionally.</li>
                        <li>Encouraging collaboration between artists, designers, and creative communities from various fields.</li>
                        <li>Providing an open space to share ideas, inspiration, and experiences related to the world of art.</li>
                        <li>Building a community that supports and appreciates all forms of creative expression.</li>
                        <li>Inspiring more people to dare to create and make art a part of their daily lives.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="gallery-section section-dark">
        <div class="container">
            <div class="gallery-header">
                <h2 class="section-title">Collaboration Documentation</h2>
                <p class="section-subtitle">Unforgettable moments from various events we have organized with great partners.</p>
            </div>
            <div class="gallery-grid">
                
                <?php foreach ($collaborations as $collab): ?>
                <div class="gallery-card">
                    <img src="<?php echo htmlspecialchars($collab['image_url']); ?>" alt="<?php echo htmlspecialchars($collab['title']); ?>" class="gallery-image-background">
                    <div class="gallery-content">
                        <h3 class="gallery-title"><?php echo htmlspecialchars($collab['title']); ?></h3>
                        <p class="gallery-date"><?php echo htmlspecialchars($collab['date_text']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($collaborations)): ?>
                    <p style="text-align: center; grid-column: 1 / -1; color: var(--gray-color);">Belum ada dokumentasi kolaborasi.</p>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <section class="team-section-profiles">
        <div class="container">
            <div class="team-header">
                <h2 class="section-title">Our Team</h2>
                <p class="section-subtitle">The dedicated individuals behind the scenes bringing the FENtasyArt vision to life.</p>
            </div>
            <div class="team-grid-profiles">

                <?php foreach ($team_members as $member): ?>
                <div class="team-profile-item">
                    <img src="<?php echo htmlspecialchars($member['image_url']); ?>" alt="Foto <?php echo htmlspecialchars($member['name']); ?>" class="profile-image">
                    <h3 class="profile-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                    <p class="profile-role"><?php echo htmlspecialchars($member['role']); ?></p>
                </div>
                <?php endforeach; ?>
                <?php if (empty($team_members)): ?>
                    <p style="text-align: center; grid-column: 1 / -1;">Data tim belum tersedia.</p>
                <?php endif; ?>

            </div>
        </div>
    </section>
</main>

<?php
// 8. Sertakan template footer
include 'includes/footer.php';
?>