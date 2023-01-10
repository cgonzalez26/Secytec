<?php
global $Knews_plugin;

$popup_styles ='<style type="text/css">
		#knews_dialog { display:block !important; }
		#knews_dialog p { margin:0; padding:0 0 20px 0;}
		#knews_dialog_bg { left:50%; top:50%; margin-left:-250px; margin-top:-100px; width:458px; height:188px; padding:30px 20px 0 20px; border:#eee 1px solid; background:#fff; color:#000; font-family:Verdana, Geneva, sans-serif; font-size:12px; line-height:15px; text-align:center; position:absolute; box-shadow: 0 0 15px 5px #000000; border-radius:10px;}
		#knews_dialog_button { display:inline-block; background:#666; color:#fff; font-weight:bold; padding:6px 20px; text-decoration:none; border-radius:5px; }
		#knews_dialog_button:hover { background:#000; box-shadow: 0 0 5px #666; }
		
		a.knews_pop_x {
			position:absolute;
			top:10px;
			z-index:10000;
			display:none;
			color:#fff;
			left:50%;
			background:url("' . KNEWS_URL . '/images/cs-x-close.png") repeat 0 0;
			width:38px;
			height:41px;
			text-decoration:none;
			margin-left:350px;
		}
		div.knews_pop_bg {
			position:fixed;
			top:0; left:0; bottom:0; right:0;
			background:url("' . KNEWS_URL . '/images/bg_dialog.png") repeat 0 0;
			z-index:1000;
			display:none;
		}
		div.knews_pop_news,
		iframe.knews_pop_news {
			position:absolute;
			z-index:10000;
			top:25px;
			left:50%;
			width:730px;
			margin-left:-365px;
			background:#fff;
		    box-shadow: 0 0 15px 5px #000000;
		}
		iframe.knews_pop_news {
			opacity:0.01;filter:alpha(opacity=1);
		}
		iframe.knews_base_home {
			width:100%;
			height:100%;
			position:absolute;
			overflow:hidden;
			left:0;
			top:0;
			
		}
	</style>';

if (defined('KNEWS_POP_DIALOG')) {

$popup_scripts = '<script type="text/javascript">
	function knews_deleteLayer(id) {
		jQuery("div.knews_pop_bg").fadeOut("slow", function() {
			jQuery("div.knews_pop_bg").remove();
		});
	}
	</script>';

	$popup_code = '';
	$popup_text = '<div id="knews_dialog" class="knews_pop_bg"><div id="knews_dialog_bg">';

			$lang_locale = $Knews_plugin->localize_lang($Knews_plugin->getLangs(true), $Knews_plugin->get_safe('lang', substr(get_bloginfo('language'), 0, 2)), get_bloginfo('language'));

			if ($Knews_plugin->get_safe('subscription')=='ok' || ( $Knews_plugin->get_safe('knews')=='confirmUser' && $knews_subscription_result ) ) {
				$popup_code='subscriptionOK';
				$popup_text .= '<p style="font-size:14px;"><strong>' . $Knews_plugin->get_custom_text('subscription_ok_title', $lang_locale) . '</strong></p>';
				$popup_text .= '<p>' . $Knews_plugin->get_custom_text('subscription_ok_message', $lang_locale) . '</p>';
				$popup_text .= '<p><a href="#" id="knews_dialog_button" onclick="knews_deleteLayer(\'knews_dialog\')">' . $Knews_plugin->get_custom_text('dialogs_close_button', $lang_locale) . '</a></p>';

			} else if ($Knews_plugin->get_safe('subscription')=='error' || ( $Knews_plugin->get_safe('knews')=='confirmUser' && !$knews_subscription_result )) {

				$popup_code='subscriptionERROR';
				$popup_text .= '<p style="font-size:14px;"><strong>' . $Knews_plugin->get_custom_text('subscription_error_title', $lang_locale) . '</strong></p>';
				$popup_text .= '<p>' . $Knews_plugin->get_custom_text('subscription_error_message', $lang_locale) . '</p>';
				$popup_text .= '<p><a href="#" id="knews_dialog_button" onclick="knews_deleteLayer(\'knews_dialog\')">' . $Knews_plugin->get_custom_text('dialogs_close_button', $lang_locale) . '</a></p>';

			} else if ($Knews_plugin->get_safe('unsubscribe')=='ok' || ( $Knews_plugin->get_safe('knews')=='unsubscribe' && $knews_block_result )) {

				$popup_code='unsubscribeOK';
				$popup_text .= '<p style="font-size:14px;"><strong>' . $Knews_plugin->get_custom_text('subscription_stop_ok_title', $lang_locale) . '</strong></p>';
				$popup_text .= '<p>' . $Knews_plugin->get_custom_text('subscription_stop_ok_message', $lang_locale) . '</p>';
				$popup_text .= '<p><a href="#" id="knews_dialog_button" onclick="knews_deleteLayer(\'knews_dialog\')">' . $Knews_plugin->get_custom_text('dialogs_close_button', $lang_locale) . '</a></p>';

			} else if ($Knews_plugin->get_safe('unsubscribe')=='error' || ( $Knews_plugin->get_safe('knews')=='unsubscribe' && !$knews_block_result )) {

				$popup_code='unsubscribeERROR';
				$popup_text .= '<p style="font-size:14px;"><strong>' . $Knews_plugin->get_custom_text('subscription_stop_error_title', $lang_locale) . '</strong></p>';
				$popup_text .= '<p>' . $Knews_plugin->get_custom_text('subscription_stop_error_message', $lang_locale) . '</p>';
				$popup_text .= '<p><a href="#" id="knews_dialog_button" onclick="knews_deleteLayer(\'knews_dialog\')">' . $Knews_plugin->get_custom_text('dialogs_close_button', $lang_locale) . '</a></p>';
			}
	$popup_text .= '</div></div>';

	do_action('knews_echo_dialog', $popup_code, $popup_scripts, $popup_styles, $popup_text, $lang_locale);
}

