<?php
//Security for CSRF attacks
$knews_nonce_action='kn-adm-export';
$knews_nonce_name='_admexp';
if (!empty($_POST)) $w=check_admin_referer($knews_nonce_action, $knews_nonce_name);
//End Security for CSRF attacks

	global $wpdb, $Knews_plugin, $knews_delimiters, $knews_enclosure, $knews_encode, $knews_line_endings;
//	global $knews_delimiters, $knews_enclosure, $knews_encode, $knews_line_endings, $knews_import_errors, $knews_import_users_error, $col_options, $submit_confirmation_id, $confirmation_sql_count;

	require_once( KNEWS_DIR . '/includes/knews_util.php');

    // specify allowed field delimiters
    $knews_delimiters = array(
        'comma ,'     => ',',
        'semicolon ;' => ';',
        'tab'         => "\t",
        'pipe |'         => '|',
        'colon :'     => ':',
        'space'     => ' ',
    );

    $knews_enclosure = array(
        'double'	=> '"',
        'simple'	=> '\''
    );

	function put_format_selects() {

		global $knews_delimiters, $knews_enclosure, $knews_encode, $knews_line_endings, $Knews_plugin;

		?>
			<p><?php _e('Separator','knews'); ?>: <select name="knews_delimiters" id="knews_delimiters">
				<?php
				while ($d = current($knews_delimiters)) {
					echo '<option value="' . key($knews_delimiters) . '"' . (( $Knews_plugin->post_safe('knews_delimiters') == key($knews_delimiters)) ? ' selected="selected"' : '') . '>' . key($knews_delimiters) . '</option>';
					next($knews_delimiters);
				}
				?>
			</select>
			<?php _e('Enclosure','knews'); ?>: <select name="knews_enclosure" id="knews_enclosure">
				<?php
				while ($d = current($knews_enclosure)) {
					echo '<option value="' . key($knews_enclosure) . '"' . (( $Knews_plugin->post_safe('knews_enclosure') == key($knews_enclosure)) ? ' selected="selected"' : '') . '>' . key($knews_enclosure) . '</option>';
					next($knews_enclosure);
				}
				?>
			</select>
			</p>
		<?php
	}

	$step = $Knews_plugin->post_safe('step', 1);
	$knews_has_header = $Knews_plugin->post_safe('knews_has_header', 0, 'int');
	
	$query = "SELECT * FROM " . KNEWS_LISTS . " ORDER BY orderlist";
	$unkey_lists = $wpdb->get_results( $query );
	$languages = $Knews_plugin->getLangs();
	
	foreach ($unkey_lists as $list) {
		$lists[$list->id] = $list;
	}
	
	if ($step==2) {
		$no_list=true; $no_lang=true; $all_langs=true; $all_lists=true; $indexed_list=array();
		
		foreach ($lists as $list) {
			if ($Knews_plugin->post_safe('list_' . $list->id) == 1) {
				$no_list = false;
			} else {
				$all_lists = false;
			}
			$indexed_list[$list->id]=$list->name;
		}
		foreach ($languages as $lang) {
			if ($Knews_plugin->post_safe('lang_' . $lang['language_code']) == 1) {
				$no_lang=false;
			} else {
				$all_langs = false;
			}
		}
		
		if ($no_lang || $no_list) {
			$step=1;
			echo '<div class="error"><p>' . __('Select at least one list and one language.','knews') . '</p></div>';
		}
	}
