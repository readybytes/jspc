<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

if(defined('DEFINE_JSPC_FRONT_INCLUDES'))
	return;

define('DEFINE_JSPC_FRONT_INCLUDES','DEFINE_JSPC_FRONT_INCLUDES');

//	This is file for BACKEND only, should be included in starting file only.

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );


$communityPath = JPATH_ROOT.'/components/com_community';

if(!JFolder::exists($communityPath))
	return;


//community files
require_once(JPATH_ROOT.'/components/com_community/libraries/core.php' );
	
//// define our include paths to joomla
require_once (JPATH_ROOT.'/components/com_community/defines.community.php');
require_once (JPATH_ROOT.'/administrator/components/com_jspc/includes.jspc.php');
require_once (JPATH_ROOT.'/components/com_jspc/libraries/jspc.php');
require_once (JPATH_ROOT.'/components/com_jspc/libraries/base/text.php');

/*Langauge file will be independent now */
$lang = JFactory::getLanguage();
if($lang) 
	$lang->load( 'com_jspc' );