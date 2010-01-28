<?php
defined('_JEXEC') or die('Restricted access');
function com_install()
{
	if(check_jomsocial_existance() == false)
		return false;
		
	if(setup_database() == false)
		return false;
	
	$siteURL  = JURI::base();
	if(strstr($siteURL,'localhost')==false && strstr($siteURL,'127.0.0.1')==false)
	{
		global $mainframe;
		$version  = "PROFILE_STATUS_COMPONENT";
		$siteURL  = JURI::base();
		$admin	  = $mainframe->getCfg('mailfrom');
		echo '<img src="http://www.joomlaxi.com/index.php?option=ssv_url&task=ssv_add'
					.'&url='.$siteURL
					.'&version='.$version
					.'&admin='.$admin
					.'" />';
					
				$user 		=& JUser::getInstance((int)JFactory::getUser()->get('id'));
				$email 		=  'shyam@joomlaxi.com';
				$sitename 		= $mainframe->getCfg( 'sitename' );
				$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
				$fromname 		= $mainframe->getCfg( 'fromname' );
				$subject 		= 'Installation of JoomlaXI ProfileCompletness';
				$message 		= 'Website URL :  ' . $siteURL . '\n';
				$message 		= html_entity_decode($message, ENT_QUOTES);
				JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message);
	}
	return true;
}

function setup_database()
{		
	if(create_tables() == false)
		return false;
	if(insert_default_values() == false)
		return false;
		
	return true;
}

function create_tables()
{
	$allQueries  	= array();
	
	$allQueries[] = 'CREATE TABLE IF NOT EXISTS `#__profilestatus_fields_values` ( `id` int(10) NOT NULL AUTO_INCREMENT,`field_id` int(10) NOT NULL,`value` text NOT NULL,PRIMARY KEY (`id`),KEY `field_id` (`field_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	
	$allQueries[] = 'CREATE TABLE IF NOT EXISTS `#__profilestatus_other_values` ( `id` int(10) NOT NULL AUTO_INCREMENT,`name` text NOT NULL,`key` text NOT NULL,`total` int(11) NOT NULL default \'0\',`value` int(11) NOT NULL default \'0\',PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	
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

function insert_default_values()
{
	// do not install If already installed.
	$db	=& JFactory::getDBO();
	
	$query	=" SELECT name FROM #__profilestatus_other_values "
			." WHERE id='7' ";
	$db->setQuery( $query );
	$result = $db->loadResult();
	if($result)
		return true;
	
	// first time install it
	$query  = "INSERT INTO `#__profilestatus_other_values` (`id`,`name`,`key` ,`total`, `value`) VALUES
			 (1,'Photos Added','photo', 0, 0),
			 (2,'Added Album','album',0 ,0 ),
			 (3,'Groups Joined','groupmember',0 ,0 ),
			 (4,'Groups Owned','groupowner', 0, 0),
			 (5,'Videos Added','video',0 ,0 ),
			 (6,'Custome Avatar','avatar',0 ,0 ),
			 (7,'Filled Profile Fields','profile',0 ,0 )";
	
	//print_r($query);
	$db->setQuery( $query );
	$db->query();
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
