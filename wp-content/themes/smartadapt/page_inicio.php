<!--?php /* Template Name: page_inicio */ ?-->
<?php
get_header('inicio');
?>

<div class="main" role="main"><!--daniel 05/01/15-->
	<div id="wrapper" class="wrapper row">
	<center>

	<div style="width:90%;height:auto"><!--;padding:10px;"> daniel 12/01/15-->

		<!--<div style="background:#fff;width:100%;padding-bottom:10px"> daniel 12/01/15-->
			<?php //echo do_shortcode('[advps-slideshow optset="1"]');
			echo do_shortcode('[nemus_slider id="304"]');?>
		<!--</div>daniel 12/01/15-->
		
	</div>
	</center>
	</div>
</div>
<?php get_footer('inicio'); ?>

