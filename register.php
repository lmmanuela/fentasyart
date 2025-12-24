<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$pageTitle = 'Register - FENtasyArt';

// 1. INCLUDE HEAD & HEADER
include 'includes/head.php';
include 'includes/header.php';
?>

<div class="container" style="padding: 80px 20px; min-height: 60vh;">
    
    <div class="contact-form-wrapper" style="width: 100%; max-width: 500px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 class="section-title">Create Account</h2>
            <p>Join our creative community</p>

            <?php if (isset($_GET['error'])): ?>
                <div style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php 
                        if ($_GET['error'] == 'password_mismatch') echo "Passwords do not match!";
                        elseif ($_GET['error'] == 'email_taken') echo "Email is already registered!";
                        elseif ($_GET['error'] == 'empty_fields') echo "Please fill all fields!";
                        else echo "Registration failed!";
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <form action="handlers/register_handler.php" method="POST">
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Full Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem;">
            Already have an account? <a href="login.php" style="color: var(--primary-color); font-weight: bold;">Login here</a>
        </p>
    </div>
</div>

<?php
// 2. INCLUDE FOOTER
include 'includes/footer.php';
?>