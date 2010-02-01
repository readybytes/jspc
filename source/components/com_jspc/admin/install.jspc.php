<?php
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
