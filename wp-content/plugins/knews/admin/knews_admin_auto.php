<?php
//Security for CSRF attacks
$knews_nonce_action='kn-adm-auto';
$knews_nonce_name='_autokn';
if (!empty($_POST)) $w=check_admin_referer($knews_nonce_action, $knews_nonce_name);
//End Security for CSRF attacks

	global $Knews_plugin, $wpdb, $knewsOptions;
	require_once( KNEWS_DIR . '/includes/knews_util.php');

	$pending=false;

	$languages = $Knews_plugin->getLangs(true);
	
	if ($Knews_plugin->get_safe('da')=='delete') {
		$query="DELETE FROM " . KNEWS_AUTOMATED . " WHERE id=" . $Knews_plugin->get_safe('idauto', 0, 'int');
		$results = $wpdb->query( $query );
		echo '<div class="updated"><p>' . __('Automated process deleted','knews') . '</p></div>';
	}

	if ($Knews_plugin->get_safe('activated')==1 || $Knews_plugin->get_safe('activated',2)==0) {
		$query = "UPDATE ".KNEWS_AUTOMATED." SET paused=" . $Knews_plugin->get_safe('activated') . " WHERE id=" . $Knews_plugin->get_safe('idauto', 0, 'int');
		$result=$wpdb->query( $query );
		echo '<div class="updated"><p>' . (($Knews_plugin->get_safe('activated')!=1) ? __('Automated process activated','knews') : __('Automated process deactivated','knews')) . '</p></div>';
	}

	if ($Knews_plugin->get_safe('auto')==1 || $Knews_plugin->get_safe('auto',2)==0) {
		$query = "UPDATE ".KNEWS_AUTOMATED." SET auto=" . $Knews_plugin->get_safe('auto') . " WHERE id=" . $Knews_plugin->get_safe('idauto', 0, 'int');
		$result=$wpdb->query( $query );
		echo '<div class="updated"><p>' . (($Knews_plugin->get_safe('auto')==1) ? __('Automated submit activated','knews') : __('Manual submit activated','knews')) . '</p></div>';
	}

	if ($Knews_plugin->post_safe('action')=='add_autoresponder' || $Knews_plugin->post_safe('action')=='add_auto') {

		$name = $Knews_plugin->post_safe('auto_name');
		$lang = $Knews_plugin->post_safe('auto_lang');
		$news = $Knews_plugin->post_safe('auto_newsletter');
		$target = $Knews_plugin->post_safe('auto_target');
		$paused = $Knews_plugin->post_safe('auto_paused', 0);
		$auto = $Knews_plugin->post_safe('auto_auto', 0);
		$mode = $Knews_plugin->post_safe('auto_mode', 0);
		$posts = $Knews_plugin->post_safe('auto_posts', 0);
		$time = $Knews_plugin->post_safe('auto_time', 0);
		$day = $Knews_plugin->post_safe('auto_dayweek', 0);
		$at_once = $Knews_plugin->post_safe('emails_at_once', 50);
		$id_smtp = $Knews_plugin->post_safe('knews_select_smtp', 1);
		
		$event = $Knews_plugin->post_safe('auto_event');
		$delay = $Knews_plugin->post_safe('auto_delay', 0);
		$delay_unit = $Knews_plugin->post_safe('auto_delay_unit');	

		$type = 'autocreate'; if ($Knews_plugin->post_safe('action')=='add_autoresponder') $type = 'autoresponder';
		
		$knews_cpt='';
		$knews_categories='';
		$knews_exclude_categories='';
		$knews_tags='';
		$knews_exclude_tags='';
		$knews_ignore_post_opt = 0;
		$use_post_embed_pref = 1;


		if ($name =='' || $news=='' || $target=='') {
			
			echo '<div class="error"><p><strong>';
			if ($name=='') {
				_e('Error: the name cant be empty','knews');
			} else {
				_e('Error: Please, fill all the form','knews');
			}
			echo '</strong></p></div>';

		} else {
			$query = "SELECT * FROM " . KNEWS_AUTOMATED . " WHERE name='" . $name . "'";
			$results = $wpdb->get_results( $query );
			
			if (count($results)==0) {
				$sql = "INSERT INTO " . KNEWS_AUTOMATED . " (name, selection_method, target_id, newsletter_id, lang, paused, auto, every_mode, every_time, what_dayweek, every_posts, last_run, emails_at_once, run_yet, id_smtp, what_is, event, delay, delay_unit, include_cats, exclude_cats, include_tags, exclude_tags, include_postypes, use_post_embed_pref) VALUES (";
				$sql .= "'" . $name . "', 1, " . $target . ", " . $news . ", '" . $lang . "', " . $paused . ", " . $auto . ", " . $mode . ", " . $time . ", " . $day . ", " . $posts . ", '" . $Knews_plugin->get_mysql_date() . "', " . $at_once . ", 0, " . $id_smtp . ", '" . $type . "', '" . $event . "', " . $delay . ", '" . $delay_unit . "', '" . $knews_categories . "', '" . $knews_exclude_categories . "', '" . $knews_tags . "', '" . $knews_exclude_tags . "', '" . $knews_cpt . "', " . $use_post_embed_pref . ")";
				
				if ($wpdb->query($sql)) {
					echo '<div class="updated"><p>' . __('Automated submit created','knews') . '</p></div>';
				} else {
					echo '<div class="error"><p><strong>' . __('Error','knews') . ':</strong> ' . __("Cant create the automated submit",'knews') . ' : ' . $wpdb->last_error . '</p></div>';
				}
			} else {
				echo '<div class="error"><p><strong>';
				_e('Error: there is already an automated submit with this name','knews');
				echo '</strong></p></div>';
			}
		}
	}

	$results_per_page=10;
	$paged = $Knews_plugin->get_safe('paged', 1, 'int');

	$query = "SELECT * FROM " . KNEWS_NEWSLETTERS . " WHERE automated=0 AND mobile=0 ORDER BY modified DESC";
	$news = $wpdb->get_results( $query );

	$frequency = array ('daily','weekly','every 15 days','monthly','every 2 months','every 3 months');
	$dayname = array ('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	
	$query = "SELECT id, name FROM " . KNEWS_LISTS . " WHERE auxiliary=0 ORDER BY orderlist";
	$lists_name = $wpdb->get_results( $query );

	if (!$Knews_plugin->im_pro()) {
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('input[name="knews_get_cpt"], input[name="knews_get_categories"], input[name="knews_get_tags"], input[name="knews_ignore_post_opt"]')
			.click(function(event) {
				location.href='admin.php?page=knews_config&tab=pro';
				return false;
			})
			.change(function() {
				return false;
			});
		});
	
	</script>
