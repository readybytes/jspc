<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

if(defined('DEFINE_JSPC_ADMIN_INCLUDES'))
	return;

define('DEFINE_JSPC_ADMIN_INCLUDES','DEFINE_JSPC_ADMIN_INCLUDES');

//	This is file for BACKEND only, should be included in starting file only.

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );


$communityPath = JPATH_ROOT.DS.'components'.DS.'com_community';

if(!JFolder::exists($communityPath))
	return;


//community files
require_once(JPATH_ROOT.DS.'components'.DS.'com_community' . DS . 'libraries' . DS . 'core.php' );

	
//// define our include paths to joomla
jimport( 'joomla.application.component.model' );
JModel::addIncludePath(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jspc'.DS.'models');
JTable::addIncludePath( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jspc' . DS . 'tables' );

require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jspc' . DS . 'addons' . DS . 'addons.php' );
require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jspc' . DS . 'helpers' . DS . 'core.php' );
require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jspc' . DS . 'helpers' . DS . 'jspc.php' );

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_jspc' );
