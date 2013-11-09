<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.filesystem.folder' );

if(!JFolder::exists(JPATH_ROOT.'/components/com_xipt'))
  return;

require_once JPATH_ROOT.'/components/com_xipt/api.xipt.php';

class XiptWrapper
{
	/*
	 * Get Profile Type Name
	 * @profileTypeId, Profile Id
	 */
	function getProfileTypeName($profileTypeId)
	{
	    if(method_exists('XiptAPI','getProfileTypeName'))
			return XiptAPI::getProfileTypeName($profileTypeId);
		
		return XiPTLibraryProfiletypes::getProfiletypeName($profileTypeId);
	}
	
	/*
	 * return array of all published Profile Type id
	 * @filter, use for filter Profile Type 
	 */
	function getProfileTypeIds($filter= '')
	{
		if(method_exists('XiptAPI', 'getProfileTypeIds'))
				return XiptAPI::getProfileTypeIds($filter);
		
		return XiPTLibraryProfiletypes::getProfiletypeArray($filter);
	}
	
	/*
	 * return JomSocial Profile Fields
	 */
	function getJSProfileFields($fieldId=0)
	{
		if(method_exists('XiptAPI','getJSProfileFields'))
				return XiptAPI::getJSProfileFields($fieldId);
		
		return XiPTHelperProfileFields::get_jomsocial_profile_fields($fieldId);
	}
	
	/*
	 * filter Profile-Type fields according to Profile Type
	 */

	function filterProfileTypeFields(&$fields, $selectedProfiletypeID, $from)
	{
		if(method_exists('XiptAPI','filterProfileTypeFields'))
				return XiptAPI::filterProfileTypeFields($fields, $selectedProfiletypeID, $from);

		return XiPTLibraryProfiletypes::_getFieldsForProfiletype($fields, $selectedProfiletypeID, $from);
	}	
	
	/**
	 * returns user information
	 * @param $userid : 
	 * @param $what : can be 'PROFILETYPE' or 'TEMPLATE'
	 * @return user information
	 */
	function getUserInfo($userid, $what='PROFILETYPE')
	{
		if(method_exists('XiptAPI' ,'getUserInfo'))
				return XiptAPI::getUserInfo($userid,$what);

		return XiPTLibraryProfiletypes::getUserData($userid,$what);	
	}	
	
	function getProfiletypeInfo($id=0, $filter=array())
	{
		return XiptAPI::getProfiletypeInfo($id,$filter);
	}
}