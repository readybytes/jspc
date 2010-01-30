<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );


$communityPath = JPATH_ROOT.DS.DS.'components'.DS.'com_community';

if(!JFolder::exists($communityPath))
	return;
	
require_once( JPATH_BASE . DS . 'components' . DS . 'com_jspc' . DS . 'libraries' . DS . 'jspc.php');

//load language
JPlugin::loadLanguage( 'mod_jspc');
$user					=& JFactory::getUser();

require_once( dirname(__FILE__).DS.'helper.php' );
$disp= ProfileCompleteHelper::getJspcHTML($user->id, $params );
echo $disp;
