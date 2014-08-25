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

define('JSPC_VERSION','@global.version@');

//	This is file for BACKEND only, should be included in starting file only.

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );


$communityPath = JPATH_ROOT.'/components/com_community';

if(!JFolder::exists($communityPath))
	return;


//community files
require_once(JPATH_ROOT.'/components/com_community/libraries/core.php' );

$version 	= new JVersion();
$document	= JFactory::getDocument();
if($version->RELEASE === '2.5')
{	
	$css	= JURI::base().'administrator/components/com_jspc/assets/css/admin.j25.css';
	$document->addStyleSheet($css);

	$bootstarpCss	= JURI::base().'components/com_community/installer/css/bootstrap.min.css';
	$document->addStyleSheet($bootstarpCss);
		
	$bootstarpResCss	= JURI::base().'components/com_community/installer/css/bootstrap-responsive.min.css';
	$document->addStyleSheet($bootstarpResCss);
}else{
	$document->addStyleSheet(JUri::base().'administrator/components/com_jspc/assets/css/admin.css');
}

	
//// define our include paths to joomla
jimport( 'joomla.application.component.model' );
JModelLegacy::addIncludePath(JPATH_ROOT.'/administrator/components/com_jspc/models');
JTable::addIncludePath( JPATH_ROOT.'/administrator/components/com_jspc/tables' );

require_once(JPATH_ROOT.'/administrator/components/com_jspc/addons/addons.php' );
require_once(JPATH_ROOT.'/administrator/components/com_jspc/helpers/core.php' );
require_once(JPATH_ROOT.'/administrator/components/com_jspc/helpers/jspc.php' );
require_once(JPATH_ROOT.'/components/com_jspc/libraries/base/text.php');
require_once(JPATH_ROOT.'/components/com_jspc/libraries/base/parameter.php');

$isXiptExist = JspcHelper::checkXiptExists();
if($isXiptExist)
	require_once(JPATH_ROOT.'/administrator/components/com_jspc/helpers/xiptwrapper.php' );
	require_once(JPATH_ROOT.'/administrator/components/com_jspc/helpers/multiprofile.php' );

/*Load Langauge file*/
$lang = JFactory::getLanguage();
if($lang)
	$lang->load( 'com_jspc' );
