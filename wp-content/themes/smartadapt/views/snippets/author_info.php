<?php
/*
 * Author info snippet
 */
?>

<div class="author-avatar">
	<?php
	$user_image = get_the_author_meta( 'smartadapt_profile_image',get_the_author_meta( 'ID' ) );
	if(!empty($user_image)){
		?>
			<img src="<?php echo $user_image ?>" alt="<?php printf( __( 'About %s', 'smartadapt' ), get_the_author() ); ?>" />
			<?php
	}else
	echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'smartadapt_author_bio_avatar_size', 68 ) ); ?>
</div>
<!-- .author-avatar -->
<div class="author-description">
	<h2><?php printf( __( 'About %s', 'smartadapt' ), get_the_author() ); ?></h2>

	<p><?php the_author_meta( 'description' ); ?></p>

</div><!-- .author-description -->
<div class="row">
	<div class="columns ten">
		<?php
		/*
		 * Social Icons
		 */
		$profile_links = smartadapt_get_user_profile_fields();

		if(count($profile_links)>0){
			?>
			<ul class="user-profiles inline-list">
				<?php
				foreach($profile_links as $key =>$row){
					?>
					<li><a href="<?php echo $row ?>" class="social_ico <?php echo $key?>_link"><span></span></a></li>
					<?php
				}
				?>
			</ul>

			<?php

		}
		?>
	</div>
	<div class="columns six">
		<div class="author-link">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s <span class="icon-chevron-sign-right"></span>', 'smartadapt' ), get_the_author() ); ?>
			</a>

		</div>	<!-- .author-link	-->
	</div>

</div>