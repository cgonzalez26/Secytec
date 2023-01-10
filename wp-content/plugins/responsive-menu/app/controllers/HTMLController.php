<?php


class RM_HTMLController extends RM_BaseController {
    
    
    /**
     * Prepare the HTML for display on the front end
     *
     * @return null
     * @added 1.0
     */
    
    static function prepare() {
        
        
        add_action( 'wp_footer', array( 'RM_HTMLController', 'display' ) );
        
        
    }
    
    
    /**
     * Creates the view for the menu and echos it out
     *
     * @return string
     * @added 1.0
     */
    
    static function display() {
        
         
        RM_View::make( 'menu', RM_Registry::get( 'options' ) );
     
        
    }
    
    
}