<?php

global $Knews_plugin, $knewsOptions;

if ($Knews_plugin) {

	if (! $Knews_plugin->initialized) $Knews_plugin->init();

	add_filter( 'excerpt_length', 'knews_excerpt_length', 999 );

	require_once( KNEWS_DIR . '/includes/knews_util.php');

	$ajaxid = $Knews_plugin->get_safe('ajaxid', 0, 'int');
	$type = $Knews_plugin->get_safe('type', 'post');
	$ajaxlang = $Knews_plugin->get_safe('lang', 'en');

	function get_post_knews ($reply, $id, $type, $lang) {
		
		if (is_array($reply) && isset($reply['skip'])) return $reply;
		
		global $post, $Knews_plugin, $knewsOptions;
		
		$post = get_post($id);
		
		$permalink = get_permalink();

		if (KNEWS_MULTILANGUAGE && $knewsOptions['multilanguage_knews']=='qt' && function_exists('qtrans_convertURL')) {
			$post = qtrans_use($lang, $post, false);
			$permalink = qtrans_convertURL($permalink, $lang, true);
		}
		
		setup_postdata($post);


		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt = (string) get_the_excerpt();
		$content = (string) get_the_content();

		if ($knewsOptions['apply_filters_on']=='1') $content = apply_filters('the_content', $content);

		$content = strip_shortcodes($content);
		$content = knews_iterative_extract_code('<script', '</script>', $content, true);
		$content = knews_iterative_extract_code('<fb:like', '</fb:like>', $content, true);
		$content = str_replace(']]>', ']]>', $content);
			$content = strip_tags($content, $knewsOptions['allowed_content_tags']);

			if ($excerpt=='') $excerpt = strip_tags($content);

		$words = explode(' ', $content, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			//array_push($words, '[...]');
			$excerpt = implode(' ', $words) . '...';
		}
			//$content = nl2br($content);

		$words = explode(' ', $excerpt, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			//array_push($words, '[...]');
			$excerpt = implode(' ', $words) . '...';
		}
		$featimg = '';
		if ($Knews_plugin->im_pro()) {
			if (has_post_thumbnail( $post->ID ) ) {
				$featimg = knews_get_image_path();
			}
		}

		return array('title' => get_the_title(), 'excerpt' => $excerpt, 'content' => $content, 'permalink' => $permalink, 'image' => $featimg);

	}

	if ($ajaxid != 0) {

		$jsondata = apply_filters('knews_get_post', array(), $ajaxid, $type, $ajaxlang);
 		echo json_encode($jsondata);
		
	} else {
		
		$languages=$Knews_plugin->getLangs();
		$lang = $Knews_plugin->get_safe('lang');
		$s = $Knews_plugin->get_safe('s');
		$type = $Knews_plugin->get_safe('type','post');
		$cat = $Knews_plugin->get_safe('cat', 0, 'int');
		$orderbt = $Knews_plugin->get_safe('orderby');
		$order = $Knews_plugin->get_safe('order', 'asc');
		$paged = $Knews_plugin->get_safe('paged', 1, 'int');
		
		//$url_base =  KNEWS_URL . '/direct/select_post.php';
		$url_base =  get_admin_url() . 'admin-ajax.php';

		if (KNEWS_MULTILANGUAGE && $lang != '' && $knewsOptions['multilanguage_knews']=='wpml') {
			global $sitepress;
			$class_methods = get_class_methods($sitepress);
			if (in_array('switch_lang', $class_methods)) {
				$sitepress->switch_lang($lang);
			} else {
				echo "<p><strong>Please, upgrade WPML</strong></p>";
			}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Select Post</title>
<style type="text/css">
	html,body{ width:100%; height:100%;}
	body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, fieldset, input, textarea, p, blockquote, th, td, input, hr { 
		margin:0px; 
		padding:0px; 
		border:none;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		line-height:100%;
	}
	a {
		text-decoration:none;
		color:#000;
	}
	a:hover {
		color:#d54e21;
	}
	div.content {
		padding:10px 20px 0 20px;
	}
	div.pestanyes {
		background:#fff;
		padding-left:15px;
		display:block;
		height:25px;
	}
	div.pestanyes a {
		border-top-left-radius:3px;
		border-top-right-radius:3px;
		color:#aaa;
		display:inline-block;
		height:20px;
		padding:4px 14px 0 14px;
		border:#dfdfdf 1px solid;
		text-decoration:none;
		margin-left:5px;
		font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
		font-size:14px;
	}
	div.pestanyes a:hover {
		color:#d54e21;
	}
	div.pestanyes a.on {
		color:#000;
		background:#f9f9f9;
		cursor:default;
		border-bottom:#f9f9f9 1px solid;
	}

	p.langs_selector a {
		color:#21759B;
	}
	p.langs_selector a:hover {
		color:#d54e21;
	}
	p {
		padding-bottom:10px;
	}
	div.tablenav,
	div.filters {
		border-top:#dfdfdf 1px solid;
		border-bottom:#dfdfdf 1px solid;
		padding:10px 10px 0 10px;
		height:30px;
		background:#f9f9f9;
		background-image:-moz-linear-gradient(center top , #F9F9F9, #ECECEC);
		margin-bottom:20px;
	}
	input.button {
		border:#888 1px solid;
		background:#fff;
		border-radius:11px;
		cursor:pointer;
		padding:3px 11px;
	}
	input.button:hover {
		border-color:#000;
	}
	input.texte {
		padding:3px;
		border:#DFDFDF 1px solid;
		border-radius:3px;
		margin-right:5px;
	}
	div.left_side {
		width:290px;
		position:absolute;
	}
	div.right_side {
		float:right;
	}
	select {
		border:#DFDFDF 1px solid;
		padding:1px;
	}
	div.tablenav-pages {
		text-align:right;
	}
	div.bottom {
		height:auto;
		margin-top:10px;
	}
</style>

<script type="text/javascript">
function select_post(n, lang, type) {
	parent.CallBackPost(n, lang, type);
}
</script>
</head>

<body>
<div class="content">
	<p><strong><?php _e('Select the post to insert in the newsletter','knews'); ?>:</strong></p>
	<?php
		foreach ($languages as $l) {
			if ($l['active']==1 && $lang=='') $lang = $l['language_code'];
		}
		
		//Languages
		if (count($languages) > 1) {
			echo '<p class="langs_selector">';
			$first=true;
			foreach ($languages as $l) {
				if (!$first) echo ' | ';
				$first=false;
				if ($lang==$l['language_code']) echo '<strong>';
				echo '<a href="' . $url_base . '?action=knewsSelPost&lang=' . $l['language_code'] . '&type=' . $type  . '&paged=' . $paged . '">' . $l['native_name'] . '</a>';
				if ($lang==$l['language_code']) echo '</strong>';
			}
			echo '</p>';
		}
		//$url_base .= '&lang=' . $lang;
		
		//Posts / Pages
		echo '<div class="pestanyes">';
		echo (($type=='post') ? '<a class="on"' : '<a') . ' href="' . $url_base . '?action=knewsSelPost&type=post&lang=' . $lang . '">' . __('Posts','knews') . '</a>';
		echo (($type=='page') ? '<a class="on"' : '<a') . ' href="' . $url_base . '?action=knewsSelPost&type=page&lang=' . $lang . '">' . __('Pages','knews') . '</a>';
		echo '</div>';
		
		echo '<div class="filters">';
		//Filters
		if ($type=='post') {
			
			//Polylang support
			if (KNEWS_MULTILANGUAGE && $knewsOptions['multilanguage_knews']=='pll') {
				$GLOBALS['hook_suffix']='knews_select_post';
				set_current_screen();
			}
			
			echo '<div class="left_side">';
			$cats = get_categories();
			if (count($cats)>1) {
				echo '<form action="' . $url_base . '" method="get">';
				echo '<input type="hidden" name="lang" value="' . $lang . '">';
				echo '<input type="hidden" name="type" value="' . $type . '">';
				echo '<input type="hidden" name="action" value="knewsSelPost">';
				echo '<select name="cat" id="cat">';
				echo '<option value="0">' . __('All categories','knews') . '</option>';
				foreach ($cats as $c) {
					echo '<option value="' . $c->cat_ID . '"' . (($c->cat_ID==$cat) ? ' selected="selected"' : '') . '>' . $c->name . '</option>';
				}
				echo '</select> <input type="submit" value="' . __('Filter','knews') . '" class="button" />';
				echo '</form>';
			}
			echo '</div>';
		}
		
		//Search
		echo '<div class="right_side">';
		echo '<form action="' . $url_base . '" method="get">';
		echo '<input type="hidden" name="lang" value="' . $lang . '">';
		echo '<input type="hidden" name="type" value="' . $type . '">';
		echo '<input type="hidden" name="action" value="knewsSelPost">';
		echo '<input type="text" name="s" value="" class="texte">';
		echo '<input type="submit" value="' . __('Search','knews') . '" class="button" />';
		echo '</form>';
		echo '</div>';
		
		echo '</div>';
		/*function new_excerpt_more($more) {
			return '[...]';
		}
		add_filter('excerpt_more', 'new_excerpt_more');*/
	
		$myposts = apply_filters ('knews_posts_preview', array(), $lang, $type, $cat, $s, $paged, 'publish', 10);
	
		foreach($myposts as $p) {
			if (is_array($p) && isset($p['ID'])) {
				echo '<p><a href="#" onclick="select_post(' . $p['ID'] . ',\'' . $p['lang'] . '\',\'' . $type . '\')"><strong>' . $p['title'] . '</strong></a><br>' . $p['excerpt'] . '</p>';
			}
		}
		
		//global $wp_query; 
		if (isset($myposts['found_posts'])) {
	echo '<div class="tablenav bottom">';
			knews_pagination($paged, ceil($myposts['found_posts']/ 10), $myposts['found_posts'], $url_base . '?action=knewsSelPost&lang=' . $lang . '&type=' . $type  . '&cat=' . $cat . '&orderbt=' . $orderbt . '&order=' . $order);
	echo '</div>';
		}
	?>
	</div>
</body>
</html>
<?php 
	}
}
die();
?>
