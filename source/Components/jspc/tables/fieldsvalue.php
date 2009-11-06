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
*/ //now run
class ProfilestatusTableFieldsvalue extends JTable
{

	var $id			= null;
	var $field_id		= null;
	var $value		= null;
	
	function __construct(&$db)
	{
		parent::__construct('#__profilestatus_fields_values','id', $db);
	}
	
	function load( $id)
	{
		if( $id == 0 )
		{
			$this->id			= 0;
			$this->field_id			= 0;
			$this->value			= 0;
		}
		else
		{
			return parent::load( $id );
		}
	}

	
	/**
	 * Overrides Joomla's JTable store method so that we can define proper values
	 * upon saving a new entry
	 * 
	 * @return boolean true on success
	 **/
	function store(  )
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
			$this->id			= $data['id'];
			$this->field_id		= $data['fieldid'];
			$this->value		= $data['value'];

			return parent::bind($data);
	}
}

?>