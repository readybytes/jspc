<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
function com_uninstall()
{
	//drop_database();
}

function drop_database()
{
	$db	=& JFactory::getDBO();
	$query ='DROP TABLE `#__profilestatus_fields_values`';
	$db->setQuery( $query );
	$db->query();
	
	$query ='DROP TABLE `#__profilestatus_other_values`';
	$db->setQuery( $query );
	$db->query();
	
	return true;
}
