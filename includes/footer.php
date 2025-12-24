<?php
// includes/footer.php
?>
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section footer-about">
                <h3 class="footer-logo">FENtasyArt</h3>
                <p>A creative space for artists, designers, and anyone who wants to express themselves through art in a supportive community environment.</p>
            </div>
            <div class="footer-section footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="index.php#spaces">Spaces</a></li>
                    <li><a href="index.php#workshops">Workshops</a></li>
                    <li><a href="index.php#exhibitions">Exhibitions</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section footer-contact">
                <h4>Contact Information</h4>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl. Seni Raya No. 123, Surabaya</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>hello@fentasyart.id</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+62 21 1234 5678</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon-Fri: 09:00 - 18:00</span>
                    </div>
                </div>
            </div>
        </div> 
        <div class="footer-bottom">
            <p>&copy; 2025 FENtasyArt. All rights reserved.</p>
        </div>
    </div>
</footer>

<div id="bookingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Booking Form</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="bookingForm">
                <div class="modal-summary">
                    <h4 id="summaryItemName"></h4>
                    <p id="summaryItemDetail"></p>
                    <p id="summaryItemPrice" class="space-price"></p>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="bookingName">Full Name</label>
                        <input type="text" id="bookingName" name="bookingName" required>
                    </div>
                    <div class="form-group">
                        <label for="bookingEmail">Email</label>
                        <input type="email" id="bookingEmail" name="bookingEmail" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="bookingPhone">Phone Number</label>
                    <input type="tel" id="bookingPhone" name="bookingPhone" required>
                </div>
                <div class="form-group" id="date-picker-group">
                    <label for="bookingDate">Select Date</label>
                    <input type="date" id="bookingDate" name="bookingDate" required>
                </div>
                <div class="form-group">
                    <label for="bookingNotes">Additional Notes</label>
                    <textarea id="bookingNotes" name="bookingNotes" rows="3" placeholder="Special requirements or questions..."></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelBooking">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Booking</button>
                </div>
            </form>
            
            <div id="bookingSuccessMessage" class="modal-success-message" style="display: none; text-align: center;">
                <h3 style="color: var(--primary-dark);">Thank You!</h3>
                <p style="margin-top: 15px; line-height: 1.6;">
                    Your booking request has been successfully submitted.<br>
                    <strong style="color: var(--primary-color);">Please do not forget to visit your Profile page to complete the payment and upload your transfer receipt to secure your spot.</strong>
                </p>
                <button class="btn btn-primary" id="closeSuccessMessage" style="margin-top: 20px;">Done</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Kirim status login dari PHP ke variabel JavaScript
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
</script>
<script src="assets/script.js"></script>
</body>
</html>