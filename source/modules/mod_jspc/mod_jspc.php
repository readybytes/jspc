<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_BASE . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php');
require_once( JPATH_BASE . DS . 'components' . DS . 'com_jspc' . DS . 'libraries' . DS . 'profilestatus.php');

//load language
JPlugin::loadLanguage( 'mod_jspc');
$my					=& CFactory::getUser();

require_once( dirname(__FILE__).DS.'helper.php' );
$disp= ProfileCompleteHelper::_getShowProfileStatusHTML($my->_userid, $params );
echo $disp;
