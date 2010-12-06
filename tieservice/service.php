<?php
define("SP_PATH",dirname(__FILE__)."/SpeedPHP");
define("APP_PATH",dirname(__FILE__));
$spConfig = array(
    'sp_cache' => APP_PATH.'/tmp', //cache dir
    'controller_path' => APP_PATH.'/controller2', //Controller dir
    'model_path' => APP_PATH.'/model', //Model dir

    "db" => array(
        'host' => '173.201.88.17',
        'login' => 'tiedb000001',
        'password' => 'GWUcs000001',
        'database' => 'tiedb000001',
    ),
    'view' => array(
        'enabled' => TRUE, //Use Smarty view template
        'config' =>array(
            'template_dir' => APP_PATH.'/tpl2', //template dir
            'compile_dir' => APP_PATH.'/tmp', //compile dir
            'cache_dir' => APP_PATH.'/tmp', //cache dir
            'left_delimiter' => '<{',  // smarty left mark
            'right_delimiter' => '}>', // smarty right mark
        ),
        'auto_display' => TRUE, //Auto display
        'auto_display_sep' => "/", //Link pattern, "/" or "_"
        'auto_display_suffix' => '.xml',
    ),
    'launch' => array( 
        'router_prefilter' => array( 
            array('spAcl','mincheck') // Limited authentication
            //array('spAcl','maxcheck') // restrict authentication
         )
    ),
    'ext' => array( // Extension set
        'spAcl' => array( // acl extension
            // No rights, use lib_user::acljump()
            'prompt' => array("lib_user", "acljump2"),
        ), 
    ),
);
require(SP_PATH."/SpeedPHP.php"); 
spRun();