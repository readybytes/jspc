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
class ProfilestatusViewSummary extends JView 
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
		$fields = ProfilestatusHelper::getData();
		
		$this->assign('otherfields', $fields);
		$this->assign('datas', $data);
		return parent::display($tpl);
    }
}
?>