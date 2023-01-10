<form class="wpBannerizeForm" name="tools" method="post" action="">
	<?php wp_nonce_field( kWPBannerizeMetaBoxToolsDatabaseKey ); ?>
	<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
	<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

	<input type="hidden" name="<?php echo kWPBannerizeFormSender ?>" value="<?php echo kWPBannerizeMetaBoxToolsKey ?>"/>

	<fieldset>
		<legend><strong><?php _e( 'Status', 'wp-bannerize' ) ?></strong></legend>
		<?php echo $this->tableInformation() ?>
	</fieldset>

	<fieldset>
		<legend><strong><?php _e( 'Clear', 'wp-bannerize' ); ?></strong></legend>
		<p><?php _e( 'Removes all data from WP Bannerize Table. This operation is irreversible! Make a backup before proceding.', 'wp-bannerize' ) ?></p>

		<p><input type="checkbox" name="optionRemoveImages" id="optionRemoveImages"/> <label
			for="optionRemoveImages"><?php _e( 'Remove uploaded images', 'wp-bannerize' ); ?></label></p>

		<hr/>

		<p class="textright">
			<button class="button-secondary" name="<?php echo kWPBannerizeFormAction ?>"
			        value="<?php echo kWPBannerizeFormActionTruncateTable ?>"><?php _e( 'Initialize', 'wp-bannerize' ) ?></button>
		</p>
		<p><input type="checkbox" name="securityConfirm" id="securityConfirm"/> <label for="securityConfirm"
		                                                                               style="color:#c00"><?php _e( 'Please, confirm irreversible action', 'wp-bannerize' ); ?></label>
		</p>


	</fieldset>

	<?php
	/**
	 * @todo: Database export
	 *
	<fieldset>
	<legend><strong><?php _e('Export', 'wp-bannerize'); ?></strong></legend>
	<p><?php _e('Export WP bannerize table data', 'wp-bannerize') ?> <span
	style="color:#f90;font-style:italic;">(<?php _e('Not yet implement', 'wp-bannerize') ?>)</span></p>

	<p><input disabled="disabled" type="checkbox" name="includeImages" id="includeImages"/> <label
	for="includeImages"><?php _e('Include images', 'wp-bannerize'); ?></label></p>

	<p class="alignright">
	<button disabled="disabled" class="button-secondary" name="<?php echo kWPBannerizeFormAction ?>"
	value="exportDatabseTable"><?php _e('Export', 'wp-bannerize') ?></button>
	</p>
	</fieldset>
	 */
	?>
</form>