<?php
	}
?>
	<link href="<?php echo KNEWS_URL; ?>/admin/styles.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo KNEWS_URL; ?>/admin/scripts.js"></script>
	<script type="text/javascript">
		var knews_cats_tags = new Array();
		knews_cats_tags['cats']=new Array();
		knews_cats_tags['tags']=new Array();
<?php
	$cats=array(); $tags=array();
?>
	</script>
	<div class=wrap>
			<div class="icon32" style="background:url(<?php echo KNEWS_URL; ?>/images/icon32.png) no-repeat 0 0;"><br></div>
		<h2 class="nav-tab-wrapper">
<?php
if ($Knews_plugin->get_safe('tab')!='autoresponders') {
?>
		<a href="admin.php?page=knews_auto" class="nav-tab nav-tab-active"><?php _e('Autocreators','knews'); ?></a>
		<a href="admin.php?page=knews_auto&tab=autoresponders" class="nav-tab"><?php _e('Autoresponders','knews'); ?></a></h2><br />
			<?php 
			$query = "FROM " . KNEWS_AUTOMATED . " WHERE what_is='autocreate'";

			$filtered_automated = $wpdb->get_results( 'SELECT COUNT(id) AS n ' . $query );
			$filtered_automated = $filtered_automated[0]->n;

			$query .= " LIMIT " . $results_per_page . " OFFSET " . $results_per_page * ($paged - 1);

			$results = $wpdb->get_results( 'SELECT * ' . $query );

			if (count($results) != 0) {
			?>
				<form method="post" action="admin.php?page=knews_auto">
				<table class="widefat">
					<thead>
						<tr>
							<?php /*<th class="manage-column column-cb check-column"><input type="checkbox" /></th>*/ ?>
							<th align="left"><?php _e('Automated process name','knews');?></th>
							<th><?php _e('Target','knews');?></th>
							<th><?php _e('Newsletter','knews');?></th>
							<th><?php _e('Language','knews');?></th>
							<th><?php _e('Activated','knews');?></th>
							<th><?php _e('Automatic submit','knews');?></th>
							<th><?php _e('Method','knews');?></th>
							<th><?php _e('Last run','knews');?></th>
							<th><?php _e('Details','knews');?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$alt=true;
					$results_counter=0;
					foreach ($results as $automated) {
						$results_counter++;
						//if ($results_per_page * ($paged-1)<$results_counter) {
							echo '<tr' . (($alt) ? ' class="alt"' : '') . '>'; //<th class="check-column"><input type="checkbox" name="batch_' . $list->id . '" value="1"></th>';
							echo '<td class="name_' . $automated->id  . '"><strong>' . $automated->name . '</strong>';
							
							echo '<div class="row-actions"><span><a title="' . __('Activate/deactivate the automated task', 'knews') . '" href="admin.php?page=knews_auto&activated=' . (($automated->paused==1) ? '0' : '1') . '&idauto=' . $automated->id . '">' . (($automated->paused==1) ? __('Activate', 'knews') : __('Deactivate', 'knews')) . '</a> | </span>';

							echo '<span><a title="' . __('Automatic/Manual submits of auto-created newsletters', 'knews') . '" href="admin.php?page=knews_auto&auto=' . (($automated->auto==1) ? '0' : '1') . '&idauto=' . $automated->id . '">' . (($automated->auto==1) ? __('Manual submit', 'knews') : __('Submit automatic', 'knews')) . '</a> | </span>';

							echo '<span class="trash"><a href="admin.php?page=knews_auto&da=delete&idauto=' . $automated->id . '" title="' . __('Delete definitively this automated task', 'knews') . '" class="submitdelete">' . __('Delete', 'knews') . '</a></span></div>';

							echo '</td><td>';
							foreach ($lists_name as $ln) {
								if ($ln->id==$automated->target_id) {
									echo $ln->name;
									break;
								}
							}
							echo '</td>';
							echo '<td>';
							foreach ($news as $n) {
								if ($n->id==$automated->newsletter_id) {
									echo $n->name;
									break;
								}
							}
							echo '</td>';
							echo '<td>' . $automated->lang . '</td>';
							echo '<td>' . (($automated->paused==1) ? __('Off', 'knews') : __('On', 'knews')) . '</td>';
							if ($automated->paused!=1) $pending=true;
							echo '<td>' . (($automated->auto==1) ? __('Automated submit', 'knews') : __('Manual submit', 'knews')) . '</td>';
							echo '<td>';
							if ($automated->every_mode ==1) {
								printf( 'every %s posts', $automated->every_posts);
							} else {
								echo $frequency[$automated->every_time - 1];
								if ($automated->every_time > 1) echo ' on ' . $dayname[$automated->what_dayweek-1];
							}
							echo '</td>';
							echo '<td>' . (($automated->run_yet==0) ? __('NEVER','knews') : $automated->last_run) . '</td>';
							echo '<td><a href="#" class="knews_details knews_alert_click" title="';
							if ($automated->include_postypes != '') echo 'Only this post types: ' . $automated->include_postypes . "\r\n";
							if ($automated->include_cats != '') echo 'Only from this categories: ' . knews_list_items($automated->include_cats, $all_cats) . "\r\n";
							if ($automated->exclude_cats != '') echo 'Exclude this categories: ' . knews_list_items($automated->exclude_cats, $all_cats) . "\r\n";
							if ($automated->include_cats == '' && $automated->exclude_cats == '') echo 'All categories will be included' . "\r\n";
							if ($automated->include_tags != '') echo 'Only from this tags: ' . knews_list_items($automated->include_tags, $all_tags) . "\r\n";
							if ($automated->exclude_tags != '') echo 'Exclude this tags: ' . knews_list_items($automated->exclude_tags, $all_tags) . "\r\n";
							if ($automated->include_tags == '' && $automated->exclude_tags == '') echo 'All tags will be included' . "\r\n";
							echo 'Ignore the Knews Automation post setting: ' . (($automated->use_post_embed_pref == 0) ? 'Yes' : 'No') . "\r\n";
							echo $automated->emails_at_once * 6 . ' emails per hour sent' . "\r\n";
							echo 'Submit method: ' . (($automated->auto==1) ? 'Automated' : 'Manual') . "\r\n";
							if (isset($all_smtp[$automated->id_smtp])) echo 'It will be sent from: ' . $all_smtp[$automated->id_smtp]['from_mail_knews'];
							echo '">+</a></td></tr>';
						//}
						$alt=!$alt;
						//if ($results_counter == $results_per_page * $paged) break;
					}
					?>
					</tbody>
					<tfoot>
						<tr>
							<th align="left"><?php _e('Automated process name','knews');?></th>
							<th><?php _e('Target','knews');?></th>
							<th><?php _e('Newsletter','knews');?></th>
							<th><?php _e('Language','knews');?></th>
							<th><?php _e('Activated','knews');?></th>
							<th><?php _e('Automatic submit','knews');?></th>
							<th><?php _e('Method','knews');?></th>
							<th><?php _e('Last run','knews');?></th>
							<th><?php _e('Details','knews');?></th>
						</tr>
					</tfoot>
				</table>
				<?php 
				//Security for CSRF attacks
				wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
				?>
				</form>
				<?php
				//Pagination
				echo '<div class="tablenav bottom">';
				knews_pagination($paged, ceil($filtered_automated/ $results_per_page), $filtered_automated);
				echo '</div>';

				if ($pending) {
				?>
				<div class="updated">
					<p><?php _e('Knews runs every hour the automated newsletter creation jobs.','knews'); ?></p>
					<p><?php echo sprintf(__('You can manually trigger this task now (only recommended for testing purposes) %s Run Automated Creation Now','knews'), '<a href="' . get_admin_url() . 'admin-ajax.php?action=knewsForceAutomated&manual=1" class="button" target="_blank">'); ?></a></p>
				</div>
				<?php
				}
			} else {
			?>
				<p><?php _e('At the moment there is no automated task, you can create new ones','knews'); ?></p>
			<?php
			}
			?><p>&nbsp;</p>
			<hr />
			<a id="newauto"></a>
			<h2><?php _e('New Auto-creation Process','knews');?> <a href="<?php _e('http://www.knewsplugin.com/automated-newsletter-creation/','knews'); ?>" style="background:url(<?php echo KNEWS_URL; ?>/images/help.png) no-repeat 5px 0; padding:3px 0 3px 30px; color:#0646ff; font-size:15px;" target="_blank"><?php _e('Auto-create Newsletters Tutorial','knews'); ?></a></h2>
			<form method="post" action="admin.php?page=knews_auto" id="create_auto">
				<input type="hidden" name="action" id="action" value="add_auto" />
				<h3><?php _e('General options','knews'); ?></h3>
				<p><label for="auto_name"><?php _e('Automated process name:','knews');?> </label><input type="text" name="auto_name" id="auto_name" class="regular-text" /></p> 
				<p><label for="auto_paused"><?php _e('Active process:','knews');?></label> <select name="auto_paused" id="auto_paused"><option value="0" selected="selected"><?php _e('On','knews');?></option><option value="1"><?php _e('Off','knews');?></option></select></p>
				<h3><?php _e('Newsletter creation options','knews');?></h3>
				<?php
				$lang_listed = false;
				
				if (count($languages) > 1) {
					
					echo '<p><label for="auto_lang">' . __('Get posts from language:','knews') . '</label> <select name="auto_lang" id="auto_lang" autocomplete="off">';
					foreach($languages as $l){
						echo '<option value="' . $l['language_code'] . '"' . (($l['active']==1) ? ' selected="selected" ' : '') . '>' . $l['translated_name'] . '</option>';
					}
					echo '</select></p>';
		
				} else if (count($languages) == 1) {
					foreach ($languages as $l) {
						echo '<input type="hidden" name="auto_lang" id="auto_lang" value="' . $l['language_code'] . '" />';
					}
				} else {
					echo  '<p>' . __('Error','knews') . ": " . __('Language not detected!','knews') . '</p>';
				}
				?>
				<p><label for="auto_newsletter"><?php _e('Use as template:','knews');?></label> 
				<?php
				$disponible_news=array();
				foreach ($news as $n) {
					if (strrpos($n->html_mailing, '%the_title') !== false || strrpos($n->html_mailing, '%the_excerpt') !== false || strrpos($n->html_mailing, '%the_content') !== false && ($n->newstype == 'unknown' || $n->newstype == 'autocreation')) {
						$disponible_news[]=$n;
					}
				}
				if (count($disponible_news) != 0) {
					echo '<select name="auto_newsletter" id="auto_newsletter">';
					foreach ($disponible_news as $n) {
						echo '<option value="' . $n->id . '"' . (($Knews_plugin->get_safe('id')==$n->id) ? ' selected="selected"' : '') . '>' . $n->name . ' (' . $n->lang . ')</option>';
					}
					echo '</select></p>';
				} else {
					echo __('You must first create a newsletter with insertable info (leave the %the_content%, %the_title% etc.)','knews') . '</p>';
				}
				?>
				<p><input type="radio" name="auto_mode" autocomplete="off" value="1" checked="checked" /><?php printf(__('Create a newsletter every %s posts','knews'), '<input type="text" name="auto_posts" id="auto_posts" value="5" style="text-align:right; width:30px;" />');?></p>
				<p><input type="radio" name="auto_mode" autocomplete="off" value="2" /> <?php _e('Create a newsletter every x amount of time','knews');?> 
				<?php /*<span id="auto_mode_1">Every <input type="text" name="auto_posts" id="auto_posts" value="5" style="width:30px;" /> posts</span>*/?>
				<span id="auto_mode_2" style="display:none;"><label for="auto_time"><?php _e('Submit','knews'); ?></label> <select name="auto_time" id="auto_time" autocomplete="off">
				<?php
				$f=0;
				foreach ($frequency as $fre) {
					$f++;
					echo '<option value="' . $f . '">' . $fre . '</option>';
				}
				?>
				</select><span id="dayweek">, <label for="auto_dayweek">on</label> <select name="auto_dayweek" id="auto_dayweek">
				<?php
				$d=0;
				foreach ($dayname as $day_name) {
					$d++;
					echo '<option value="' . $d . '">' . $day_name . '</option>';
				}
				?>
				</select></span></p>
				<h3><?php _e('Post selection advanced criteria (Knews Pro Features)','knews'); ?></h3>
				<?php 
				$howmany=0;
				$post_types = array('name' => 'post', 'label' => 'post');
				if ($Knews_plugin->im_pro()) $post_types = $Knews_plugin->getCustomPostTypes();
				foreach ($post_types as $pt) {
					$howmany++;

					if ($howmany == 1) {
						?>
						<p><input type="checkbox" name="knews_get_cpt" value="1" autocomplete="off" /> Get only from this Custom Post Types:</p>
						<?php
						echo '<div class="knews_hidden_cpt">';
						echo '<select size="6" multiple="multiple" name="knews_cpt[]">';

					}
					echo '<option value="' . $pt['name'] . '"> ' . $pt['label'] . '</option>';
				}
				if ($howmany != 0) echo '</select></div>';

				//$cats = get_categories(array('hide_empty' => 0));
				if (count($cats) > 0 || !$Knews_plugin->im_pro()) {
				?>
				<div class="knews_radios_cat">
					<p>
					<input type="radio" name="knews_get_categories" value="all" checked="checked" autocomplete="off" /> Get from all categories<br />
					<input type="radio" name="knews_get_categories" value="include" autocomplete="off" /> Get from this categories:<br />
					<input type="radio" name="knews_get_categories" value="exclude" autocomplete="off" /> Exclude this categories:
					</p>
					<div class="knews_hidden_cat">
						<select size="6" multiple="multiple" name="knews_categories[]">
						<?php
						foreach ($cats as $c) {
							echo '<option value="' . $c->term_id . '">' . $c->name . '</option>';
						}
						?>
						</select>
					</div>
				</div>
				<?php
				}
				//$tags = get_tags(array('hide_empty' => 0));
				if (count($tags) > 0 || !$Knews_plugin->im_pro()) {
				?>
				<div class="knews_radios_tags">
					<p>
					<input type="radio" name="knews_get_tags" value="all" checked="checked" autocomplete="off" /> Get from all tags<br />
					<input type="radio" name="knews_get_tags" value="include" autocomplete="off" /> Get from this tags:<br />
					<input type="radio" name="knews_get_tags" value="exclude" autocomplete="off" /> Exclude this tags:
					</p>
					<div class="knews_hidden_tags">
						<select size="6" multiple="multiple" name="knews_tags[]">
						<?php
						foreach ($tags as $t) {
							echo '<option value="' . $t->term_id . '">' . $t->name . '</option>';
						}
						?>
						</select>
					</div>
				</div>
				<?php
				}
				?>
				<p><input type="checkbox" name="knews_ignore_post_opt" value="1" autocomplete="off" /> Ignore the Knews Automation post setting (posts will be embeded if the above conditions are met)</p>
				<h3><?php _e('Newsletter submit options','knews'); ?></h3>
				<?php
				if (count($lists_name) != 0) {
					?>
					<p><label for="auto_target"><?php _e('Target for newsletter:','knews');?></label> 
					<select name="auto_target" id="auto_target">
					<?php
					foreach ($lists_name as $ln) {
						echo '<option value="' . $ln->id . '">' . $ln->name . '</option>';
					}
					?>
					</select>
					</p>
					<?php
				} else {
					echo '<p>' . __('Error: there are no mailing lists','knews'). '</p>';
				}
				?>
				<p><label for="auto_auto"><?php _e('Submit method:','knews');?></label> <select name="auto_auto" id="auto_auto"><option value="0" selected="selected"><?php _e('Manual submit','knews');?></option><option value="1"><?php _e('Automated submit','knews');?></option></select></p>
<p><?php _e('E-mails sent at once','knews');?>: <select name="emails_at_once"><option value="2">2 <?php _e('test mode','knews');?></option><option value="10">10</option><option value="25">25</option><option value="50" selected="selected">50 <?php _e('(normal)','knews');?></option><option value="100">100</option><option value="250">250 <?php _e('(high performance SMTP)','knews');?></option><option value="500">500 <?php _e('(high performance SMTP)','knews');?></option></select> <span class="at_once_preview">300</span> per hour.</p>
<?php if ($Knews_plugin->im_pro()) {
if ($selector = $Knews_plugin->get_smtp_selector()) {
	echo '<p>Use the SMTP: ' . $selector . '</p>';
}
?>
<?php } ?>
				<p><input type="submit" value="<?php _e('New Auto-create Newsletters Process','knews'); ?>" class="button-primary" /></p>
				<?php 
				//Security for CSRF attacks
				wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
				?>
			</form>
<?php
} else {
?>
		<a href="admin.php?page=knews_auto" class="nav-tab"><?php _e('Autocreators','knews'); ?></a>
		<a href="admin.php?page=knews_auto&tab=autoresponders" class="nav-tab nav-tab-active"><?php _e('Autoresponders','knews'); ?></a></h2><br />
<?php 
			$query = "FROM " . KNEWS_AUTOMATED . " WHERE what_is='autoresponder'";

			$filtered_automated = $wpdb->get_results( 'SELECT COUNT(id) AS n ' . $query );
			$filtered_automated = $filtered_automated[0]->n;

			$query .= " LIMIT " . $results_per_page . " OFFSET " . $results_per_page * ($paged - 1);

			$results = $wpdb->get_results( 'SELECT * ' . $query );
			$pending=false;
			if (count($results) != 0) {
				$pending=true;
			?>
				<form method="post" action="admin.php?page=knews_auto&tab=autoresponders">
				<table class="widefat">
					<thead>
						<tr>
							<?php /*<th class="manage-column column-cb check-column"><input type="checkbox" /></th>*/ ?>
							<th align="left"><?php _e('autoresponder process name','knews');?></th>
							<th><?php _e('Event','knews');?></th>
							<th><?php _e('Suscribed to','knews');?></th>
							<th><?php _e('User language','knews');?></th>
							<th><?php _e('Newsletter','knews');?></th>
							<th><?php _e('Activated','knews');?></th>
							<th><?php _e('Delay','knews');?></th>
							<th><?php _e('Details','knews');?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$alt=true;
					$results_counter=0;
					foreach ($results as $automated) {
						$results_counter++;
						//if ($results_per_page * ($paged-1)<$results_counter) {
							echo '<tr' . (($alt) ? ' class="alt"' : '') . '>'; //<th class="check-column"><input type="checkbox" name="batch_' . $list->id . '" value="1"></th>';
							echo '<td class="name_' . $automated->id  . '"><strong>' . $automated->name . '</strong>';
							
							echo '<div class="row-actions"><span><a title="' . __('Activate/deactivate the automated task', 'knews') . '" href="admin.php?page=knews_auto&activated=' . (($automated->paused==1) ? '0' : '1') . '&tab=autoresponders&idauto=' . $automated->id . '">' . (($automated->paused==1) ? __('Activate', 'knews') : __('Deactivate', 'knews')) . '</a> | </span>';

							echo '<span class="trash"><a href="admin.php?page=knews_auto&tab=autoresponders&da=delete&idauto=' . $automated->id . '" title="' . __('Delete definitively this automated task', 'knews') . '" class="submitdelete">' . __('Delete', 'knews') . '</a></span></div>';

							echo '</td><td>';
							echo $automated->event;
							echo '</td><td>';

							if ($automated->target_id==0) {
								echo __('All','knews');
							} else {
								foreach ($lists_name as $ln) {
									if ($ln->id==$automated->target_id) {
										echo $ln->name;
										break;
									}
								}
							}
							echo '</td>';
							echo '<td>' . (($automated->lang=='') ? 'All' : $automated->lang) . '</td><td>';
							foreach ($news as $n) {
								if ($n->id==$automated->newsletter_id) {
									echo $n->name;
									break;
								}
							}
							echo '</td>';
							echo '<td>' . (($automated->paused==1) ? __('Off', 'knews') : __('On', 'knews')) . '</td>';
							echo '<td>' . $automated->delay . ' ' . $automated->delay_unit . '</td>';

							echo '<td><a href="#" class="knews_details knews_alert_click" title="';
							echo $automated->emails_at_once * 6 . ' emails per hour sent' . "\r\n";
							if (isset($all_smtp[$automated->id_smtp])) echo 'It will be sent from: ' . $all_smtp[$automated->id_smtp]['from_mail_knews'];
							echo '">+</a></td></tr>';
						//}
						$alt=!$alt;
						//if ($results_counter == $results_per_page * $paged) break;
					}
					?>
					</tbody>
					<tfoot>
						<tr>
							<th align="left"><?php _e('autoresponder process name','knews');?></th>
							<th><?php _e('Event','knews');?></th>
							<th><?php _e('Suscribed to','knews');?></th>
							<th><?php _e('User language','knews');?></th>
							<th><?php _e('Newsletter','knews');?></th>
							<th><?php _e('Activated','knews');?></th>
							<th><?php _e('Delay','knews');?></th>
							<th><?php _e('Details','knews');?></th>
						</tr>
					</tfoot>
				</table>
				<?php 
				//Security for CSRF attacks
				wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
				?>
				</form>
				<?php
				//Pagination
				echo '<div class="tablenav bottom">';
				knews_pagination($paged, ceil($filtered_automated/ $results_per_page), $filtered_automated);
				echo '</div>';

				if ($pending) {
				?>
				<div class="updated">
					<p><?php _e('Knews runs every hour the automated newsletter creation jobs.','knews'); ?></p>
					<p><?php echo sprintf(__('You can manually trigger this task now (only recommended for testing purposes) %s Run Automated Creation Now','knews'), '<a href="' . get_admin_url() . 'admin-ajax.php?action=knewsForceAutomated&manual=1" class="button" target="_blank">'); ?></a></p>
				</div>
				<?php
				}
			} else {
			?>
				<p><?php _e('At the moment there is no autoresponder tasks, you can create new ones','knews'); ?></p>
			<?php
			}
			?><p>&nbsp;</p>
			<hr />
			<a id="newauto"></a>
			<h2><?php _e('New autoresponder','knews');?> <a href="http://www.knewsplugin.com/knews-have-autoresponders/" style="background:url(<?php echo KNEWS_URL; ?>/images/help.png) no-repeat 5px 0; padding:3px 0 3px 30px; color:#0646ff; font-size:15px;" target="_blank"><?php _e('Autoresponders Tutorial','knews'); ?></a></h2>

			<form method="post" action="admin.php?page=knews_auto&tab=autoresponders" id="create_autoresponder">
				<input type="hidden" name="action" id="action" value="add_autoresponder" />
				<p><label for="auto_name"><?php _e('autoresponder name:','knews');?> </label><input type="text" name="auto_name" id="auto_name" class="regular-text" /></p> 

				<p><label for="auto_event"><?php _e('Event:','knews');?></label> 
				<select name="auto_event" id="auto_event">
					<option value="not_confirmed"><?php _e('Not confirmed','knews'); ?></option>
					<option value="after_confirmation"><?php _e('After confirmation','knews'); ?></option>
				</select></p>
				
				<p><label for="auto_delay"><?php _e('Delay:','knews');?> *</label> <input type="text" name="auto_delay" id="auto_delay" value="1" style="text-align:right; width:30px;" />
				<select name="auto_delay_unit" id="auto_delay_unit">
					<option value="minutes"><?php _e('minutes','knews'); ?></option>
					<option value="hours"><?php _e('hours','knews');?></option>
					<option value="days" selected="selected"><?php _e('days','knews'); ?></option>
					<option value="weeks"><?php _e('weeks','knews'); ?></option>
				</select><br />
				<?php _e ('* Not confirmed autoresponder should have some delay, otherwise the subscribers will recieve the autoresponder without time to confirm','knews'); ?></p>
				
				<p><label for="auto_newsletter"><?php _e('Use as template:','knews');?></label> 
				<?php
				$disponible_news=array();
				foreach ($news as $n) {
					if (strrpos($n->html_mailing, '%the_title') == false && strrpos($n->html_mailing, '%the_excerpt') == false && strrpos($n->html_mailing, '%the_content') == false && ($n->newstype == 'unknown' || $n->newstype == 'autoresponder')) {
						$disponible_news[]=$n;
					}
				}
				if (count($disponible_news) != 0) {
					echo '<select name="auto_newsletter" id="auto_newsletter">';
					foreach ($disponible_news as $n) {
						echo '<option value="' . $n->id . '"' . (($Knews_plugin->get_safe('id')==$n->id) ? ' selected="selected"' : '') . '>' . $n->name . ' (' . $n->lang . ')</option>';
					}
					echo '</select></p>';
				} else {
					echo __('You must first create a newsletter as must shown (remove all %the_content%, %the_title% etc.)','knews') . '</p>';
				}
				if (count($lists_name) != 0) {
					?>
					<p><label for="auto_target"><?php _e('Only for users suscribed to:','knews');?></label> 
					<select name="auto_target" id="auto_target">
					<?php
					echo '<option value="0">' . __('All','knews') . '</option>';
					foreach ($lists_name as $ln) {
						echo '<option value="' . $ln->id . '">' . $ln->name . '</option>';
					}
					?>
					</select>
					</p>
					<?php
				} else {
					echo '<p>' . __('Error: there are no mailing lists','knews'). '</p>';
				}
				?>
				<?php
				if (count($languages) > 1) {
					
					echo '<p><label for="auto_lang">' . __('Only for users who speak the language:','knews') . '</label> <select name="auto_lang" id="auto_lang" autocomplete="off">';
					echo '<option value="" selected="selected">All</option>';
					foreach($languages as $l){
						echo '<option value="' . $l['language_code'] . '">' . $l['translated_name'] . '</option>';
					}
					echo '</select></p>';
		
				} else if (count($languages) == 1) {
					foreach ($languages as $l) {
						echo '<input type="hidden" name="auto_lang" id="auto_lang" value="' . $l['language_code'] . '" />';
					}
				} else {
					echo  '<p>' . __('Error','knews') . ": " . __('Language not detected!','knews') . '</p>';
				}
				?>
				</p>
<div id="at_once"><p><?php _e('E-mails sent at once','knews');?>: <select name="emails_at_once"><option value="2">2 <?php _e('test mode','knews');?></option><option value="10">10</option><option value="25">25</option><option value="50" <?php if (!defined('KNEWS_CUSTOM_SPEED')) echo 'selected="selected"'; ?>>50 <?php _e('(normal)','knews');?></option><option value="100">100</option><option value="250">250 <?php _e('(high performance SMTP)','knews');?></option><option value="500">500 <?php _e('(high performance SMTP)','knews');?></option>
<?php if (defined('KNEWS_CUSTOM_SPEED')) echo '<option value="' . KNEWS_CUSTOM_SPEED . '" selected="selected">' . KNEWS_CUSTOM_SPEED . '</option>'; ?>
</select> <span class="at_once_preview"><?php if (defined('KNEWS_CUSTOM_SPEED')) echo KNEWS_CUSTOM_SPEED; else echo '300'; ?></span> per hour.</p>
</div>
<?php if ($Knews_plugin->im_pro()) {
if ($selector = $Knews_plugin->get_smtp_selector()) {
	echo '<p>Use the SMTP: ' . $selector . '</p>';
}
?>
<?php } ?>
				<p><input type="submit" value="<?php _e('New autoresponder','knews'); ?>" class="button-primary" /></p>
				<?php 
				//Security for CSRF attacks
				wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
				?>
			</form>
<?php
}
?>
	</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#create_auto input, #create_auto select').change(function() {
			val=jQuery('input[name=auto_mode]:checked', '#create_auto').val();
			//jQuery('span#auto_mode_1, span#auto_mode_2').hide();
			//jQuery('span#auto_mode_' + val).show();
			if (val==2) {
				jQuery('span#auto_mode_2').show();
				if (jQuery('#auto_time').val() != 1) {
					jQuery('#dayweek').show();
				} else {
					jQuery('#dayweek').hide();					
				}
			} else {
				jQuery('span#auto_mode_2').hide();
			}
		});
		jQuery('#auto_auto').change(function() {
			val=jQuery(this).val();
			if (val==0) {
				jQuery('div#at_once').hide();
			} else {
				jQuery('div#at_once').show();
			}
		});
	});
</script>