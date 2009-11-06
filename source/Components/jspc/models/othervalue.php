<?php
/**
 * Joomla! 1.5 component profilestatus
 *
 * @version $Id: profilestatus.php 2009-07-01 01:02:25 svn $
 * @author Meenal Devpura
 * @package Joomla
 * @subpackage profilestatus
 * @license GNU/GPL
 *
 * Joomla component for jomsocial to show completion of profile
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

class ProfilestatusModelOtherValue extends JModel {
    function __construct() {
		parent::__construct();
    }
	
	function getData()
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values');
		$db->setQuery( $query );
		$fields	= $db->loadObjectList();
		return $fields;
	}
	
	function getDataFromId($id)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values').' '
				.'WHERE `id`='.$db->Quote($id);
				
		$db->setQuery( $query );
		$field	= $db->loadObject();
		return $field;
	}
	
	
	/**
	 * Method to store the fieldvalue
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'othervalue', 'ProfilestatusTable' );
		
		//print_r($data);
		$row->load( $data['id'] );

		// Bind the form fields to the fields value table
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the field value table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

}
?>