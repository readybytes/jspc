<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
function com_install()
{
	if(check_jomsocial_existance() == false)
		return false;
		
	if(setup_database() == false)
		JError::raiseError('INSTERR', "Not able to setup JSPC database correctly");
	
	if(installExtensions() == false){
		JError::raiseError('INSTERR', "NOT ABLE TO INSTALL EXTENSIONS");
		return false;
	}	

	return true;
}

function setup_database()
{		
	if(isTableExist('jspc_addons'))
		return true;

	return false;
}

function check_jomsocial_existance()
{
	$jomsocial_admin = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community';
	$jomsocial_front = JPATH_ROOT . DS . 'components' . DS . 'com_community';
	
	if(!is_dir($jomsocial_admin))
		return false;
	
	if(!is_dir($jomsocial_front))
		return false;
	
	return true;
}

function isTableExist($tableName)
{
	$mainframe	= JFactory::getApplication();

	$tables	= array();

	$database = JFactory::getDBO();
	$tables	  = $database->getTableList();

	return in_array( $mainframe->getCfg( 'dbprefix' ) . $tableName, $tables );
}

function installExtensions($extPath=null)
{
	//if no path defined, use default path
	if($extPath==null)
		$extPath = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jspc' .DS. 'install' .DS.'extensions';

	if(!JFolder::exists($extPath))
		return false;

	$extensions	= JFolder::folders($extPath);

	//no apps there to install
	if(empty($extensions))
		return true;

	//get instance of installer
	$installer =  new JInstaller();
	$installer->setOverwrite(true);

	//install all apps
	foreach ($extensions as $ext)
	{
		$msg = "Supportive Plugin/Module $ext Installed Successfully";

		// Install the packages
		if($installer->install($extPath.DS.$ext)==false)
			$msg = "Supportive Plugin/Module $ext Installation Failed";

		//enque the message
		JFactory::getApplication()->enqueueMessage($msg);
	}

	return true;
}
