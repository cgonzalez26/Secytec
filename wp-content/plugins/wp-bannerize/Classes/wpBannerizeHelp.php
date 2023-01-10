<h2><?php _e( 'How to', 'wp-bannerize' ) ?></h2>
<h3><?php _e( 'To display your banner use Widget area, PHP or Wordpress shortcode in your post and page', 'wp-bannerize' ) ?></h3>
<p><strong><?php _e( 'Usage from PHP', 'wp-bannerize' ) ?>:</strong></p>
<pre style="border:1px solid #aaa;padding:8px;background:#ccc;margin:8px">
	&lt;?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('group=left_sidebar'); ?&gt;
</pre>
<p><strong><?php _e( 'Arguments for PHP function', 'wp-bannerize' ) ?>:</strong></p>
<pre style="border:1px solid #aaa;padding:8px;background:#ccc;margin:8px">
* group               If '' show all groups, else show the selected group code (default '')
* no_html_wrap        Avoid WP Bannerize
* random              Show random banner sequence (default '')
* categories          Category ID separated by commas (defualt '')
* limit               Limit rows number (default '' - show all rows)
* before              HTML Tag before banner (default '&lt;div&gt;')
* after               HTML Tag after banner (default '&lt;/div&gt;')
</pre>
<p><strong><?php _e( 'Usage from shortcode', 'wp-bannerize' ) ?>:</strong></p>
<pre style="border:1px solid #aaa;padding:8px;background:#ccc;margin:8px">
[wp_bannerize group=left_sidebar]
</pre>
<h3 style="color:#d00"><?php _e( 'Deprecated', 'wp-bannerize' ) ?>:</h3>
<p><strong style="color:#d50"><?php _e( 'These arguments are no longer supported', 'wp-bannerize' ) ?>:</strong></p>
<pre style="background:#d60;border:1px solid #c00;padding:8px;color:#fff">
* container_before    Main tag container open (default &lt;ul&gt;)
* container_after     Main tag container close (default &lt;/ul&gt;)
* alt_class           class alternate for "before" TAG (use before param)
* link_class          Additional class for link TAG A
</pre>
<p><strong style="color:#d50"><?php _e( 'The shortcode', 'wp-bannerize' ) ?>:</strong></p>
<pre style="background:#d60;border:1px solid #c00;padding:8px;color:#fff">
[wp-bannerize group=left_sidebar]
</pre>