<?php
//Security for CSRF attacks
$knews_nonce_action='kn-admin-lists';
$knews_nonce_name='_admlist';
if (!empty($_POST)) $w=check_admin_referer($knews_nonce_action, $knews_nonce_name);
//End Security for CSRF attacks

	global $wpdb, $Knews_plugin, $knewsOptions;

	require_once( KNEWS_DIR . '/includes/knews_util.php');

	$langs_code = array();
	$langs_name = array();

	function knews_check_listname($fieldname, $sufix='') {
		global $wpdb, $Knews_plugin;
		
		$name = $Knews_plugin->post_safe($fieldname);
		if ($name=='') $name = $Knews_plugin->get_safe($fieldname);
		if ($name=='') {
			echo '<div class="error"><p><strong>' . __('Error','knews') . ':</strong> ' . __("The field name can't be empty",'knews') . '</p></div>';
			return false;			
		}
		$query = "SELECT * FROM " . KNEWS_LISTS . " WHERE name='" . $name . $sufix . "'";
		$results = $wpdb->get_results( $query );
		
		if (count($results)==0) return true;
		echo '<div class="error"><p><strong>' . __('Error','knews') . ':</strong> ' . __('there is already a list with this name!','knews') . '</p></div>';
		return false;		
	}
	if ($Knews_plugin->get_safe('da')=='rename') {
		if (knews_check_listname('nn')) {
			$query = "UPDATE ".KNEWS_LISTS." SET name='" . $Knews_plugin->get_safe('nn') . "' WHERE id=" . $Knews_plugin->get_safe('lid', 0, 'int');
			$result=$wpdb->query( $query );
			echo '<div class="updated"><p>' . __('List name updated','knews') . '</p></div>';
		}
	}

	if ($Knews_plugin->get_safe('da')=='delete') {
		$query="DELETE FROM " . KNEWS_LISTS . " WHERE id=" . $Knews_plugin->get_safe('lid', 0, 'int');
		$results = $wpdb->query( $query );

		$query="DELETE FROM " . KNEWS_USERS_PER_LISTS . " WHERE id_list=" . $Knews_plugin->get_safe('lid', 0, 'int');
		$results = $wpdb->query( $query );

		echo '<div class="updated"><p>' . __('List deleted','knews') . '</p></div>';
	}

	if (KNEWS_MULTILANGUAGE) {
		
		$languages = $Knews_plugin->getLangs();
				
		if(!empty($languages)){
			foreach($languages as $l){
				$langs_code[] = $l['language_code'];
				$langs_name[] = $l['native_name'];
			}
		}
	}

	if (isset($_POST['action'])) {

		if ($_POST['action']=='add_list') {
			if (knews_check_listname('new_list')) {

			

				$sql = "INSERT INTO " . KNEWS_LISTS . "(name, open, open_registered, langs, orderlist, auxiliary) VALUES ('" . $Knews_plugin->post_safe('new_list') . "', 0, 0, '', 99, 0)";
				if ($wpdb->query($sql)) {
					echo '<div class="updated"><p>' . __('Mailing list created','knews') . '</p></div>';
				} else {
					echo '<div class="error"><p><strong>' . __('Error','knews') . ':</strong> ' . __("can't create the mailing list",'knews') . ' : ' . $wpdb->last_error . '</p></div>';
				}
			}
		} else if ($_POST['action']=='delete_lists' || $_POST['action']=='update_lists') {
			$query = "SELECT * FROM " . KNEWS_LISTS;
			$results = $wpdb->get_results( $query );
			foreach ($results as $list) {
				if (isset($_POST['find_' . $list->id])) {
					if ($_POST['action']=='delete_lists') {
						//Delete only
						if ($Knews_plugin->post_safe('batch_' . $list->id)=='1') {
							$query="DELETE FROM " . KNEWS_LISTS . " WHERE id=" . $list->id;
							$results=$wpdb->query($query);
						
							$query="DELETE FROM " . KNEWS_USERS_PER_LISTS . " WHERE id_list=" . $list->id;
							$results = $wpdb->query( $query );

						}
					} else if ($_POST['action']=='update_lists') {
						//Update only
						$open = (($Knews_plugin->post_safe($list->id . '_open')=='1') ? '1' : '');
						$open_registered = (($Knews_plugin->post_safe($list->id . '_open_registered')=='1') ? '1' : '');
						$order = $Knews_plugin->post_safe($list->id . '_order', 0, 'int');
						$langs='none';

						if (KNEWS_MULTILANGUAGE) {

							foreach ($langs_code as $lang_code) {
								if ($Knews_plugin->post_safe($list->id . '_' . $lang_code)=='1') {
									if ($langs == 'none') {
										$langs = '';
									} else {
										$langs .= ',';
									}
									$langs .= $lang_code;
								}
							}
						}
						
						$query  = "UPDATE ".KNEWS_LISTS." SET open='" . $open . "', open_registered = '" . $open_registered . "', orderlist = '" . $order;
						if (KNEWS_MULTILANGUAGE) $query .= "', langs='" . $langs;
						$query .= "' WHERE id=" . $list->id;
						$results=$wpdb->query($query);
					}
				}
			}
			echo '<div class="updated"><p>' . __('Mailing lists updated','knews') . '</p></div>';
		}
	}

