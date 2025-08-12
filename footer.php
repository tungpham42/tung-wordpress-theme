<footer>
    <div class="footer-container">
        <div class="footer-widgets">
            <?php dynamic_sidebar('footer-sidebar'); ?>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>