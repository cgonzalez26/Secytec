=== WP Bannerize ===
Contributors: gfazioli
Donate link: http://www.undolog.com
Tags: Banner, Manage, Image, ADV, Random, Adobe Flash, Impressions, Click Counter
Requires at least: 3.6
Tested up to: 3.7.1
Stable tag: 3.1.6

WP Bannerize is an easy to use adv server with html, free text and Flash banner support.

== Description ==

**NOTE**

This plugin version is no longer updated and supported! [Check the new version here](https://wpxtre.me/product/bannerize "Check the new version here")


WP Bannerize is an Amazing Banner Manager. With WP Bannerize you can manage all your advertising stuff through widgets, shortcodes or directly from your template.
In your template insert: `<?php if(function_exists( 'wp_bannerize' )) wp_bannerize(); ?>`, use new shortcode featured or set it like Widget.

**FEATURES**

* Localized for Italian, English, Spanish, Portuguese, Belorussian, Dutch, Polish, German, Turkish and Russian
* Manage image, Adobe Flash movie, HTML/Javascript and free text
* Create your list (group/key) Banners image/Adobe Flash movie/URL/Free HTML
* Drag & Drop order
* Quick switch button to enable/disable banner
* Show your banners list by PHP code, WordPress **shortcode** or Widget
* Customize output by 'Settings' in admin area
* Customize CSS Rules for frontend layout
* Tools panel with Function and Shortcode Editor
* Set random, limit and catories filters
* Standard WordPress interface improvement
* "nofollow" attribute support
* Click Counter engine for stats
* Impressions and Max Impressions
* CTR (Click-through rate)
* Date Time schedule
* WordPress Admin Contextual HELP

**WHAT'S NEWS IN 3.0 RELEASE**

* Added insert banner by URL
* Added insert banner by Free HTML
* Added insert banner from Media Gallery
* Added quick switch button to enable/disable banner
* Added Server Date/Time information
* Added click count on Flash Movie
* Added `no_html_wrap` arguments for avoid WP Bannerize HTML
* Added frontend stylesheet, predefined or custom
* Added 'no banner to display' HTML/message settings
* Added Tools menu with Function and Shortcode Editor, Database utility
* Improved HTML contextual Help
* Improved Code and HTML layout
* Improved HTML output
* Fixed shortcode
* Fixed several minor bugs
* Updated Fancybox Javascript Library
* Deprecated shortcode name "wp-bannerize"
* Deprecated HTML output - see documentation for detail

http://www.youtube.com/watch?v=sAZOyAwXu-U

**HOW TO**

Check the new "Function and Shortcode Editor" in Tools section.

When you insert a banner you can assign it to a group (or key). In this way, for example, if your theme layout is a 3 columns, you can insert in left sidebar:

`<?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('group=left_sidebar'); ?>`

in right sidebar:

`<?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('group=right_sidebar'); ?>`

In addition WP Bannerize provides a filter by category, for example:

`<?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('group=right_sidebar&categories=13,14'); ?>`

The code above shows banners only for the categories 13 or 14, for the "right_sidebar" group key.

or in your post:

`[wp_bannerize group="adv" random="1" limit="3"]`

The default HTML output for above code is:

`<div class="wp_bannerize adv">
  <div>
    <a href=".."><img src="..." /></a>
  </div>
  <div>
    <a href=".."><img src="..." /></a>
    <div class="description">[description]</div>
  </div>
  ...
</div>
`

**params:**

`
* group               If '' show all groups, else show the selected group code (default '')
* no_html_wrap        Display only link and image tag, No WP Bannerize wrap HTML (default '')
* random              Show random banner sequence (default '')
* categories          Category ID separated by commas. (default '')
* limit               Limit rows number (default '' - show all rows)
* before              HTML Tag before banner (default '<div>')
* after               HTML Tag after banner (default '</div>')
`

== Who's using WP Bannerize? ==

* [Elio e le Storie Tese](http://www.elioelestorietese.it "Elio e le Storie Tese")
* [Artribune](http://www.artribune.com/ "Artribune")
* [Undolog](http://www.undolog.com "Undolog")
* [wpXtreme](https://wpxtre.me "wpXtreme")

Aren't you in this list? Please, [let me know your WordPress site url](mailto:g.fazioli@wpxtre.me "let me know your WordPress site url")

== Related Links ==

* [wpXtreme](https://wpxtre.me "More WordPress Plugin")
* [Undolog](http://www.undolog.com/ "Author's Web")
* [Tutorial Video](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

For more information on the roadmap and the next improvements, please send an e-mail to: [support@wpxtre.me](mailto:support@wpxtre.me "support@wpxtre.me")


== Screenshots == 

1. New list banners with switch to enable/disable banner
2. New Edit inline with server date informations
3. New add banner form; from local, from url or free HTML text
4. New panel settings with default css rules
5. PHP and Shortcode Editor, Database utility
6. Contextual Help
7. Widget support

* [Tutorial Video](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

== Changelog ==


= 3.1.6 =

* Removed FancyBox javascript library

= 3.1.5 =

* Fixed impressions, thankk to Mathijs Huis <mathijs@impres.nl>

= 3.1.4 =

* Fixed media library selection

= 3.1.3 =

* Fixed "Trash", "Delete" and "Restore" Javascript hook

= 3.1.2 =

* Updated FabcyBox Javascript Library
* Fixed loading css/javascript

= 3.1.1 =

* Fixed Contextual Help
* Fixed potential wrong PHP tag closed

= 3.1.0 =

* Added Notice: This plugin version is no longer updated and supported [Check the new version here](https://wpxtre.me/product/bannerize "Check the new version here")
* Fixed several bugs and updated to WordPress 3.7
* Updated localization

= 3.0.62 =
* Fixed anonymous function for php 4

= 3.0.61 =
* Introducing [wpXtreme](https://wpxtre.me "wpXtreme")
* Fixed dbDelat output on plugin activation

= 3.0.50 =
* Added Russian translation, thanks to [Mick Levin](http://wordpress.org/support/profile/mick-levin "Mick Levin")
* Fixed sql file for delta db, thanks to [esu66](http://wordpress.org/support/profile/esu66 "esu66")
* Fixed random in Widget
* Fixed "go top" when click on "edit" banner, thanks to [moikano](http://wordpress.org/support/profile/moikano "moikano")
* Fixed "FreeHTML banners lose newlines with inline-edit", thanks to [moikano](http://wordpress.org/support/profile/moikano "moikano")

= 3.0.32 =
* Changed manage_option to edit_posts
* Fixed ClickCounter on Adobe Flash Movie, thanks to [preukson](http://wordpress.org/support/profile/preukson "preukson")

= 3.0.30 =
* Fixed locale date, thanks to [moikano](http://wordpress.org/support/profile/moikano "moikano")
* Fixed IE7:first-child bugs, thanks to [moikano](http://wordpress.org/support/profile/moikano "moikano")
* Fixed minor bugs

= 3.0.24 =
* Fixed minor bug

= 3.0.23 =
* Fixed division by zero in CRT count, thanks to [jasonpel](http://wordpress.org/support/profile/jasonpel "jasonpel")

= 3.0.22 =
* Fixed category display, thanks to [SchattenMann](http://wordpress.org/support/profile/schattenmann "SchattenMann")

= 3.0.21 =
* Fixed 'no_html_wrap' in Widget output

= 3.0.20 =
* Fixed Minor notices

= 3.0.11 =
* Removed debug info

= 3.0.10 =
* Added CTR (Click-through rate) column in banner list view (Thanks to aplussideas)

= 3.0.9 =
* Fixed click counter

= 3.0.8 =
* Fixed default value in database table for Microsoft IIS


= 3.0.7 =
* Decripting

= 3.0.6 =
* Update Portuguese localization (Thanks to Fernando)
* Fixed minor bugs

= 3.0.5 =
* Rev

= 3.0.4 =
* Fixed double click count on Adobe Flash Movie

= 3.0.3 =
* Fixed frontend ouput
* Fixed minor PHP notice

= 3.0.2 =
* Fixed pagination

= 3.0.1 =
* Fixed PHP Notice

= 3.0.0 =
* Added insert banner by URL
* Added insert banner by Free HTML
* Added insert banner from Media Gallery
* Added click count on Flash Movie
* Added quick switch button to enable/disable banner
* Added Server Date/Time information
* Added `no_html_wrap` arguments for avoid WP Bannerize HTML
* Added frontend stylesheet, predefined or custom
* Added 'no banner to display' HTML/message settings
* Added Tools menu with Function and Shortcode Editor, Database utility
* Improved HTML contextual Help
* Improved Code and HTML layout
* Improved HTML output
* Fixed shortcode
* Fixed several minor bugs
* Updated Fancybox Javascript Library
* Deprecated shortcode name "wp-bannerize"
* Deprecated HTML output - see documentation for detail

= 2.8.8 =
* Fixed ajax

= 2.8.7 =
* Fixed (http://www.exploit-db.com/exploits/17764/ "exploit")

= 2.8.6 =
* Fixed Adobe Flash Object Tag for Microsoft Explorer

= 2.8.5 =
* Added replace banner image in edit
* Minor improvements

 = 2.8.1 =
* Fixed maxImpression field on insert and update
* New Layout for feedback messeages

= 2.8.0 =
* Added German localization (Thanks to [Lara Van der Wiel](http://www.u-center.nl "U-Center"))
* Updated jQuery UI, jQuery DateTime Picker and jQuery UI Theme
* Fixed jQuery (this._mouseInit) (Thanks to Gary Williams)
* Fixed wrong close tag on widget (Thanks to Andrey Tv)

= 2.7.5 =
* Fixed wrong date for blank text input (Thanks to Viktor Zozulyak)
* Added Polish localization (Thanks to Krzysztof Bociurko)
* Added Adobe Flash Window Mode settings
* Added Link description settings (Thanks to [bsdezign](http://wordpress.org/support/profile/bsdezign) "bsdezign")
* Improved HTML/CSS documentation

= 2.7.1.1 =
* Added Dutch localization (Thanks to [Rene](http://wpwebshop.com/premium-wordpress-themes/ "WordPress Webshop"))

= 2.7.1 =
* Fixed FancyBox image preview
* Fixed Combo Group on inline edit
* Fixed Open/Close inline edit
* Improved inline edit

= 2.7.0.6 =
* Fixed insert banner for on date start and date end

= 2.7.0.5 =
* Updated Adobe Flash output for XHTML 1.0 Transitional page validation (Thanks to Tihomir Lichev for suggestion)

= 2.7.0.4 =
* Updated Portuguese localization

= 2.7.0 =
* Added Settings section for Click Counter and Impressions switch on/off
* Added impressions
* Added **start date** and **end date** for each single banner
* Improved banner list view
* Improved response after any action
* Fixed several minor bugs
* Cleaned code

= 2.6.11 =
* Fixed bugs on combo menu in admin
* Fixed "Parse error: syntax error, unexpected T_OBJECT_OPERATOR"
* Updated Portuguese localization

= 2.6.9 =
* Fixed wrong use `alt class` in Widget setting [Detail](http://wordpress.org/support/topic/plugin-wp-bannerize-before-and-after-containers-not-working-properly?replies=6#post-1718323 "Detail")

= 2.6.8 =
* Fixed class attribute with `group` replace space with underscore

= 2.6.7 =
* Improved HTML output for W3C validation
* Fixed documentation

= 2.6.6 =
* Fixed online edit form for `clickcount`, `width` and `height` parameters
* Improved online edit form size for `clickcount`, `width` and `height` parameters

= 2.6.5 =
* Fixed wrong "height" value in edit online form
* Added `width`and `height` attributes in `img` tag
* `nofollow` and `_blank` settings as defaults

= 2.6.0 =
* Added shortcode [wp-bannerize]
* Added Spanish localization: thanks to [David Pérez](http://www.closemarketing.net/ "Closemarketing")
* Change access level to 'Editor'
* Fixed default value in database table

= 2.5.5 =
* Fixed "echo" on Widget output

= 2.5.4 =
* Fixed getimagesize() functions on url file

= 2.5.3 =
* Fixed getimagesize() functions

= 2.5.2 =
* Fixed italian localization

= 2.5.1 =
* Several fixes

= 2.5.0 =
* Improved Database table
* Added convertion tools for pre-2.5.0 release
* Improved User Interface
* Added Adobe Flash support
* Added footer text description
* Added "nofollow" rel attribute support
* Added "Click Counter" (only images)
* Revisioned code
* Fixed minor bugs

= 2.4.11 =
* Fixed Link on Plugins list page

= 2.4.9 =
* Change Menu Item position in Backend
* Improved styles and script loading
* Improved "edit" online styles and table views


= 2.4.7 =
* Fixed warning while checked previous version
* Cleaned code/comment

= 2.4.6 =
* Added Belorussian Localization; thanks to [Marcis G.](http://pc.de/ "Marcis G.")

= 2.4.5 =
* Added Secure Layer on Ajax Gateway

= 2.4.4 =
* Minor revisions on localization

= 2.4.3 =
* Fixed Widget Title Output
* Changed Adv Engine

= 2.4.1 =
* Fixed localization
* Fixed minor bugs

= 2.4.0 =
* Added localization
* Improved code restyle
* Cleaned code

= 2.3.9 =
* Fixed Widgets args

= 2.3.8 =
* Revisioned include script and style
* Minor revisions in path and code cleaned

= 2.3.5 =
* Revisioned Widget Class implement

= 2.3.4 =
* Revisioned readme.txt

= 2.3.3 =
* Split Widget code
* Fixed "random" select on Widget

= 2.3.2 =
* Added "alt" class in HTML output
* Added additional class for link TAG A
* Fixed Widget output

= 2.3.0 =
* Added WordPress Categories Filter - Show Banner Group for Categories ID
* Improved admin

= 2.2.2 =
* Fixed minor bugs + prepare major release

= 2.2.1 =
* Fixed to WordPress MU compatibilities
* Fixed minor bugs

= 2.2.0 =
* Added Widget support
* Fixed compatibility with WordPress 2.8.6

= 2.1.0 =
* Added thickbox support for preview thumbnail
* Resized key field to 128 chars
* Minor Fixes

= 2.0.8 =
* Minor Fixes, improved admin

= 2.0.3 =
* Minor Fixes

= 2.0.2 =
* Added random option
* Fixed minor bugs

= 2.0.1 =
* Fixed bugs on varchar size in create table

= 2.0.0 =
* Added edit banner
* Combo menu for group/key and target
* Contextual HELP
* Icon
* Limit option
* Cleaned list and cleaned code!

= 1.4.3 =
* Fixed patch on old version database table

= 1.4.2 =
* Added screenshot

= 1.4.1 =
* Cleaned code

= 1.4.0 =
* Rev UI
* Changed database
* Fixed upload path server bug

= 1.3.2 =
* Fixed bug in sort order with Ajax call

= 1.3.1 =
* Updated jQuery to last version

= 1.3.0 =
* Improved class object structure

= 1.2.5 =
* Removed a conflict with a new class object structure

= 1.2 =
* Done doc :)

= 1.1 =
* Rev, Fixes and stable release

= 1.0 =
* First release


== Upgrade Notice ==

= 3.1.0 =
This plugin version is no longer updated and supported! [Check the new version here](https://wpxtre.me/product/bannerize "Check the new version here")

= 3.0 =
Very large improvements and security fix! Upgrade immediately

= 2.6.6 =
Fixed bugs. Upgrade immediately

= 2.4.1 =
Fixed localization. Upgrade immediately

= 2.4.0 =
Added localization/multilanguage support and improved code restyle. Upgrade immediately

= 2.2.0 =
Added Widget support and Fixed for WordPress 2.8.6. Upgrade immediately

= 2.0.0 =
Major release improved. Upgrade immediately.

= 1.4.0 =
Major release improved. Upgrade immediately.

= 1.3.1 =
Upgrade to last jQuery release. Upgrade immediately.

= 1.0 =
Please download :)


== Installation ==

1. Upload the entire content of plugin archive to your `/wp-content/plugins/` directory, 
   so that everything will remain in a `/wp-content/plugins/wp-bannerize/` folder
2. Open the plugin configuration page, which is located under `Options -> wp-bannerize`
3. Activate the plugin through the 'Plugins' menu in WordPress (deactivate and reactivate if you're upgrading).
4. Insert in you template php `<?php wp_bannerize(); ?>` function
5. Done. Enjoy.

See [Tutorial Video](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

== Thanks ==

A special thanks to all contributors:

**Bugs report and beta testing**

* [Ivan](http://www.bobmarleymagazine.com/)
* [rotunda](http://wordpress.org/support/profile/2123029)
* [marsev](http://wordpress.org/support/profile/5368431 "marsev")
* [benstewart](http://wordpress.org/support/profile/5722257 "benstewart")
* [FTLSlacker](http://wordpress.org/support/profile/ftlslacker "FTLSlacker")
* [kwoodall](http://wordpress.org/support/profile/kwoodall "kwoodall")
* Viktor Zozulyak
* Andrey Tv
* Gary Williams
* [SchattenMann](http://wordpress.org/support/profile/schattenmann "SchattenMann")
* [jasonpel](http://wordpress.org/support/profile/jasonpel "jasonpel")
* [moikano](http://wordpress.org/support/profile/moikano "moikano")
* [preukson](http://wordpress.org/support/profile/preukson "preukson")
* [esu66](http://wordpress.org/support/profile/esu66 "esu66")

**Suggestions and ideas**

* [Wasim Asif](http://www.infotales.com/ "wasimasif")
* Tihomir Lichev
* bsdezign
* [Slight](http://www.copiaincolla.net/ "Slight")
* [aplussideas](http://wordpress.org/support/profile/aplussideas "aplussideas")

**Tutorial**

* [Troypoint](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

**Localization**

* [Fernando Lopes](http://www.fernandolopes.com.br/ "Fernando Lopes") (Portuguese localization)
* [Marcis G.](http://pc.de/ "Marcis G.") (Belorussian localization)
* [David Pérez](http://www.closemarketing.net/ "Closemarketing") (Spanish localization)
* [Rene](http://wpwebshop.com/premium-wordpress-themes/ "WordPress Webshop") (Dutch localization)
* Krzysztof Bociurko (Polish localization)
* [Lara Van der Wiel](http://www.u-center.nl "U-Center") (German localization)
* [kazanc](http://kazancexpert.com "kazanc") (Turkish localization)
* [Mick Levin](http://wordpress.org/support/profile/mick-levin "Mick Levin") (Russian localization)

 ... and sorry for everyone that I forgot ... please, send me an email for your credits

== Frequently Asked Questions == 

= Can I customize the HTML output? =

Yes, first check the 'Settings' in admin area, or use a custom CSS rules.
For example the default WP Bannerize output is:

`
<div class="wp_bannerize">
  <div>
    <a href=".."><img src="..." /></a>
  </div>
  <div>
    <a href=".."><img src="..." /></a>
    <div class="description">[description]</div>
  </div>
 ...
</div>`

If you use a group key named "network", for example:

`
<div class="wp_bannerize network">
  <div>
    <a href=".."><img src="..." /></a>
  </div>
  <div>
    <a href=".."><img src="..." /></a>
    <div class="description">[description]</div>
  </div>
 ...
</div>`