if (defined('KNEWS_POP_HOME')) {

	echo $popup_styles;
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			max_width=0;
			jQuery('div.knews_pop_news *', window.parent.document).each(function() {
				m=parseInt(jQuery(this).attr('width'), 10);
				if (m > max_width) max_width=m;
			});
			max_width=max_width+20;
			jQuery("div.knews_pop_news", window.parent.document).css("width", max_width).css("marginLeft", -1 * Math.floor(max_width/2));
			jQuery("a.knews_pop_x", window.parent.document).css("marginLeft", Math.floor(max_width/2)-15);

			jQuery(window.parent.document).keyup(function(e) {
				if (e.keyCode == 27) { close_popup() }
			});
			jQuery('div.knews_pop_bg', window.parent.document).click(function() {
				close_popup();
			});
			function close_popup() {
				window.parent.document.location.href='<?php echo get_bloginfo('url'); ?>';
			}
		});
	</script>
<?php
}

if (defined('KNEWS_POP_NEWS')) {

	echo $popup_styles;
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("a.knews_lightbox").click(function() {
				knews_launch_iframe(jQuery(this).attr("href"));
				return false;
			});
		});
		
		function knews_launch_iframe(iframe_url) {
				
			jQuery("body").append('<div class="knews_pop_bg">&nbsp;</div><iframe class="knews_pop_news" src="' + iframe_url + '&knewsLb=1"></iframe><a href="#" class="knews_pop_x" title="close">&nbsp;</a>');
			jQuery("div.knews_pop_bg").fadeIn();
			jQuery("iframe.knews_pop_news").load(function (){
				y = this.contentWindow.document.body.offsetHeight;
				if (y==0) {
					jQuery("iframe.knews_pop_news").css('display','block');
					y = this.contentWindow.document.body.offsetHeight;
				}
				//x = this.contentWindow.document.body.offsetWidth + 20;
				max_width=0;
				parent.jQuery('body', this.contentWindow.document).css('padding','0').css('margin','0');
				parent.jQuery('*', this.contentWindow.document).each(function() {
					m=parseInt(jQuery(this).attr('width'), 10);
					if (m > max_width) max_width=m;
				});
				max_width=max_width+20;
				parent.jQuery("iframe.knews_pop_news").animate({opacity:1}).css({height: y, width: max_width, marginLeft: -1 * Math.floor(max_width/2), display:'block', border:0});
				parent.jQuery("a.knews_pop_x").css("marginLeft", Math.floor(max_width/2)-15).css("display","block");
				parent.jQuery("a.knews_pop_x, div.knews_pop_bg").click(function() {close_popup()});
				parent.jQuery("a", this.contentWindow.document).each(function() {parent.jQuery(this).attr("target","_parent")});
				parent.jQuery(this.contentWindow.document).keyup(function(e) {
					if (e.keyCode == 27) { close_popup() }
				});
			});
			function knewsLookForEsc(e) {
				if (e.keyCode == 27) close_popup();
			}
			jQuery(document).keyup(knewsLookForEsc);
			function close_popup() {
				jQuery("a.knews_pop_x, iframe.knews_pop_news").remove();
				jQuery("div.knews_pop_bg").fadeOut("slow", function() {
					jQuery("div.knews_pop_bg").remove();
					jQuery(document).unbind("keyup", knewsLookForEsc);
				});
			}
		}
	</script>
<?php
}
?>