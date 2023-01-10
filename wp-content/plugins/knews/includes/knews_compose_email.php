<?php

if ($Knews_plugin) {
	if (! $Knews_plugin->initialized) $Knews_plugin->init();

	require_once( KNEWS_DIR . '/includes/knews_util.php');

	global $wpdb;
		
	$query = "SELECT * FROM ".KNEWS_NEWSLETTERS." WHERE id=" . $id_newsletter;
	$results = $wpdb->get_results( $query );

	$theSubject = $results[0]->subject;
	$theHtml = $results[0]->html_head . '<body>' . $results[0]->html_mailing;

	if (isset($knewsOptions['pixel_tracking']) && $knewsOptions['pixel_tracking']!=1) $theHtml .= '<img src="' . KNEWS_URL . '/images/unpix.gif" width="1" height="1" alt="" />';

	$theHtml .= '</body></html>';

	$title = knews_cut_code('<title>', '</title>', $theHtml, false);
	$theHtml = str_replace($title, '<title>' . $theSubject . ' - ' . get_bloginfo('title') . '</title>', $theHtml);
	
	//Remove some shit from WYSIWYG editor
	$theHtml = str_replace( $results[0]->html_container, '', $theHtml);

	$theHtml = str_replace( '<span class="handler"></span>', '', $theHtml);
	$theHtml = str_replace( '<!--[start module]-->', '', $theHtml);
	$theHtml = str_replace( '<!--[end module]-->', '', $theHtml);
	$theHtml = knews_iterative_extract_code('<!--[start option', ']-->', $theHtml, true);
	$theHtml = knews_iterative_extract_code('<!--[end option', ']-->', $theHtml, true);

	$theHtml = str_replace( "\r\n\r\n", "\r\n", $theHtml);
	$theHtml = preg_replace('/(?:(?:\r\n|\r|\n)\s*){2}/s', "\n\n", $theHtml);
	
	$cut_lines=explode("\n",$theHtml);
	$theHtml='';
	foreach ($cut_lines as $cl) {
		if (strlen($cl) > 250) {
			//echo 'tallarem: ' . htmlentities($cl) . '<br>';
			while (strlen($cl) > 250) {
				$seek=strpos($cl,' ',200);
				if ($seek !== false) {
					$theHtml .= substr($cl, 0, $seek) . "\n";
					$cl=substr($cl,$seek);
				} else {
					//echo 'no puc tallar';
					$theHtml .= $cl . "\n";
					$cl='';
				}
			}
		}
		$theHtml .= $cl . "\n";
	}
	
	$used_tokens = array();
	
	$all_tokens = $Knews_plugin->get_extra_fields();

	$c = count($all_tokens); $all_tokens[$c] = new stdClass; 
	$all_tokens[$c]->token = '%email%'; $all_tokens[$c]->id = 0;
	
	foreach ($all_tokens as $token) {
		if ($token->token != '') {
			
			preg_match("#\{" . $token->token . "\[([^\]]*)\]\}#", $theSubject . $theHtml, $tokenfound);
			
			if( count($tokenfound) != 0) {
				$used_tokens[] = array('token'=>$token->token, 'id'=>$token->id, 'defaultval'=>$tokenfound[1]);
				$theHtml = str_replace($tokenfound[0], $token->token, $theHtml);
				$theSubject = str_replace($tokenfound[0], $token->token, $theSubject);
			}
		}
	}
	
	if ($results[0]->mobile==0 && $results[0]->id_mobile==0) {
		$theHtml = knews_iterative_extract_code('<!--mobile_block_start-->', '<!--mobile_block_end-->', $theHtml, true);
	}
}
?>