<?php
/**
 * PMPro Functions
 *
 * Functions that depend on PMPro being fully loaded
 *
 * @package    Pmpfb
 * @subpackage Pmpfb/admin
 * @author     David Towoju (Figarts) <hello@figarts.co>


 */


/**
 * Get PMPro memberships
 * 
 * @since    1.0.0
 * @param    string    Level 
 */	
function pmpfb_get_pmprolevels(){
	$levels = pmpro_getAllLevels();
  if(!empty($levels) && is_array($levels)){
    $getLevels = array();
    foreach($levels as $level){
      $getLevels[$level->id] = $level->name;
    }
    return json_encode($getLevels, JSON_PRETTY_PRINT);
  }
}