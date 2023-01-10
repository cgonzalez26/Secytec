<form class="wpBannerizeForm" name="tools" method="post" action="">
	<?php wp_nonce_field( kWPBannerizeMetaBoxToolsKey ); ?>
	<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
	<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

	<table class="form-table wp_bannerize">
		<tr>
			<th scope="row">
				<label for="wpBannerizeEditorGroup"><?php _e( 'Group', 'wp-bannerize' )?>:</label>
			</th>
			<td><?php echo $this->groupMenu( 'wpBannerizeEditorGroup', '', __( 'Any', 'wp-bannerize' ) ) ?></td>
		</tr>

		<tr>
			<th scope="row">
				<label for="wpBannerizeEditorRandom"><?php _e( 'Random', 'wp-bannerize' )?>:</label>
			</th>
			<td><input type="checkbox" name="wpBannerizeEditorRandom" id="wpBannerizeEditorRandom"/></td>
		</tr>

		<tr>
			<th scope="row">
				<label for="wpBannerizeEditorNoHTML"><?php _e( 'No HTML wrap', 'wp-bannerize' )?>:</label>
			</th>
			<td><input type="checkbox" name="wpBannerizeEditorNoHTML" id="wpBannerizeEditorNoHTML"/></td>
		</tr>

		<tr>
			<th scope="row">
				<label for="wpBannerizeEditorLimit"><?php _e( 'Limit', 'wp-bannerize' )?>:</label>
			</th>
			<td><input class="number sizeSmall" type="text" name="wpBannerizeEditorLimit" id="wpBannerizeEditorLimit"/>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label for="wpBannerizeEditorBefore"><?php _e( 'HTML Tag before banner', 'wp-bannerize' )?>:</label>
			</th>
			<td><input class="sizeSmall" type="text" name="wpBannerizeEditorBefore" id="wpBannerizeEditorBefore"/>
				<label style="margin-left:16px"
				       for="wpBannerizeEditorAfter"><?php _e( 'HTML Tag after banner', 'wp-bannerize' )?>:</label>
				<input
					class="sizeSmall" type="text" name="wpBannerizeEditorAfter" id="wpBannerizeEditorAfter"/></td>
		</tr>

		<tr>
			<th scope="row" style="vertical-align:top">
				<label for="wpBannerizeEditorCategories"><?php _e( 'Show banners only for following categories', 'wp-bannerize' )?>
					:</label>
			</th>
			<td><?php echo $this->categoriesTree() ?></td>
		</tr>

		<tr>
			<td colspan="2">
				<hr/>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<p><?php _e( 'Click in the text area and copy code below', 'wp-bannerize' ) ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row" style="vertical-align:top">
				<label><?php _e( 'PHP Function', 'wp-bannerize' ) ?>:</label>
			</th>
			<td>
				<textarea readonly="readonly" rows="3" cols="20" name="wpBannerizeEditorPHPFunction"
				          id="wpBannerizeEditorPHPFunction"><?php echo esc_textarea( "<?php if(function_exists( 'wp_bannerize' ))\n\twp_bannerize(); ?>" ) ?></textarea>
			</td>
		</tr>

		<tr>
			<th scope="row" style="vertical-align:top">
				<label><?php _e( 'Wordpress shortcode', 'wp-bannerize' ) ?>:</label>
			</th>
			<td>
				<textarea readonly="readonly" rows="3" cols="20" name="wpBannerizeEditorWordpressShortcode"
				          id="wpBannerizeEditorWordpressShortcode"><?php echo esc_textarea( "[wp_bannerize]" ) ?></textarea>
			</td>
		</tr>

	</table>

</form>