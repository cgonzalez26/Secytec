<section id="sidebar" class="<?php echo get_class_of_component('sidebar', smartadapt_option( 'smartadapt_layout' )) ?>">
    <?php if (is_active_sidebar('sidebar-1')) : ?>
    <div id="secondary" class="widget-area" role="complementary">
        <?php

			if(is_archive()){
				dynamic_sidebar('sidebar-4');
			}else if(is_single())
			/*dynamic_sidebar('sidebar-5');cristian */
			dynamic_sidebar('sidebar-1');
				else if(is_page())
				dynamic_sidebar('sidebar-1');
				else
			dynamic_sidebar('sidebar-1');

			?>
    </div><!-- #secondary -->
    <?php endif; ?>
</section><!-- #sidebar .widget-area -->




