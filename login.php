<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$pageTitle = 'Login - FENtasyArt';

// 1. INCLUDE HEAD & HEADER (Supaya menu muncul)
include 'includes/head.php';
include 'includes/header.php'; 
?>

<div class="container" style="padding: 80px 20px; min-height: 60vh;">
    
    <div class="contact-form-wrapper" style="width: 100%; max-width: 500px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <img src="assets/logo.png" alt="Logo" style="height: 80px; margin-bottom: 1rem;">
            <h2 class="section-title">Login</h2>
            <p>Welcome back to FENtasyArt</p>

            <?php if (isset($_GET['success'])): ?>
                <div style="color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    Registration successful! Please login.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php 
                        if ($_GET['error'] == 'wrong_credentials') echo "Email or Password incorrect!";
                        elseif ($_GET['error'] == 'empty_fields') echo "Please fill all fields!";
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <form action="handlers/login_handler.php" method="POST">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label>Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label>Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem;">
            Don't have an account? <a href="register.php" style="color: var(--primary-color); font-weight: bold;">Register here</a>
        </p>
    </div>
</div>

<?php
// 2. INCLUDE FOOTER (Supaya bagian bawah muncul)
include 'includes/footer.php';
?>