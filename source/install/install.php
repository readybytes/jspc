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
	{
		insertSampleData();
		return true;
	}

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

function insertSampleData()
{       
        $query          = " SELECT count(`id`) FROM `#__jspc_addons` ";
        
        $db		= JFactory::getDBO();
        $db->setQuery( $query );
        $result		=$db->query();
        if($result)
                return;
                
        $insertQuery = "INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`)"
                                        ." VALUES (1, 'albums', 'Create 8 Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Create %s Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 1),"
                                        ." (2, 'groupowner', 'Create 5 Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group\njspc_profiletype=0\n\n', 'groupowner_total=5\n\n', 1),"
                                        ." (3, 'photos', 'Add 9 Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Add %s Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 1),"
                                        ." (4, 'avatar', 'Upload Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload Avtar\njspc_profiletype=0\n\n', '\n', 1),"
                                        ." (5, 'groupmember', 'Join 6 Group', 'jspc_core_total_contribution=70\njspc_core_display_text=Join %s Group\njspc_profiletype=0\n\n', 'groupmember_total=6\n\n', 1),"
                                        ." (6, 'videos', 'Upload 4 Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload %s Videos\njspc_profiletype=0\n\n', 'videos_total=4\n\n', 1),"
                                        ." (7, 'profilefields', 'Edit Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Edit Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 1)";
        
        $db= JFactory::getDBO();
        $db->setQuery( $insertQuery );
        $db->query();
        
        return;

}
