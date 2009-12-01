<?php
/*
=====================================================
 Login on Registration - by Easy! Designs, LLC
-----------------------------------------------------
 http://www.easy-designs.net/
=====================================================
 This extension was created by Aaron Gustafson
 - aaron@easy-designs.net
=====================================================
 File: ext.login_on_registration.php
-----------------------------------------------------
 Purpose: Automatically logs a user in when registering
=====================================================
*/

if( !defined( 'EXT' ) ){
  exit('Invalid file request');
}

class Login_on_registration {
  var $settings       = array();

  var $name           = 'Login On Registration';
  var $version        = '1.0';
  var $description    = 'Logs a user in when they register';
  var $settings_exist = 'n';
  var $docs_url       = '';
      
  // -------------------------------
  // Constructor
  // -------------------------------
  function Login_on_registration($settings=''){
    $this->settings = $settings;
  }
  // END Akismet_check

  
  
  // --------------------------------
  //  login
  // -------------------------------- 
  function login( $user_object, $member_id ){
    # requires the User module
    if( class_exists('User') === FALSE ){
  		require PATH_MOD.'user/mod.user'.EXT;
  	}
  	$U = new User();
    # log in
    $U->_remote_login();
  }
  // END login()

  // --------------------------------
  //  Activate Extension
  // --------------------------------
  
  function activate_extension(){
    global $DB;
    
    $DB->query(
      $DB->insert_string(
        'exp_extensions',
        array(
          'extension_id' => '',
          'class'        => __CLASS__,
          'method'       => "login",
          'hook'         => "user_register_end",
          'settings'     => '',
          'priority'     => 10,
          'version'      => $this->version,
          'enabled'      => "y"
        )
      )
    ); // end db->query
  }
  // END activate_extension
   
   
  // --------------------------------
  //  Update Extension
  // --------------------------------  
  function update_extension($current=''){
    global $DB, $PREFS;
    
    //die($current);
    if ($current == '' OR $current == $this->version)
    {
      return FALSE;
    }
    
    if ($current <= '1.0')
    {
      // Update to next version: 1.1
      // Just a setting update...
    }
    
    $DB->query("UPDATE ".$PREFS->ini('db_prefix')."_extensions 
                SET version = '".$DB->escape_str($this->version)."' 
                WHERE class = '".__CLASS__."'");
  }
  // END update_extension

  // --------------------------------
  //  Disable Extension
  // --------------------------------
  function disable_extension(){
    global $DB, $PREFS;
    
    $DB->query("DELETE FROM ".$PREFS->ini('db_prefix')."_extensions WHERE class = '".__CLASS__."'");
  }
  // END disable_extension
   
}
// END CLASS
?>