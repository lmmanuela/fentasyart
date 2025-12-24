<?php
session_start();
// contact.php

// 1. Setel judul halaman
$pageTitle = 'Contact - FENtasyArt';

// (Tidak perlu koneksi database di sini karena kita hanya menampilkan form)

// 2. Sertakan template head
include 'includes/head.php';

// 3. Sertakan template header
include 'includes/header.php';
?>

<main>
    <section class="contact-page">
        <div class="container">
            <div class="contact-header">
                <h1 class="section-title">Got a question or want to collaborate with us?</h1>
                <p class="section-subtitle">We'd love to hear from you! Just fill out the form below and we'll respond shortly.</p>
            
                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] == 'success'): ?>
                        <div style="padding: 1rem; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; margin: 1rem auto; max-width: 700px; text-align: center;">
                            <strong>Thank you!</strong> Your message has been sent successfully. We will get back to you soon.
                        </div>
                    <?php else: ?>
                        <div style="padding: 1rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; margin: 1rem auto; max-width: 700px; text-align: center;">
                            <strong>Oops!</strong> Something went wrong. Please try again.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                </div>
            
            <div class="contact-form-wrapper">
                <div class="contact-form-container">
                    <h3 class="contact-heading">Send your message</h3>
                    
                    <form id="contactForm" class="contact-form" action="handlers/contact_handler.php" method="POST">
                        <div class="form-group">
                            <label for="name">Hello, I Am</label>
                            <input type="text" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">You Can Reach Me At</label>
                            <input type="email" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">I Am Reaching Out For</label>
                            <input type="text" id="subject" name="subject" placeholder="Project, Collaboration, Question, etc." required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Make Our Day!</label>
                            <textarea id="message" name="message" rows="5" placeholder="Tell Us More About Your Project Or Inquiry...." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// 5. Sertakan template footer
include 'includes/footer.php';
?>