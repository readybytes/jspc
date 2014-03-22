<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class MultiProfile
{
	/*
	 * Get Profile Type Name
	 * @profileTypeId, Profile Id
	 */
	function getProfileTypeName($profileTypeId)
	{
	    $profileTypes		= $this->getProfileTypeIds();
	    $profileTypeName	= $profileTypes[$profileTypeId]->name;
	    
		return $profileTypeName;
	}
	
	/*
	 * return array of all published Profile Type id
	 */
	static function getProfileTypeIds()
	{
		$db 		= JFactory::getDBO();
		$query		= ' SELECT *'
					 .' FROM '.$db->quoteName('#__community_profiles')
					 .' WHERE '.$db->quoteName('published').' = '.$db->Quote(1);
					 
		$db->setQuery( $query );
		$profileTypes	= $db->loadObjectList('id');
		return $profileTypes;
	}
	
	/*
	 * return JomSocial Profile Fields
	 */
	function getJSProfileFields($fieldId=0)
	{
		$db 		= JFactory::getDBO();
		$query		= ' SELECT *'
					 .' FROM '.$db->quoteName('#__community_fields')
					 .' ORDER BY '.$db->quoteName('ordering');
					 
		$db->setQuery( $query );
		$profileFields	= $db->loadObjectList('id');
		return $profileFields;
	}
	
	/*
	 * filter Profile-Type fields according to Profile Type
	 */

	function filterProfileTypeFields(&$fields, $selectedProfiletypeID)
	{
		$db 		= JFactory::getDBO();
		$query		= ' SELECT '.$db->quoteName('field_id')
					 .' FROM '.$db->quoteName('#__community_profiles_fields')
					 .' WHERE '.$db->quoteName('parent').' = '.$db->Quote($selectedProfiletypeID);
					 
		$db->setQuery( $query );
		$profileFields	= $db->loadColumn();
		
		$count = count($fields);
		
		for($i=0 ; $i < $count ; $i++){
			
		    $field =& $fields[$i];
		    
		    if(is_object($field))
		        $fieldId   = $field->id;
		    else
		        $fieldId   = $field['id'];

			if(!in_array($fieldId, $profileFields))
			{
			    unset($fields[$i]);
			    continue;
			}			
		}
		$fields = array_values($fields);
		return true;
	}	
	
	/**
	 * returns user information
	 */
	function getUserInfo($userid)
	{
		$db 		= JFactory::getDBO();
		$query		= ' SELECT '.$db->quoteName('profile_id')
					 .' FROM '.$db->quoteName('#__community_users')
					 .' WHERE '.$db->quoteName('userid').' = '.$db->Quote($userid);
					 
		$db->setQuery( $query );
		$profileType	= $db->loadResult();
		return $profileType;
	}	
	
	static function getProfiletypeInfo($id = 0)
	{
		$profileTypeInfo		= self::getProfileTypeIds();
		
		if(!$id || $id < 0)
			return $profileTypeInfo;
		
		//return specfic array
	    if(isset($profileTypeInfo[$id])){
	        //return always an array
	        $retVal[] = $profileTypeInfo[$id];
	           return $retVal;
	     }

	    // invalid id 
	    return null;
	}
}