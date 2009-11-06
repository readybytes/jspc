<?php
/**
 * Joomla! 1.5 component profilestatus
 *
 * @version $Id: helper.php 2009-07-01 01:02:25 svn $
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

/**
 * profilestatus Helper
 *
 * @package Joomla
 * @subpackage profilestatus
 * @since 1.5
 */
class ProfilestatusHelper {

//return all fields available in jomsocial
function get_jomsocial_profile_fields()
{
	$db		=& JFactory::getDBO();
		
	$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
			. 'ORDER BY ordering';
			
	$db->setQuery( $query );
	
	$result = $db->loadObjectlist();
	if(!empty($result))
		return $result;
	else
		false;
}

//return fieldname form field id from community fields table
function get_fieldname_from_fieldid($fieldId)
{
	
	$db		=& JFactory::getDBO();
		
	$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
			. 'WHERE `id`='. $db->Quote($fieldId);
			
	$db->setQuery( $query );
	
	$result = $db->loadObjectList();

	if(!empty($result[0]->name))
		return $result[0]->name;
	else
		return $result[0]->fieldcode;;
}

// return row from row id of fields values table
function getfieldvalue($id)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_fields_values').' '
				.'WHERE `id`='. $db->Quote($id);
		$db->setQuery( $query );
		$fields	= $db->loadObject();
		//print_r($fields);
		return $fields;
	}
	
	//return id of field values table from field id
	function get_id_from_fieldId_from_fieldsvalue($fieldId)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT id FROM'.' '
				. $db->nameQuote('#__profilestatus_fields_values').' '
				.'WHERE `field_id`='. $db->Quote($fieldId);
		
		$db->setQuery( $query );
		$field	= $db->loadResult();
		//print_r($field);
		if(!empty($field))
			return $field;
		else
			return 0;
	}
	
	//return total weightage of other ( e.g. :- 300 )
	function get_totalvalue_of_other()
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT SUM(value) as total FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values');
				
		$db->setQuery( $query );
		$result	= $db->loadResult();
		
		//print_r($fields);
		if(!empty($result))
			return $result;
		else
			return 0;
	}
	
	//return total value of fields and other feature (e.g :-weightage 150 of profile and 300 of other)
	function get_total_of_field_and_other()
	{
		$otherTotal = ProfilestatusHelper::get_totalvalue_of_other();
		//$fieldTotal = ProfilestatusHelper::get_total_fieldvalue();
		$total = $otherTotal + $fieldTotal;
		return $total;
	}
	
	//return individual percentage contribution of any field or feature ($value contain value of that fearture)
	function get_individual_percentage_contribution($value)
	{
		$total = ProfilestatusHelper::get_total_of_field_and_other();
		if($total != 0)
			$percentage = ($value/$total)*100;
		else
			$percentage = 0;
		return $percentage;
	}
	
	//return percentage contribution of any field or feature ($value contain value of that fearture) according to profile weightage
	//e.g. :- suppose profile is having weightage of 30 and total weightage of others = 400
	//then % contribution of profile = 30/400*100 = 7.5%
	//now if profile field weightage = 300 then if profile is complete then we will say total status is 7.5 % complete
	//and we do calculation on 7.5
	//300 = 7.5 then 50 = 7.5/300*50 = 1.25
	function get_field_percentage_contribution($value)
	{
		//get value of profile
		$profilevalue = ProfilestatusHelper::get_othervalue_from_key('profile');
		$fieldTotal = ProfilestatusHelper::get_total_fieldvalue();
		//profile % form overall
		if($profilevalue != 0)
			$profilepercent = ProfilestatusHelper::get_individual_percentage_contribution($profilevalue);
		else
			return 0;
		//$total = ProfilestatusHelper::get_total_of_field_and_other();
		$percentage = ($value/$fieldTotal)*$profilepercent;
		return $percentage;
	}
	
	
	//get other value form key ( e.q :- for profile)
	function get_othervalue_from_key($key)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values').' '
				.'WHERE `key`='. $db->Quote($key);
		$db->setQuery( $query );
		$field	= $db->loadObject();
		//print_r($fields);
		if(!empty($field))
			return $field->value;
		else
			return 0;
	}
	
	// return total value count of fields
	function get_total_fieldvalue()
	{
		$fields = ProfilestatusHelper::get_jomsocial_profile_fields();
		$total = 0;
		if(!empty($fields))
		{
			foreach($fields as $field)
			{
				$id = ProfilestatusHelper::get_id_from_fieldId_from_fieldsvalue($field->id);
				$row = ProfilestatusHelper::getfieldvalue($id);
				if(!empty($row->value))
					$total = $total + $row->value;
			}
		}
		return $total;
	}

	// return all rows of other_values table
	function getData()
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values');
		$db->setQuery( $query );
		$fields	= $db->loadObjectList();
		return $fields;
	}
}
?>