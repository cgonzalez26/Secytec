<?php
/*
* Image row snippet
*/
?>
<div class="columns sixteen">
	<?php
	if ( has_post_thumbnail() ) {
		?>
		<div class="social-and-image-container">
			<div class="share-buttons-area social-column">
				<?php smartadapt_get_social_buttons(); ?>
			</div>
			<div class="comments-link">
				<?php if ( comments_open() && is_single() ) { ?>
				<?php comments_popup_link( '<span class="leave-reply button  small square-button" title="' . __( 'Leave a reply', 'smartadapt' ) . '"><i class="icon-comment"></i></span>', '<i class="icon-comment"></i><span>'. __( '1 Reply', 'smartadapt' ).'</span>', '<i class="icon-comment"></i><span>'.__( '% Replies', 'smartadapt' ).'</span>' ); ?>
				<?php } ?>
			</div>
			<div class="image-column">
				<div class="large-image-outer">

					<?php the_post_thumbnail( 'wide-image' ); ?>

				</div>
			</div>
		</div>
		<?php
	}
	else {
		?>
		<div class="share-buttons-line">
			<?php smartadapt_get_social_buttons(); ?>
		</div>
		<?php
	}
	?>


</div>