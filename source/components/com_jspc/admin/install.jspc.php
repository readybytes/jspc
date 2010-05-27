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
		return false;
	
	return true;
}

function setup_database()
{		
	if(create_tables() == false)
		return false;
	
	/* inser some sample rules into database */
	insert_sample_rule(); 
	
		
	return true;
}

function create_tables()
{
	$allQueries  	= array();
	
	$allQueries[] = 'CREATE TABLE IF NOT EXISTS `#__jspc_addons` (
  			`id` int(21) NOT NULL auto_increment,
  			`name` varchar(64) NOT NULL,
  			`featurename` varchar(250) NOT NULL,
  			`coreparams` text NOT NULL,
  			`addonparams` text NOT NULL,
  			`published` tinyint(1) NOT NULL,
  			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
	
	$db=& JFactory::getDBO();
	foreach($allQueries as $query) {
		$db->setQuery( $query );
		$db->query();
	}
	
	return true;
	
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

function insert_sample_rule()
{
	$allQueries  	= array();
	
	$query		  = " SELECT count(`id`) FROM `#__jspc_addons` ";
	
	$db=& JFactory::getDBO();
	$db->setQuery( $query );
	$result=$db->query();
	if($result)
		return;
		
	$allQueries[] = "INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`)"
	 				." VALUES (1, 'albums', 'Create 8 Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Create %s Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 1),"
					." (2, 'groupowner', 'Create 5 Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group\njspc_profiletype=0\n\n', 'groupowner_total=5\n\n', 1),"
					." (3, 'photos', 'Add 9 Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Add %s Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 1),"
					." (4, 'avatar', 'Upload Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload Avtar\njspc_profiletype=0\n\n', '\n', 1),"
					." (5, 'groupmember', 'Join 6 Group', 'jspc_core_total_contribution=70\njspc_core_display_text=Join %s Group\njspc_profiletype=0\n\n', 'groupmember_total=6\n\n', 1),"
					." (6, 'videos', 'Upload 4 Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload %s Videos\njspc_profiletype=0\n\n', 'videos_total=4\n\n', 1),"
					." (7, 'profilefields', 'Edit Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Edit Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 1)";
	
	$db=& JFactory::getDBO();
	foreach($allQueries as $query) {
		$db->setQuery( $query );
		$db->query();
	}
	
	return;
	
}
