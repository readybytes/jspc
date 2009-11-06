<?php
/**
 * Joomla! 1.5 component profilestatus
 *
 * @version $Id: view.html.php 2009-07-01 01:02:25 svn $
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
jimport( 'joomla.application.component.view');
class ProfilestatusViewFieldsvalue extends JView 
{
    function display($tpl = null){
		require_once( JPATH_COMPONENT.DS.'helpers'.DS.'profilestatus.php' );
		$fields = ProfilestatusHelper::get_jomsocial_profile_fields();
		$data = array();
		$i = 0;
		if(!empty($fields))
		{
			foreach($fields as $field)
			{
				$id = ProfilestatusHelper::get_id_from_fieldId_from_fieldsvalue($field->id);
				$row = ProfilestatusHelper::getfieldvalue($id);
				if(empty($row->value))
					$value = 0;
				else
					$value = $row->value;
				///*
				$data[$i]->fieldid = $field->id;
				$data[$i]->fieldname = $field->name;
				$data[$i]->value = $value;
				$data[$i]->id = $id;
				$data[$i]->type = $field->type;
				if($value != 0)
					$data[$i]->percentage = ProfilestatusHelper::get_field_percentage_contribution($value);
				else
					$data[$i]->percentage = 0;
				
				++$i;
				//*/
				/*
				$data['fieldid'] = $field->id;
				$data['fieldname'] = $field->name;
				$data['value'] = $value;
				$data['id'] = $id;
				$data['type'] = $field->type;
				*/
			}
		}
		//print_r($data);
		$this->assign('datas', $data);
		return parent::display($tpl);
    }
	
	function editField($data)
	{
		$this->assign('row', $data['row']);
		$this->assign('fieldname', $data['fieldname']);
		$this->assign('value', $data['value']);
		$this->assign('fieldid', $data['fieldid']);
		
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Edit Field Contribution in profile completion' ), 'profilestatus' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_profilestatus');
		JToolBarHelper::divider();
		//JToolBarHelper::trash('save', JText::_( 'Save' ));
		JToolBarHelper::save(saveField,Save);
		//JToolBarHelper::trash('cancel', JText::_( 'Close' ) , false );
		JToolBarHelper::cancel( 'cancelField', 'Close' );
		parent::display($tpl);
	}
	
	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/	 	 
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Profile Fields Percentage Informantion' ), 'fieldsvalue' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_profilestatus');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'Publish' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'Unpublish' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('removefield', JText::_( 'Delete' ));
		JToolBarHelper::addNew('newfield', JText::_( 'New Field' ));
	}

}
?>