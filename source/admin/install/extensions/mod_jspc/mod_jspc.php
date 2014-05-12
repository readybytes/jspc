<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.filesystem.folder' );
		
$jspcPath = JPATH_ROOT.'/components/com_jspc';

if(!JFolder::exists($jspcPath))
	return false;

require_once( JPATH_ROOT .'/components/com_jspc/includes.jspc.php');

$communityPath = JPATH_ROOT.'/components/com_community';

if(!JFolder::exists($communityPath))
	return false;

//community files
require_once(JPATH_ROOT.'/components/com_community/libraries/core.php' );
require_once (JPATH_ROOT.'/components/com_community/helpers/owner.php');

//load language
$language = JFactory::getLanguage();
$language->load('mod_jspc'); 

$user	= JFactory::getUser();

require_once( dirname(__FILE__).'/helper.php' );
$disp= ProfileCompleteHelper::getJspcHTML($user->id, $params );
echo $disp;
