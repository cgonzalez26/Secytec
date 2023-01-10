<form class="wpBannerizeForm" name="save_settings" method="post" action="">
	<?php wp_nonce_field( kWPBannerizeMetaBoxSettingsKey ); ?>
	<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
	<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

	<input type="hidden" name="command_action" value="updateSettings"/>

	<table class="form-table wp_bannerize">
		<tr>
			<th scope="row">
				<label for="clickCounterEnabled"><?php _e( 'Turn on Click Counter', 'wp-bannerize' )?>
					:</label>
			</th>
			<td><input type="checkbox" name="clickCounterEnabled"
			           id="clickCounterEnabled"
			           value="1" <?php checked( $this->options['clickCounterEnabled'], '1' ) ?> />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="impressionsEnabled"><?php _e( 'Turn on Impressions', 'wp-bannerize' )?>
					:</label>
			</th>
			<td><input type="checkbox" name="impressionsEnabled" id="impressionsEnabled"
			           value="1" <?php checked( $this->options['impressionsEnabled'], '1' ) ?> />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="supportWPBannerize"><?php _e( 'Link description', 'wp-bannerize' )?>
					:</label>
			</th>
			<td>
				<input type="checkbox" name="linkDescription" id="linkDescription"
				       value="1" <?php echo (
					$this->options['linkDescription'] == "1" ) ? 'checked="checked"' : '' ?> />
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label for="supportWPBannerize"><?php _e( 'Support WP Bannerize', 'wp-bannerize' )?>
					:</label>
			</th>
			<td>
				<input type="checkbox" name="supportWPBannerize" id="supportWPBannerize"
				       value="1" <?php checked( $this->options['supportWPBannerize'], '1' ) ?> />
				(<?php _e( 'Append Powered by...', 'wp-bannerize' ) ?>)
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label for="supportWPBannerize"><?php _e( 'Adobe Flash Window Mode', 'wp-bannerize' )?>
					:</label>
			</th>
			<td>
				<?php $this->comboWindowModeFlash( $this->options['comboWindowModeFlash'] ); ?>
			</td>


		</tr>
		<tr>
			<th scope="row" style="vertical-align:top">
				<label for=""><?php _e( 'Frontend Style', 'wp-bannerize' ) ?>:</label>
			</th>
			<td>
				<input type="radio" name="wpBannerizeStyleDefault"
				       value="default" <?php checked( $this->options['wpBannerizeStyleDefault'], 'default' ) ?>/>
				<select name="wpBannerizeStyle" id="wpBannerizeStyle">
					<option <?php selected( $this->options['wpBannerizeStyle'], kWPBannerizeBannerStyleDefault ) ?>
						value="<?php echo kWPBannerizeBannerStyleDefault ?>"><?php _e( 'Default: vertical', 'wp-bannerize' ) ?></option>
					<option <?php selected( $this->options['wpBannerizeStyle'], kWPBannerizeBannerStyleInline ) ?>
						value="<?php echo kWPBannerizeBannerStyleInline ?>"><?php _e( 'Inline: side by side', 'wp-bannerize' ) ?></option>
				</select><br/>
				<input type="radio" name="wpBannerizeStyleDefault"
				       value="custom" <?php checked( $this->options['wpBannerizeStyleDefault'], 'custom' ) ?> />
				<label for=""><?php _e( 'Custom rules', 'wp-bannerize' ) ?>:</label>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea <?php echo ( $this->options['wpBannerizeStyleDefault'] ==
					'default' ) ? 'disabled="disabled"' : '' ?> class="<?php echo (
					$this->options['wpBannerizeStyleDefault'] == 'default' ) ? 'disabled' : '' ?>"
				                                                rows="3"
				                                                cols="20"
				                                                name="wpBannerizeStyleCustom"
				                                                id="wpBannerizeStyleCustom"><?php echo $this->options['wpBannerizeStyleCustom'] ?></textarea>
			</td>
		</tr>

		<tr>
			<th scope="row" colspan="2" style="text-align:left">
				<label for=""><?php _e( 'Default HTML/message for no banner', 'wp-bannerize' ) ?>:</label>
			</th>
		</tr>
		<tr>
			<td colspan="2">
				<textarea rows="3" cols="20" name="wpBannerizeNoBannerHTMLMessage"
				          id="wpBannerizeNoBannerHTMLMessage"><?php echo $this->options['wpBannerizeNoBannerHTMLMessage'] ?></textarea>
			</td>
		</tr>

	</table>
	<p>
		<input class="button-primary" type="submit"
		       value="<?php _e( 'Update', 'wp-bannerize' )?>"/>
		<button style="float:right" class="button-secondary" name="tools"
		        value="resetToDefault"><?php _e( 'Reset to Default', 'wp-bannerize' ) ?></button>
	</p>
</form>