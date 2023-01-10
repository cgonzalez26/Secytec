<footer id="main-footer" class="main-footer">
    <?php

    if (!is_404())
        get_sidebar('footer'); //Add footer sidebar
    ?>
    
</footer>
    <?php wp_footer(); ?>
</body>
</html>
