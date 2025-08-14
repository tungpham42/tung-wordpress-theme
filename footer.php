<footer>
    <div class="footer-container">
        <div class="footer-widgets">
            <?php dynamic_sidebar('footer-sidebar'); ?>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
        </div>
    </div>
    <button id="back-to-top" class="back-to-top" aria-label="Back to Top">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 5V19M12 5L6 11M12 5L18 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
</footer>
<?php wp_footer(); ?>
</body>
</html>