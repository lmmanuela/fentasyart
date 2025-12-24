<?php
// includes/header.php
?>
<header class="header">
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                <img src="assets/logo.png" alt="FENtasyArt Logo" style="height: 50px; margin-right: 12px;">
                <span style="font-size: 1.5rem; font-weight: bold;">FENtasyArt</span>
            </a>
            
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About Us</a>
                <a href="contact.php" class="nav-link">Contact</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="nav-item" style="position: relative; display: inline-block;">
                        <a href="javascript:void(0)" class="nav-link" style="color: var(--primary-color); font-weight: bold;">
                            Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </a>
                        <div class="dropdown-menu">
                            <?php if ($_SESSION['user_role'] == 'admin'): ?>
                                <a href="admin_dashboard.php" class="dropdown-link">Admin Dashboard</a>
                                <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">
                            <?php endif; ?>
                            
                            <a href="profile.php" class="dropdown-link">My Profile</a>
                            <a href="handlers/logout.php" class="dropdown-link" style="color: #dc3545; font-weight: bold;">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary" style="padding: 8px 20px; font-size: 0.9rem;">Login</a>
                <?php endif; ?>
            </div>
            
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>
</header>