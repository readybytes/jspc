<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.filesystem.folder' );
		
$jspcPath = JPATH_ROOT.DS.DS.'components'.DS.'com_jspc';

if(!JFolder::exists($jspcPath))
	return false;

require_once( JPATH_ROOT . DS . 'components' . DS . 'com_jspc'  . DS . 'includes.jspc.php');

$communityPath = JPATH_ROOT.DS.DS.'components'.DS.'com_community';

if(!JFolder::exists($communityPath))
	return false;

//community files
require_once(JPATH_ROOT.DS.'components'.DS.'com_community' . DS . 'libraries' . DS . 'core.php' );
require_once (JPATH_ROOT. DS.'components'.DS.'com_community'.DS.'helpers'.DS.'owner.php');

//load language
$language = JFactory::getLanguage();
$language->load('mod_jspc'); 

$user					=& JFactory::getUser();

require_once( dirname(__FILE__).DS.'helper.php' );
$disp= ProfileCompleteHelper::getJspcHTML($user->id, $params );
echo $disp;
