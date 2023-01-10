<?php

class RM_BaseController {
    
    
    /**
     * Determines wether to display scripts in footer
     *
     * @return boolean
     * @added 2.0
     */
    
    static function inFooter() {
           
        
        return RM_Registry::get( 'options', 'RMFooter' ) && RM_Registry::get( 'options', 'RMFooter' ) == 'footer' ?  true : false;
        
        
    }
    
    
}