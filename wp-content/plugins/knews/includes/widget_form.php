<?php
			global $Knews_plugin;
			if (! $Knews_plugin->initialized) $Knews_plugin->init();			
			$extra_fields = $Knews_plugin->get_extra_fields();
			
			$val='0';
			if (isset($instance[ 'subtitle' ])) $val=$instance[ 'subtitle' ];
			echo '<p><label for="' . $this->get_field_id('subtitle') . '">' . __('Show subtitle','knews') . '</label>';
			echo '<select id="' . $this->get_field_id('subtitle') . '" name="' . $this->get_field_name('subtitle') . '" style="float:right;">';
			echo '<option value="0"' . (($val=="0" || $val=="") ? ' selected="selected"' : '') . '>' . __('No','knews') . '</option>';
			echo '<option value="1"' . (($val=="1") ? ' selected="selected"' : '') . '>' . __('Yes','knews') . '</option>';
			echo '</select></p>';

			foreach ($extra_fields as $field) {
				$val=1;
				if (isset($instance[ $field->name ])) $val=$instance[ $field->name ];
				
				echo '<p><label for="' . $this->get_field_id($field->name) . '">' . $field->name . '</label>';
				echo '<select id="' . $this->get_field_id($field->name) . '" name="' . $this->get_field_name($field->name) . '" style="float:right;">';
				echo '<option value="off"' . (($val=="off") ? ' selected="selected"' : '') . '>' . __('Dont ask','knews') . '</option>';
				echo '<option value="ask"' . (($val=="ask") ? ' selected="selected"' : '') . '>' . __('Not required','knews') . '</option>';
				echo '<option value="required"' . (($val=="required") ? ' selected="selected"' : '') . '>' . __('Required','knews') . '</option>';
				echo '</select></p>';
			}

			$val='outside';
			if (isset($instance[ 'labelwhere' ])) $val=$instance[ 'labelwhere' ];
			echo '<p><label for="' . $this->get_field_id('labelwhere') . '">' . __('Label position','knews') . '</label>';
			echo '<select id="' . $this->get_field_id('labelwhere') . '" name="' . $this->get_field_name('labelwhere') . '" style="float:right;">';
			echo '<option value="outside"' . (($val=="outside") ? ' selected="selected"' : '') . '>' . __('Outside','knews') . '</option>';
			echo '<option value="inside"' . (($val=="inside") ? ' selected="selected"' : '') . '>' . __('Inside','knews') . '</option>';
			echo '<option value="hidden"' . (($val=="hidden") ? ' selected="selected"' : '') . '>' . __('Hidden','knews') . '</option>';
			echo '</select></p>';

			$val='0';
			if (isset($instance[ 'terms' ])) $val=$instance[ 'terms' ];
			echo '<p><label for="' . $this->get_field_id('terms') . '">' . __('Terms checkbox','knews') . '</label>';
			echo '<select id="' . $this->get_field_id('terms') . '" name="' . $this->get_field_name('terms') . '" style="float:right;">';
			echo '<option value="0"' . (($val=="0" || $val=="") ? ' selected="selected"' : '') . '>' . __('No','knews') . '</option>';
			echo '<option value="1"' . (($val=="1") ? ' selected="selected"' : '') . '>' . __('Yes','knews') . '</option>';
			echo '</select></p>';

			$val='1';
			if (isset($instance[ 'requiredtext' ])) $val=$instance[ 'requiredtext' ];
			echo '<p><label for="' . $this->get_field_id('requiredtext') . '">' . __('Show required text fields','knews') . '</label>';
			echo '<select id="' . $this->get_field_id('requiredtext') . '" name="' . $this->get_field_name('requiredtext') . '" style="float:right;">';
			echo '<option value="1"' . (($val=="1" || $val=="") ? ' selected="selected"' : '') . '>' . __('Yes','knews') . '</option>';
			echo '<option value="0"' . (($val=="0") ? ' selected="selected"' : '') . '>' . __('No','knews') . '</option>';
			echo '</select></p>';
				
			echo '<a href="#" onclick="knewsOpenCSS(\'' . $this->get_field_id('customCSS') . '\')">' . __('Customize widget CSS','knews') . '</a><br /><br />';
			echo '<a href="#" onclick="knewsOpenIFRAME(\'' . $this->get_field_id('customCSS') . '\')">' . __('Get Iframe code (remote website subscription)','knews') . '</a><br /><br />';

			echo '<a href="admin.php?page=knews_config&tab=custom">' . __('Customize widget messages','knews') . '</a><br /><br />';
			echo '<input type="hidden" name="' . $this->get_field_name('customCSS') . '" id="' . $this->get_field_id('customCSS') . '" value="' . (isset($instance['customCSS']) ? $instance[ 'customCSS' ] : '') . '">';
