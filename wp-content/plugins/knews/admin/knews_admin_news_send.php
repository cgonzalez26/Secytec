<?php
//Security for CSRF attacks
$knews_nonce_action='kn-news-send';
$knews_nonce_name='_nwsend';
if (!empty($_POST)) $w=check_admin_referer($knews_nonce_action, $knews_nonce_name);
//End Security for CSRF attacks

	global $knewsOptions, $Knews_plugin;
	
	require_once( KNEWS_DIR . '/includes/knews_util.php');

	$submit_enqueued=false;

	if (! $Knews_plugin->initialized) $Knews_plugin->init();

	$id_newsletter = $Knews_plugin->get_safe('id');

	if (isset($_POST['action'])) {
		if ($_POST['action']=='submit_manual') {
			
			require( KNEWS_DIR . "/includes/knews_compose_email.php");



/*
			preg_match_all ("/(a|A)[\s]+[^>]*?href[\s]?=[\s\"\']+".
				"(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/(a|A)>/", 
				$theHtml, $matches);

			foreach ($matches[3] as $textlink) {
				if (strpos($textlink, '/') !== false)  {
					$textlink2=str_replace('/', "<span>\r\n</span>" . '/', $textlink);
					//$textlink2=str_replace('/', '<span>' . "\r\n" . '</span>/', $textlink);
					//$textlink2=str_replace('<span>' . "\r\n" . '</span>/<span>' . "\r\n" . '</span>/', '//', $textlink2);
					$theHtml=str_replace($textlink, $textlink2, $theHtml);
				}
			}
			
*/

			$user=$wpdb->get_row("SELECT * FROM " . KNEWS_USERS . " WHERE email='" . $Knews_plugin->post_safe('email') . "'");
			$id_smtp = $Knews_plugin->post_safe('knews_select_smtp',1);
			if (count($user)==1) {
				$aux_array=array();
				//array('token'=>$token->token, 'id'=>$token->id, 'default'=>$tokenfound[1])

				foreach ($used_tokens as $token) {
					$aux_array[] = array( 'token' => $token['token'], 'value' => $Knews_plugin->get_user_field($user->id, $token['id'], $token['defaultval']) );
				}
				$user->tokens = $aux_array;
				$user->unsubscribe = $Knews_plugin->get_localized_home($user->lang, 'knews=unsubscribe&e=' . urlencode($user->email) . '&k=' . $user->confkey);
				$url_news = $Knews_plugin->get_localized_home($user->lang, 'knews=readEmail&id=' . $id_newsletter);
				$user->cant_read = $url_news . '&e=' . urlencode($user->email);
				$user->fb_like = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url_news . '&share=fb');
				$user->tweet = 'http://twitter.com/share?text=#news_title_encoded#&url=' . urlencode($url_news . '&share=tw');

				$result=$Knews_plugin->sendMail( array( $user ), $theSubject, $theHtml, '', '', false, false, 0, $id_smtp );
			} else {
				$user = new stdClass;
				$user->unsubscribe = '#';
				$user->cant_read = $Knews_plugin->get_localized_home('', 'knews=readEmail&id=' . $id_newsletter );
				$user->email = $Knews_plugin->post_safe('email');
				
				$result=$Knews_plugin->sendMail( array( $user ), $theSubject, $theHtml, '', '', false, false, 0, $id_smtp );
			}

			if ($result['ok']==1) {

				echo '<div class="updated"><p>' . __('The single e-mail has been sent to:','knews') . ' ' . $Knews_plugin->post_safe('email') . '.</p></div>';

			} else {

				echo '<div class="error"><p><strong>' . __('Error','knews') . ': </strong> ' . __("I can't submit an e-mail to:",'knews') . ' ' . $Knews_plugin->post_safe('email') . '.</p></div>';
			}
			
		} else if ($_POST['action']=='submit_batch') {

			// Enviament per CRON			
			$query = "SELECT * FROM " . KNEWS_LISTS . " ORDER BY orderlist";
			$lists = $wpdb->get_results( $query );

			$query = "SELECT DISTINCT(" . KNEWS_USERS . ".id) FROM " . KNEWS_USERS . ", " . KNEWS_USERS_PER_LISTS . " WHERE " . KNEWS_USERS . ".id=" . KNEWS_USERS_PER_LISTS . ".id_user AND " . KNEWS_USERS . ".state='2'";
			
			$args_cats_sql='';
			
			foreach ($lists as $list) {
				if (isset($_POST['list_'.$list->id])) {
					if ($_POST['list_'.$list->id]=='1') {
						
						if ($args_cats_sql == '') {
							$args_cats_sql = ' AND (';
						} else {
							$args_cats_sql .= ' OR ';
						}	
						$args_cats_sql .= KNEWS_USERS_PER_LISTS . ".id_list=" . $list->id;
					}
				}
			}
			
			if ($args_cats_sql != '') {
				$query .= $args_cats_sql . ')';

				$batch_opts = array (
					'minute' => $Knews_plugin->post_safe('minute', 0, 'int'),
					'hour' => $Knews_plugin->post_safe('hour', 0, 'int'),
					'day' => $Knews_plugin->post_safe('day', 0, 'int'),
					'month' => $Knews_plugin->post_safe('month', 0, 'int'),
					'year' => $Knews_plugin->post_safe('year', 0, 'int'),
					'paused' => $Knews_plugin->post_safe('paused'),
					'priority' => $Knews_plugin->post_safe('priority'),
					'strict_control' => $Knews_plugin->post_safe('strict_control'),
					'emails_at_once' => $Knews_plugin->post_safe('emails_at_once'),
					'id_smtp' => $Knews_plugin->post_safe('knews_select_smtp',1)
				);

				require( KNEWS_DIR . "/includes/submit_batch.php");

			} else {

				echo '<div class="error"><p>' . __('Select one or more lists','knews') . '</p></div>';
			}
			// Fi Enviament per CRON			
		}
	} 

	$query = "SELECT * FROM ".KNEWS_NEWSLETTERS." WHERE id=" . $id_newsletter;
	$results_news = $wpdb->get_results( $query );
	if (count($results_news) == 0) {
?>

	<div class=wrap>
			<div class="icon32" style="background:url(<?php echo KNEWS_URL; ?>/images/icon32.png) no-repeat 0 0;"><br></div><h2><?php _e('Newsletters','knews'); ?></h2>
			<h3><?php echo __('Error','knews') . ': ' . __("The newsletter doesn't exists",'knews'); ?></h3>
	</div>
<?php
	} else {
?>		
	<div class=wrap>
		<?php
		if ($results_news[0]->subject=='' && !isset($_POST['action'])) {
			echo '<div class="error"><p>'; 
			printf(__('Warning: the email has no subject! %s Edit it again before submit!','knews'),'<a href="admin.php?page=knews_news&section=edit&idnews=' . $id_newsletter . '">'); 
			echo '</a></p></div>';
		}
		
		/*if ($knewsOptions['from_name_knews']=='Knews robot' && !isset($_POST['action'])) {
			echo '<div class="error"><p>'; 
			printf(__('Warning: %sConfigure sender name before submit!','knews'),'<a href="admin.php?page=knews_config">'); 
			echo '</a></p></div>';
		}*/
		?>
		<div class="icon32" style="background:url(<?php echo KNEWS_URL; ?>/images/icon32.png) no-repeat 0 0;"><br></div><h2><?php _e('Sending newsletter','knews'); ?>: <?php echo $results_news[0]->name; ?></h2>
		<p><?php _e('Send the newsletter to the following lists','knews'); ?>:</p>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<input type="hidden" name="action" id="action" value="submit_batch" />
		<input type="hidden" name="idnews" id="idnews" value="<?php echo $id_newsletter; ?>" />
		<?php
		knews_print_mailinglists();

		/*if (count($lists_name) > 1) {
			?>
			<p style="margin:0; padding:0;"><a href="#" onclick="jQuery('input.checklist').attr('checked', true)"><?php _e('Check all mailing lists','knews'); ?></a> | 
			<a href="#" onclick="jQuery('input.checklist').attr('checked', false)"><?php _e('Uncheck all mailing lists','knews'); ?></a></p>
			<?php
		}*/
		
		$cron=true;
		if ($knewsOptions['knews_cron']=='cronjob') {
			$last_cron_time = $Knews_plugin->get_last_cron_time();
			$now_time = time();
			if ($now_time - $last_cron_time > 800) $cron=false;
		}
		if ($knewsOptions['knews_cron']=='cronjs') $cron=false;

		if ($submit_enqueued && !$cron) {
			echo '<h2><a href="' . $Knews_plugin->get_main_admin_url() . 'admin-ajax.php?action=knewsCronDo&js=1" target="_blank">' . __('Now you must click here, then a window that emulates CRON with JavaScript will open. You should leave it open till sending ends.','knews') . '</a></h2>';
		}
		/*if (ini_get('safe_mode') && !$cron) {
	?>
		<div class="error">
			<p><strong><?php _e('WARNING','knews'); ?>!</strong></p>
			<p><?php _e("CRON not working and you have the PHP directive 'safe_mode' on, the bulk fail (approximately after 10 recipients)",'knews'); ?></p>
		</div>
	<?php
		} else {*/
			
		if (($knewsOptions['smtp_knews']=='cronjob' && !$cron) || $knewsOptions['smtp_knews']=='cronjs') {
			echo '<div class="updated">';
			//if (!$cron) echo '<p>' . __('CRON is not working. Depending on the number of subscribers can take some time to post.','knews') . '</p>
			echo '<p>' . __('You cannot schedule a delayed delivery. You must leave an auxiliary window open (JavaScript CRON Emulation) until the sending ends','knews') . '</p>';
			if ($knewsOptions['smtp_knews']!='1') echo '<p>' . __('Sending SMTP is not enabled, the shipments are less reliable.','knews') . '</p>';
			echo '</div>';
		}

		if ($selector = $Knews_plugin->get_smtp_selector()) {
			echo '<p>Use the SMTP: ' . $selector . '</p>';
		}

		if ($cron) {
		?>
		<p><?php _e('Start (now or deferred)?','knews'); ?> <?php _e('Time','knews');?>: <input type="text" name="hour" value="<?php echo date( 'H', current_time('timestamp')); ?>" style="width:30px;" />:<input type="text" name="minute" value="<?php echo date( 'i', current_time('timestamp')); ?>" style="width:30px;" /> |  <?php _e('Date (day/month/year)','knews');?>: <input type="text" name="day" value="<?php echo date( 'd', current_time('timestamp')); ?>" style="width:30px;" />/<input type="text" name="month" value="<?php echo date( 'm', current_time('timestamp')); ?>" style="width:30px;" />/<input type="text" name="year" value="<?php echo date( 'Y', current_time('timestamp')); ?>" style="width:50px;" /></p>
		<p><?php _e('Paused?','knews');?>? <select name="paused"><option value="0" selected="selected"><?php _e('No','knews');?></option><option value="1"><?php _e('Yes','knews');?></option></select> | <?php _e('Priority','knews');?>: <select name="priority"><option value="1">1 <?php _e('(lowest)','knews');?></option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5" selected="selected">5 <?php _e('(normal)','knews');?></option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10 <?php _e('(highest)','knews');?></option></select></p> 
		<?php
		} else {
		?>
		<input type="hidden" name="hour" value="<?php echo date( 'H', current_time('timestamp')); ?>" /><input type="hidden" name="minute" value="<?php echo date( 'i', current_time('timestamp')); ?>" /><input type="hidden" name="day" value="<?php echo date( 'd', current_time('timestamp')); ?>" /><input type="hidden" name="month" value="<?php echo date( 'm', current_time('timestamp')); ?>" /><input type="hidden" name="year" value="<?php echo date( 'Y', current_time('timestamp')); ?>" />
		<input type="hidden" name="paused" value="0" /><input type="hidden" name="priority" value="5"  />
		<?php
		}
		echo '<p>';
 _e('E-mails sent at once','knews');?>: <select name="emails_at_once"><option value="2">2 <?php _e('test mode','knews');?></option><option value="10">10</option><option value="25">25</option><option value="50" <?php if (!defined('KNEWS_CUSTOM_SPEED')) echo 'selected="selected"'; ?>>50 <?php _e('(normal)','knews');?></option><option value="100">100</option><option value="250">250 (high performance SMTP)</option><option value="500">500 (high performance SMTP)</option>
<?php if (defined('KNEWS_CUSTOM_SPEED')) echo '<option value="' . KNEWS_CUSTOM_SPEED . '">' . KNEWS_CUSTOM_SPEED . '</option>'; ?>
</select> <span class="at_once_preview"><?php if (defined('KNEWS_CUSTOM_SPEED')) echo KNEWS_CUSTOM_SPEED; else echo '300'; ?></span> per hour.</p><?php
	/*
	?>
	<p><?php _e('E-mail for close supervision','knews'); ?>: <input type="text" name="strict_control" /></p>
	*/
?>
	<table style="width:480px" class="widefat">
	<thead><tr><th class="manage-column column-cb check-column"></th><th>A quick status check before submit:</th></tr></thead>
	<tbody>

		<?php 
		if ($knewsOptions['smtp_knews'] == 0) {

			if ($knewsOptions['from_name_knews']=='Knews robot') {

				echo '<tr class="alt"><td><img src="' . KNEWS_URL . '/images/red_led.gif" width="20" height="20" alt="" /></td><td>';
				echo sprintf(__('Warning: %sConfigure sender name before submit!','knews'),'<a href="admin.php?page=knews_config">') . '</a></td></tr>';

			} else {
				echo '<tr class="alt"><td><img src="' . KNEWS_URL . '/images/yellow_led.gif" width="20" height="20" alt="" /></td><td>';
				echo sprintf(__('%sSMTP is not configured. Email will be sent through wp_mail()','knews'),'<a href="admin.php?page=knews_config&tab=advanced&subtab=2">') . '</a></td></tr>';
			}
		} else {
			echo '<tr class="alt"><td><img src="' . KNEWS_URL . '/images/green_led.gif" width="20" height="20" alt="" /></td><td>';
			echo __('Email will be sent using SMTP','knews') . '</td></tr>';
		}
		
		if ($knewsOptions['knews_cron'] == 'cronjob') {
			$last_cron_time=$Knews_plugin->get_last_cron_time();
			$now_time = time();
			if ($now_time - $last_cron_time < 800) {

				echo '<tr><td><img src="' . KNEWS_URL . '/images/green_led.gif" width="20" height="20" alt="" /></td><td>';
				echo __('CRON is properly configured','knews') . '</td></tr>';

			} else {
				echo '<tr><td><img src="' . KNEWS_URL . '/images/red_led.gif" width="20" height="20" alt="" /></td><td>';
	
				if ($last_cron_time == 0) {
					echo '<a href="admin.php?page=knews_config&tab=advanced">' . __('CRON has not yet been configured','knews') . '</a></td></tr>';
				} else {
					echo '<a href="admin.php?page=knews_config&tab=advanced">' . __('CRON has stopped working.','knews') . '</a></td></tr>';
				}
			}
		} else {
			echo '<tr><td><img src="' . KNEWS_URL . '/images/yellow_led.gif" width="20" height="20" alt="" /></td><td>';
			echo sprintf(__('%sCRON is not configured it will speed up submissions in background','knews'),'<a href="admin.php?page=knews_config&tab=advanced">') . '</a></td></tr>';
		}

		if ($knewsOptions['pixel_tracking'] == 1) {

			$wp_dirs = wp_upload_dir();
			echo '<tr class="alt"><td><span style="background:url(' . KNEWS_URL . '/images/red_led.gif); display:block; width:20px; height:20px;"><span style="background:url(' . $wp_dirs['baseurl'] . '/knewsimages/testled.gif); display:block; width:20px; height:20px;"></span></span></td><td>';
			echo '<a href="admin.php?page=knews_config&tab=advanced&subtab=3">' . __('Tracking pixel','knews') . '</a></td></tr>';
		
		} else {
			echo '<tr class="alt"><td><img src="' . KNEWS_URL . '/images/yellow_led.gif" width="20" height="20" alt="" /></td><td>';
			echo '<a href="admin.php?page=knews_config&tab=advanced&subtab=3">' . __('Please, configure the tracking pixel, it will give you accurate stats.','knews') . '</a></td></tr>';
			
		}
		
		global $email_blacklist; $this->load_blacklist(true);

		if ($knewsOptions['blacklist_scan']==0) {

			echo '<tr><td><img src="' . KNEWS_URL . '/images/red_led.gif" width="20" height="20" alt="" /></td><td>';
			echo '<a href="admin.php?page=knews_users#blacklists">' . __('Please, scan mailing lists with the new blacklist domains.','knews') . '</a></td></tr>';

		} elseif ($knewsOptions['blacklist_scan']!=count($email_blacklist)) {

			echo '<tr><td><img src="' . KNEWS_URL . '/images/yellow_led.gif" width="20" height="20" alt="" /></td><td>';
			echo '<a href="admin.php?page=knews_users#blacklists">' . __('Please, scan mailing lists with the new blacklist domains.','knews') . '</a></td></tr>';
			
		} else {

			echo '<tr><td><img src="' . KNEWS_URL . '/images/green_led.gif" width="20" height="20" alt="" /></td><td>';
			echo __('Mailing lists cleaned from blacklists.','knews') . '</td></tr>';
			
		}
		
		if (!$Knews_plugin->im_pro()) {

			echo '<tr class="alt"><td><img src="' . KNEWS_URL . '/images/gray_led.gif" width="20" height="20" alt="" /></td><td>';
			echo '<a href="admin.php?page=knews_config&tab=pro">' . __('Only Knews Pro has a built-in email bounce detection','knews') . '</a></td></tr>';
			
		} elseif ($knewsOptions['bounce_on'] == 1) {

			echo '<tr><td><img src="' . KNEWS_URL . '/images/green_led.gif" width="20" height="20" alt="" /></td><td>';
			echo __('Bounce detection activated','knews') . '</td></tr>';
		
		} else {
			echo '<tr><td><img src="' . KNEWS_URL . '/images/yellow_led.gif" width="20" height="20" alt="" /></td><td>';
			echo '<a href="admin.php?page=knews_config&tab=pro&subtab=2">' . __('Bounce detection deactivated','knews') . '</a></td></tr>';
			
		}

		?>
	</tbody></table>

	<div class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Schedule submit','knews'); ?>">
	</div>
	<?php 
	//Security for CSRF attacks
	wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
	?>
	</form>
	<hr />
	<h2><?php _e('Send the newsletter manually','knews');?>:</h2>
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="action" id="action" value="submit_manual" />
	<input type="hidden" name="idnews" id="idnews" value="<?php echo $id_newsletter; ?>" />
	<p>E-mail: <input type="text" name="email" class="regular-text" /></p>
	<?php
		if ($selector = $Knews_plugin->get_smtp_selector()) {
			echo '<p>Use the SMTP: ' . $selector . '</p>';
		}
	?>
	<div class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Submit newsletter','knews'); ?>"/>
	</div>
	<?php 
	//Security for CSRF attacks
	wp_nonce_field($knews_nonce_action, $knews_nonce_name); 
	?>
	</form>
</div>
<?php
	}
?>
	
	<script type="text/javascript" src="<?php echo KNEWS_URL; ?>/admin/scripts.js"></script>
