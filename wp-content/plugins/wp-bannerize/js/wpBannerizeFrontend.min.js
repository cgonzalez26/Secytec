/**
 * Javascript functions
 *
 * @author          =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright       Copyright (C) 2008-2013
 * @version         3.0
 */

var WPBannerizeJavascript = {
  vesion : "1.0.0",

  incrementClickCount : function ( id )
  {
    jQuery.post( wpBannerizeJavascriptLocalization.ajaxURL, {
        action : 'wpBannerizeClickCounter',
        id     : id
      }
    );
  }
};