?>
<link href="<?php echo KNEWS_URL; ?>/admin/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo KNEWS_URL; ?>/admin/scripts.js"></script>
<?php
$aux=false;
if ($Knews_plugin->get_safe('tab')=='aux') $aux=true;
?>
	<div class=wrap>
			<div class="icon32" style="background:url(<?php echo KNEWS_URL; ?>/images/icon32.png) no-repeat 0 0;"><br></div>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab<?php if (!$aux) echo ' nav-tab-active'; ?>" href="admin.php?page=knews_lists"><?php _e('Mailing lists','knews'); ?></a>
				<a class="nav-tab<?php if ($aux) echo ' nav-tab-active'; ?>" href="admin.php?page=knews_lists&amp;tab=aux"><?php _e('Auxiliary mailing lists','knews'); ?></a>
				<a class="add-new-h2" href="#newlist"><?php _e('Create new mailing list','knews'); ?></a>
			</h2>
			<?php
			if (!$Knews_plugin->im_pro() && $aux) {
			?>
			<h3><img src="<?php echo KNEWS_URL; ?>/images/lists.png" width="44" height="43" style="vertical-align:middle; margin-bottom:0;" alt="" /> Only Knews Pro allow to create auxiliary lists. Get it as a demo, you can't create new ones.</h3>
			<?php
			}
			?>
			<br />
				<?php
					$query = "SELECT * FROM " . KNEWS_LISTS;
					if ($aux) {
						$query .= ' WHERE auxiliary=1';
					} else {
						$query .= ' WHERE auxiliary=0';
					}
					$query .= " ORDER BY orderlist";
					$results = $wpdb->get_results( $query );
					if (count($results) != 0) {
				?>
					<script type="text/javascript">
					var save_link='';
					var save_id='';
					
					function rename(n) {
						if (save_id != '') rename_cancel();
						save_id = n;
						save_link = jQuery('td.name_' + n).html();
						
						jQuery('td.name_' + n).html('<input type="text" value="' + jQuery('td.name_' + n + ' strong').html() + '"><input type="button" value="Rename" class="rename_do"><input type="button" value="Cancel" class="rename_cancel">');
						
						jQuery('td.name_' + n + ' input')[0].focus();

						jQuery('input.rename_cancel').click(function() {
							rename_cancel();
							return false;
						});

						jQuery('input.rename_do').click(function() {
							location.href="admin.php?page=knews_lists&tab=<?php echo $Knews_plugin->get_safe('tab'); ?>&da=rename&lid=" + save_id + '&nn=' + encodeURIComponent(jQuery('td.name_' + save_id + ' input').val());
						});

						return false;
					}
					
					function rename_cancel() {
						if (save_id != '') {
							jQuery('td.name_' + save_id).html(save_link);
							save_id='';
						}
					}

					</script>

					<form method="post" action="admin.php?page=knews_lists&tab=<?php echo $Knews_plugin->get_safe('tab'); ?>">
					<table class="widefat">
						<thead>
							<tr>
								<th class="manage-column column-cb check-column"><input type="checkbox" /></th>
								<th>ID</th>
								<th><?php _e('Name list','knews'); ?></th>
								<?php if (!$aux) : ?>
								<th><?php _e('Open','knews'); ?></th>
								<th><?php _e('Open for registered users','knews'); ?></th>
								<?php
									if (KNEWS_MULTILANGUAGE) {
										foreach ($langs_name as $lang_name) {
											echo '<th>' . $lang_name . '</th>';
										}
									}
								endif;
								?>
								<th><?php _e('Active users','knews'); ?></th>
								<th><?php _e('Order','knews'); ?></th>
							</tr>
						</thead>
						<tbody>
				<?php
						$alt=false;
						$anyopened=false;
						$anyopened_logged=false;
						
						foreach ($results as $list) {
							
							if ($list->open == '1') $anyopened=true;
							if ($list->open_registered == '1') $anyopened_logged=true;

							echo '<tr' . (($alt) ? ' class="alt"' : '') . '><th class="check-column"><input type="checkbox" name="batch_' . $list->id . '" value="1"><input type="hidden" name="find_' . $list->id . '" value="1"></th>';
							echo '<td>' . $list->id . '</td>';
							echo '<td class="name_' . $list->id  . '"><strong>' . $list->name . '</strong>';
							echo '<div class="row-actions"><span><a href="#" title="' . __('Rename this list', 'knews') . '" onclick="rename(' . $list->id . '); return false;">' . __('Rename', 'knews') . '</a> | </span>';
							echo '<span><a href="admin.php?page=knews_users&filter_list=' . $list->id . '" title="' . __('See this list users', 'knews') . '" >' . __('See users', 'knews') . '</a> | </span>';
							echo '<span class="trash"><a href="admin.php?page=knews_lists&tab=' . $Knews_plugin->get_safe('tab') . '&da=delete&lid=' . $list->id . '" title="' . __('Delete definitively this newsletter', 'knews') . '" class="submitdelete">' . __('Delete', 'knews') . '</a></span></div></td>';

							if (!$aux) :

							echo '<td><input type="checkbox"' . (($list->open == '1') ? ' checked="checked"' : '') .' value="1" name="' . $list->id . '_open" id="' . $list->id . '_open" class="knews_open_close" /></td>';
							echo '<td><input type="checkbox"' . (($list->open_registered == '1') ? ' checked="checked"' : '') .' value="1" name="' . $list->id . '_open_registered" id="' . $list->id . '_open_registered" class="knews_open_close" /></td>';
							if (KNEWS_MULTILANGUAGE) {
								$lang_sniffer = explode(',', $list->langs);
								foreach ($langs_code as $lang_code) {
									echo '<td><input type="checkbox"' . ((in_array($lang_code, $lang_sniffer) || $list->langs=='') ? ' checked="checked"' : '') .' value="1" name="' . $list->id . '_' . $lang_code . '" id="' . $list->id . '_' . $lang_code . '" class="knews_open_close" /></td>';
								}
							}

							endif;

							$query = "SELECT COUNT(" . KNEWS_USERS . ".id) AS HOW_MANY FROM " . KNEWS_USERS . ", " . KNEWS_USERS_PER_LISTS . " WHERE " . KNEWS_USERS_PER_LISTS . ".id_user=" . KNEWS_USERS . ".id AND " . KNEWS_USERS . ".state='2' AND  " . KNEWS_USERS_PER_LISTS . ".id_list=" . $list->id;
							$count = $wpdb->get_results( $query );

							$query = "SELECT COUNT(" . KNEWS_USERS . ".id) AS HOW_MANY FROM " . KNEWS_USERS . ", " . KNEWS_USERS_PER_LISTS . " WHERE " . KNEWS_USERS_PER_LISTS . ".id_user=" . KNEWS_USERS . ".id AND " . KNEWS_USERS . ".state<>'2' AND  " . KNEWS_USERS_PER_LISTS . ".id_list=" . $list->id;
							$count2 = $wpdb->get_results( $query );

							echo '<td align="center"><strong style="color:#25c500">' . $count[0]->HOW_MANY . '</strong> / ' . ($count[0]->HOW_MANY + $count2[0]->HOW_MANY) . '</td>';
							
							//echo '<td align="center"><input type="checkbox" value="1" name="' . $list->id . '_delete" id="' . $list->id . '_delete" /></td>';
							echo '<td><input type="text" value="' . $list->orderlist . '" name="' . $list->id . '_order" id="' . $list->id . '_order" style="width:45px;" /></td>';
							$alt=!$alt;
						}
				?>
						<tbody>
						<tfoot>
							<tr>
								<th class="manage-column column-cb check-column"><input type="checkbox" /></th>
								<th>ID</th>
								<th align="left"><?php _e('List name','knews');?></th>
								<?php if (!$aux) : ?>
								<th align="center"><?php _e('Open','knews');?></th>
								<th align="center"><?php _e('Open for registered users','knews');?></th>
								<?php
									if (KNEWS_MULTILANGUAGE) {
										foreach ($langs_name as $lang_name) {
											echo '<th align="center">' . $lang_name . '</th>';
										}
									}
								endif;
								?>
								<th align="center"><?php _e('Active users','knews'); ?></th>
								<th><?php _e('Order','knews'); ?></th>
							</tr>
						</tfoot>
					</table>
					<?php
						if (!$anyopened && !$aux) {
							echo '<div class="error"><p>' . __("Warning: if you haven't any mailing list opened, the subscription widget will not shown",'knews') . '</p></div>';
						} else {
							if (!$anyopened_logged && !$aux) {
								echo '<div class="error"><p>' . __("Warning: you haven't any mailing list opened for logged users, the subscription widget will not shown until you make log out",'knews') . '</p></div>';
							}
						}
					?>
					<div class="submit">
						<select name="action">
							<option selected="selected" value="update_lists"><?php _e('Only update','knews'); ?></option>
							<option value="delete_lists"><?php _e('Only delete','knews'); ?></option>
						</select>
						<input type="submit" value="<?php _e('Apply','knews'); ?>" class="button-secondary" />
					</div>
					<?php 
					//Security for CSRF attacks
					wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
					?>
					</form>
					<hr />
				<?php
					} else {
						?>
							<p><?php _e('At the moment there is no list, you can create new ones','knews'); ?></p>
						<?php
					}

					if (!$aux) :
				?>
					<a id="newlist"></a>
					<h2><?php _e('Create new mailing list','knews'); ?></h2>
					<form method="post" action="admin.php?page=knews_lists">
					<input type="hidden" name="action" id="action" value="add_list" />
					<p><label for="new_list"><?php _e('New mailing list name:','knews'); ?></label> <input type="text" name="new_list" id="new_list" class="regular-text" /></p>
					<div class="submit">
						<input type="submit" value="<?php _e('Create a mailing list','knews'); ?>" class="button-primary" />
					</div>
					<?php 
					//Security for CSRF attacks
					wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
					?>
					</form>
				<?php
					else:
				?>
					<a id="newlist"></a>
					
						<?php 
						if ($Knews_plugin->post_safe('action') != 'add_list_stats_1' ) {
							$stab = false; if ($Knews_plugin->get_safe('stab') == 2) $stab=true;
						?>
							<h2><?php _e('Create new auxiliary mailing list','knews'); ?></h2>
							<div class="knews_cooltabs_wrapper">
								<div class="knews_cooltabs">
									<a class="tab_ab <?php if (!$stab) echo 'active'; ?>" href="#">A/B Split method</a>
									<a href="#" class="tab_subscriber  <?php if ($stab) echo 'active'; ?>">Subscriber actions method</a>
								</div>
							</div>
							<script type="text/javascript">
								jQuery('document').ready(function() {
									jQuery('a.tab_ab').click(function() {
										jQuery(this).addClass('active');
										jQuery('a.tab_subscriber').removeClass('active');
										jQuery('div.form_ab').show();
										jQuery('div.form_subscriber').hide();										
									});
									jQuery('a.tab_subscriber').click(function() {
										jQuery(this).addClass('active');
										jQuery('a.tab_ab').removeClass('active');
										jQuery('div.form_subscriber').show();
										jQuery('div.form_ab').hide();										
									});
								});
							</script>
							<div class="form_ab" <?php if ($stab) echo 'style="display:none;"'; ?>>
								<form method="post" action="admin.php?page=knews_lists&tab=aux">
								<input type="hidden" name="action" id="action" value="add_list_ab" />
								<p>This is a marketing technique, it will take the 40% of the target and split into two lists (and the rest in another "C" list), then you can send different email to A and B, take a look at the statistics, and use the best result with the another 60%.</p>
								<p><label for="new_list"><?php _e('New mailing list name:','knews'); ?></label> <input type="text" name="new_list" class="regular-text" /></p>
								<p>Get users from the lists:</p>
								<?php knews_print_mailinglists(true); ?>
								<div class="submit">
									<input type="submit" value="<?php _e('Create the A/B/C mailing list','knews'); ?>" class="button-primary" />
								</div>
								<?php 
								//Security for CSRF attacks
								wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
								?>
								</form>
							</div>
							<div class="form_subscriber" <?php if (!$stab) echo 'style="display:none;"'; ?>>
								<form method="post" action="admin.php?page=knews_lists&tab=aux#newlist">
								<input type="hidden" name="action" id="action" value="add_list_stats_1" />
								<p>Use the subscriber actions (opened, clicked, not opened, blocked and bounced) to create an auxiliary list</p>
								<p><label for="new_list"><?php _e('New mailing list name:','knews'); ?></label> <input type="text" name="new_list" class="regular-text" /></p>
								<?php
								$query = 'SELECT * FROM ' . KNEWS_NEWSLETTERS . ' WHERE mobile=0 AND (newstype="unknown" OR newstype="manual" OR newstype="") ORDER BY modified DESC';
								$news = $wpdb->get_results( $query );
													
								$alt=true; $nc=0;
								foreach ($news as $n) {
									if ($n->automated==0) {
										if ($nc==0) {
											echo '<div style="float:left; width:45%; margin-right:9%;">';
											echo '<table class="widefat"><thead><tr><th class="manage-column column-cb check-column"><input type="checkbox"></th><th>Manual Newsletters</th></tr></thead>';									
										}
										echo '<tr' . (($alt) ? ' class="alt"' : '') . '><th class="check-column"><input type="checkbox" name="news_id[]" value="' . $n->id . '"></th><td>' . $n->name . ' [' . $n->subject . ']</td></tr>';
										$nc++; $alt = !$alt;
									}
								}
								if ($nc!=0) echo '<tfoot><tr><th class="manage-column column-cb check-column"><input type="checkbox"></th><th>Manual Newsletters</th></tr></tfoot></table></div>';
								
								
								$alt=true; $nc=0;
								foreach ($news as $n) {
									if ($n->automated==1) {
										if ($nc==0) {
											echo '<div style="float:left; width:45%;">';
											echo '<table class="widefat"><thead><tr><th class="manage-column column-cb check-column"><input type="checkbox"></th><th>Auto-created Newsletters</th></tr></thead>';									
										}
										echo '<tr' . (($alt) ? ' class="alt"' : '') . '><th class="check-column"><input type="checkbox" name="news_id[]" value="' . $n->id . '"></th><td>' . $n->name . ' [' . $n->subject . ']</td></tr>';
										$nc++; $alt = !$alt;
									}
								}
								if ($nc!=0) echo '<tfoot><tr><th class="manage-column column-cb check-column"><input type="checkbox"></th><th>Auto-created Newsletters</th></tr></tfoot></table></div>';
								?>
								<div class="submit" style="clear:both">
									<input type="submit" value="<?php _e('Next step','knews'); ?>" class="button-primary" />
								</div>
								<?php
								//Security for CSRF attacks
								wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
								?>
								</form>
							</div>
							<?php
						} elseif ($Knews_plugin->post_safe('action') == 'add_list_stats_1') {
							?>
							<h2><?php _e('Create new auxiliary mailing list based on subscriber actions','knews'); ?></h2>
							<form method="post" action="admin.php?page=knews_lists&tab=aux&stab=2">
							<input type="hidden" name="action" id="action" value="add_list_stats_2" />
							<input type="hidden" name="new_list" value="<?php echo $Knews_plugin->post_safe('new_list'); ?>" />
							<p>Use the subscriber actions (opened, clicked, not opened, blocked and bounced) to create an auxiliary list</p>

							<h3>Which user actions do you want to select?</h3>
							<table class="widefat"><thead><tr><th class="manage-column column-cb"></th><th>User actions</th></tr></thead>
							<tr class="alt"><th class="check-column"><input type="radio" name="user_actions" value="not_opened"></th><td> Not opened</td></tr>
							<tr><th class="check-column"><input type="radio" name="user_actions" value="opened"></th><td> Opened</td></tr>
							<tr class="alt"><th class="check-column"><input type="radio" name="user_actions" value="clicked"></th><td> Click on any content link</td></tr>
							<tr><th class="check-column"><input type="radio" name="user_actions" value="cant_read"></th><td> Can't read click</td></tr>
							<tr class="alt"><th class="check-column"><input type="radio" name="user_actions" value="block_bounced"></th><td> Unsubscribe / Bounced</td></tr>
							<tfoot><tr><th class="manage-column column-cb"></th><th>User actions</th></tr></tfoot></table>

							<h3>Select which newsletter submissions do you want to use:</h3>
							<table class="widefat"><thead><tr><th class="manage-column column-cb check-column"><input type="checkbox"></th><th>Submissions</th></tr></thead>
							<?php
							$query = 'SELECT * FROM ' . KNEWS_NEWSLETTERS_SUBMITS . ' WHERE blog_id=' . get_current_blog_id();
							//if ($Knews_plugin->get_safe('news') != 'all') $query .= ' AND newsletter=' . $Knews_plugin->get_safe('news');
							$news_id = $Knews_plugin->post_safe('news_id');
							if (is_array($news_id)) {
								$n=0;
								$query .= ' AND ';
								if (count($news_id) > 1) $query .= '(';
								foreach ($news_id as $nid) {
									if ($n != 0) $query .= ' OR ';
									$n++;
									$query .= 'newsletter=' . $nid;
								}
								if (count($news_id) > 1) $query .= ')';
							}
							$query .= ' AND finished=1 ORDER BY start_time DESC';
							$news = $wpdb->get_results( $query );
							
							$alt=true;
							foreach ($news as $n) {
								echo '<tr' . (($alt) ? ' class="alt"' : '') . '><th class="check-column"><input type="checkbox" name="submit_id[]" value="' . $n->id . '"></th><td>' . $Knews_plugin->humanize_dates($n->start_time,'mysql') . ' ';
								if ($n->users_ok != 0 ) echo '<span style="color:#048210">' . $n->users_ok . ' OK</span>';
								if ($n->users_ok != 0 && $n->users_error != 0) echo ' / ';
								if ($n->users_error != 0 ) {
									echo '<span style="color:#b30000">' . $n->users_error . ' ERROR</span>';
								}
								echo '</td></tr>';
								$alt = !$alt;
							}
							?>
							<tfoot><tr><th class="manage-column column-cb check-column"><input type="checkbox"></th><th>Submissions</th></tr></tfoot></table>
							<div class="submit">
								<input type="submit" value="<?php _e('Create mailing list','knews'); ?>" class="button-primary" />
							</div>
							<?php 
							//Security for CSRF attacks
							wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
							?>
							</form>

			
							<?php
						}

					endif;
				?>
	</div>
