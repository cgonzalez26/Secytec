</div><!-- CONTAINER WRAP END -->

</section><!-- CONTAINER END -->

</div><!-- BODYCONTENT END -->
</div><!-- INNERWRAP BODYWRAP END -->

</div><!-- WRAPPER MAIN END -->
</div><!-- WRAPPER END -->


<footer class="footer-top">
<div class="innerwrap">
<div class="ftop">
<div class="footer-container-wrap">
<div class="fbox">
<div class="widget-area the-icons">
<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
<?php else: ?>
<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('Recent Posts', TEMPLATE_DOMAIN); ?></h3>
<ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
</aside>
<?php endif; ?>
</div>
</div>






<div class="fbox">
<div class="widget-area the-icons">
<?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
<?php else: ?>
<aside class="widget">
<h3 class="widget-title"><?php _e('About Us', TEMPLATE_DOMAIN); ?></h3>
<div class="textwidget">
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed odio nibh, tincidunt adipiscing, pretium nec, tincidunt id, enim...<a href="#">Read more</a></p>
</div>
</aside>
<?php endif; ?>
</div>
</div>

 <div>
</div>
</div>


</footer><!-- FOOTER TOP END -->


<footer class="footer-bottom">
<div class="innerwrap">
<div class="fbottom">
<div class="footer-left">
<?php _e('Copyright &copy;', TEMPLATE_DOMAIN); ?> <?php echo gmdate(__('Y', TEMPLATE_DOMAIN)); ?>. <?php bloginfo('name'); ?>
</div><!-- FOOTER LEFT END -->

<div class="footer-right">
<?php if ( function_exists( 'wp_nav_menu' ) ) { // Added in 3.0 ?>
	<?php wp_nav_menu( array(
	'theme_location' => 'footer',
	'container' => false,
	'depth' => 1,
	'fallback_cb' => 'none'
	)); ?>
<?php } ?>
</div>
</div>
<!-- FOOTER RIGHT END -->

</div>
</footer><!-- FOOTER BOTTOM END -->

<?php wp_footer(); ?>

<?php if( get_theme_option('social_on') == 'Yes' ) { ?>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
<?php } ?>



</body>

</html>