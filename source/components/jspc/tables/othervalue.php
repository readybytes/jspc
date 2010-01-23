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

// Include library dependencies
jimport('joomla.filter.input');

/**
* Table class
*
* @package          Joomla
* @subpackage		profilestatus
*/

class ProfilestatusTableothervalue extends JTable {

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	var $name = null;
	var $total = null;
	var $value = null;

    /**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__profilestatus_other_values', 'id', $db);
	}
	
	function load( $id)
	{
		if( $id == 0 )
		{
			$this->id			= 0;
			$this->name			= 0;
			$this->total		= 0;
			$this->value		= 0;
		}
		else
		{
			return parent::load( $id );
		}
	}

	function delete()
	{		
		return parent::delete();
	}
	
	/**
	 * Overrides Joomla's JTable store method so that we can define proper values
	 * upon saving a new entry
	 * 
	 * @return boolean true on success
	 **/
	function store( )
	{
		$db		=& $this->getDBO();		
 		return parent::store();
	}


	/**
	 * Bind AJAX data into object's property
	 * @param	array	data	The data for this field
	 **/
	function bind($data)
	{
			print_r($data);
			///*
			$this->name			= $data['name'];
			$this->total		= $data['total'];
			$this->value		= $data['value'];
			//*/
			/*
			$this->name			= $data->name;
			$this->total		= $data->total;
			$this->value		= $data->value;
			*/
			//print_r($this);
			return parent::bind($data);
	}
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		if (trim($this->name) == '') {
			$this->setError(JText::_('Your profile status must contain a name'));
			return false;
		}
		return true;
	}

}
?>