?>
	<div class="wrap">
		<div class="icon32" style="background:url(<?php echo KNEWS_URL; ?>/images/icon32.png) no-repeat 0 0;"><br></div><h2><?php _e('Export users','knews');?></h2>
		<?php
		$exported_users = 0;

		if ($step=='2') {
			$csv_code = '';
			$delimiter = $knews_delimiters[$Knews_plugin->post_safe('knews_delimiters')];
			$enclosure = $knews_enclosure[$Knews_plugin->post_safe('knews_enclosure')];
			$extra_fields = $Knews_plugin->get_extra_fields();

			if ($knews_has_header==1) {
					$csv_code .= $enclosure . __('E-mail','knews') . $enclosure . $delimiter;

					foreach ($extra_fields as $ef) {
						$csv_code .= $enclosure . $ef->name . $enclosure . $delimiter;					
					}

					$csv_code .= $enclosure . __('Language','knews') . $enclosure . $delimiter;
					$csv_code .= $enclosure . __('State','knews') . $enclosure . $delimiter;
					$csv_code .= $enclosure . __('Lists','knews') . $enclosure . $delimiter;
					$csv_code .= $enclosure . __('Register Date','knews') . $enclosure . $delimiter;
					$csv_code .= $enclosure . __('Register IP','knews') . $enclosure . "\r\n";
			}
			
			/*$query = "SELECT * FROM " . KNEWS_LISTS . " ORDER BY orderlist";
			$lists = $wpdb->get_results( $query );
			$languages = $Knews_plugin->getLangs();*/

			$sql = 'SELECT ku.id, ku.email, ku.state, ku.joined, ku.lang, ku.ip, GROUP_CONCAT(kupl.id_list) AS lists FROM ' . KNEWS_USERS . ' ku INNER JOIN ' . KNEWS_USERS_PER_LISTS . ' kupl ON ku.id = kupl.id_user ';

			$on_lang = ''; $l = 0;
			if (!$all_langs) {
				foreach ($languages as $lang) {
					if ($Knews_plugin->post_safe('lang_' . $lang['language_code']) == 1) {
						$l++;
						if ($on_lang !='') $on_lang .= ' OR ';							
						$on_lang .= "ku.lang='" . $lang['language_code'] . "'";
					}
				}
				if ($l > 1) $on_lang = '(' . $on_lang . ')';
			}
			if ($on_lang != '') $sql = $sql . ' AND ' . $on_lang;

			$on_list = ''; $l = 0;
			if (!$all_lists) {
				//$select_sql .= ', ' . KNEWS_USERS_PER_LISTS . ' kupl';
				foreach ($lists as $list) {
					if ($Knews_plugin->post_safe('list_' . $list->id) == 1) {
						$l++;
						if ($on_list !='') $on_list .= ' OR ';							
						$on_list .= "kupl.id_list=" . $list->id;
					}
					}
				if ($l > 1) $on_list = '(' . $on_list . ')';
				}
			if ($on_list != '') $sql = $sql . ' AND ' . $on_list;

			$sql .= ' GROUP BY kupl.id_user';			
			$users = $wpdb->get_results( $sql );
			
			$sql = 'SELECT user_id, GROUP_CONCAT(CONCAT_WS(\'{:}\', field_id, value) SEPARATOR \'{;}\') AS fields FROM ' . KNEWS_USERS_EXTRA . ' GROUP BY user_id';
			$all_extra_fields = $wpdb->get_results( $sql );

			foreach ($all_extra_fields as $ef) {
				$parells = explode('{;}', $ef->fields);
				foreach ($parells as $p) {
					list($clau, $valor) = explode('{:}', $p);
					$processed_fields[$ef->user_id][$clau] = $valor;
			}
			}
			
			$all_extra_fields=array();
			
			
			
			foreach ($users as $user) {
						
					$exported_users++;
					$csv_code .= $enclosure . $user->email . $enclosure . $delimiter;

					foreach ($extra_fields as $ef) {
					$ef_val='';
					if (isset($processed_fields[$user->id]) && isset($processed_fields[$user->id][$ef->id]))
						$ef_val=$processed_fields[$user->id][$ef->id];
				
					$csv_code .= $enclosure . $ef_val . $enclosure . $delimiter;					
						}
				
				$lists_user_name = array();
				$lists_user = explode(',', $user->lists);
				foreach ($lists_user as $list) {
					if (isset($lists[$list])) $lists_user_name[] = $lists[$list]->name;
					}

					$csv_code .= $enclosure . $user->lang . $enclosure . $delimiter;
					$csv_code .= $enclosure . $user->state . $enclosure . $delimiter;
				$csv_code .= $enclosure . implode(',', $lists_user_name) . $enclosure . $delimiter;
				$csv_code .= $enclosure . $user->joined . $enclosure . $delimiter;
				$csv_code .= $enclosure . $user->ip . $enclosure . "\r\n";
				
			}
			
			if ($exported_users != 0) {

				$file_name = uniqid() . '.csv';
				$fp = fopen(KNEWS_DIR . '/tmp/' . $file_name, 'w');
				if ($fp) {
					fwrite($fp, $csv_code);
				}

				echo '<div class="updated"><p>';
				printf(__('%s users have been exported.','knews'), $exported_users);
				echo '</p></div>';
				
				if ($fp) {
					echo '<p>';
					printf(__('To download the .CSV, click %s here','knews'), '<a href="' . get_admin_url() . 'admin-ajax.php?action=knewsSafeDownload&file=' . $file_name . '">');
					echo '</a></p>';
				} else {
					echo '<p>' . __("Error: I can't write the .CSV file.",'knews') . ' ' . __('The directory /wp-content/plugins/knews/tmp must be writable (chmod 700)', 'knews') . '</p>';
				}
		?>
				<textarea style="width:75%; height:400px;"><?php echo $csv_code; ?></textarea>
		<?php
			}
		}
		if ($step=='1' || ($step=='2' && $exported_users == 0)) {
			if ($step=='2') echo '<div class="updated"><p>' . __('No users match criteria','knews') . '</p></div>';
		?>
			<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
			<input type="hidden" name="step" id="step" value="2" />

			<h3><?php 
			
			_e('1. Select the users you want to export:','knews');
			
			echo '</h3><p>';
			
			_e('1.1. Select the lists to export:','knews');
			
			echo '</p>';
			
			knews_print_mailinglists();
			
			echo '<p>';
			
			_e('1.2. Select the languages to export:','knews');
			
			echo '<blockquote>';
			
			foreach ($languages as $lang) {
				echo '<input type="checkbox" value="1" name="lang_' . $lang['language_code'] . '"' . (($Knews_plugin->post_safe('lang_' . $lang['language_code'])==1) ? ' checked="checked"' : '') . '>' . $lang['translated_name'] . '<br>';
			}
			
			echo '</blockquote></p>';

			_e ('Note: mark all lists and the desired language/s to filter by language, or all languages and desired lists to filter by list,','knews');
			echo '<br>';
			_e ('...or all lists and all languages to export all users.','knews');

			echo '</p><h3>';

			_e('2. Format options:','knews');
			
			?></h3>
			<p><input type="checkbox" name="knews_has_header" id="knews_has_header" value="1"<?php if ( $knews_has_header==1 ) echo ' checked="checked"'; ?> /> <?php _e('Insert a header in the first row','knews'); ?></p>
			<?php
			
			put_format_selects();
			?>
			<div class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Export users','knews');?>">
			</div>
			<?php 
			//Security for CSRF attacks
			wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
			?>
			</form>
			<?php
		}
		?>
	</div>
