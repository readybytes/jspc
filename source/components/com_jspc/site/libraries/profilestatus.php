<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php');
require_once (JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');

/*Langauge file will be independent now */
$lang =& JFactory::getLanguage();
if($lang) {
	$lang->load( 'com_community_jspt' );
	$lang->load( 'com_profilestatus' );
}
	
/* Also attach style sheet now  */
$document =& JFactory::getDocument();
$css	= JURI::base() . 'components/com_community/templates/default/css/jspt.css';
if($document)
	$document->addStyleSheet($css);
		

class CProfileStatusLibrary
{

	function get_fieldvalue_from_fieldid($fieldId)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_fields_values').' '
				.'WHERE `field_id`='. $db->Quote($fieldId);
		$db->setQuery( $query );
		$field	= $db->loadObject();
		//print_r($fields);
		if(!empty($field->value))
			return $field->value;
		else
			return 0;
	}
	
	function get_other()
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values');
				
		$db->setQuery( $query );
		$fields	= $db->loadObjectList();
		//print_r($fields);
		if(!empty($fields))
			return $fields;
		else
			return 0;
	}
	
	
	function get_other_from_id($id)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values').' '
				.'WHERE `id`='. $db->Quote($id);
		$db->setQuery( $query );
		$field	= $db->loadObject();
		//print_r($fields);
		if(!empty($field))
			return $field;
		else
			return 0;
	}
	
	function get_other_from_key($key)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__profilestatus_other_values').' '
				.'WHERE `key`='. $db->Quote($key);
		$db->setQuery( $query );
		$field	= $db->loadObject();
		//print_r($fields);
		if(!empty($field))
			return $field;
		else
			return "";
	}
	
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
	
	//fn will return the weightage count of feature ($key)
	function get_fillvaluecount_of_other($key,$userId)
	{
		switch($key)
		{
			case 'photo' :
						$pModel =& CFactory::getModel('photos');
						$count = $pModel->getPhotosCount($userId);
						break;
			
			case 'profile' :
						$count = CProfileStatusLibrary::get_count_of_profile_fields($userId,'fill');
						break;
			
			case 'groupowner' :
						$db		=& JFactory::getDBO();
		
						$query	= 'SELECT COUNT(*) FROM ' 
						. $db->nameQuote( '#__community_groups' ) . ' '
						. 'WHERE ' . $db->nameQuote( 'ownerid' ) . '=' . $db->Quote( $userId );
						
						$db->setQuery( $query );
						$count	= $db->loadResult();
						break;
						
			case 'groupmember' :
						$gModel =& CFactory::getModel('groups');
						$count = $gModel->getGroupsCount( $userId );
						break;
			
			case 'video' :
						$db		=& JFactory::getDBO();
						$query  = "SELECT COUNT(*) FROM #__community_videos WHERE published='1' AND status='ready' ";
						$db->setQuery( $query );
						$count = $db->loadResult();
						break;
			
			case 'avatar' :
						$my =& CFactory::getUser();
						$pathofAvatar  =$my->getAvatar();
						if(empty($pathofAvatar) || strpos($pathofAvatar,"default.jpg"))
							$count = 0;
						else
							$count = 1;
						break;
			
			case 'album' :
						$db		=& JFactory::getDBO();
						$query	= 'SELECT COUNT(*) '
						. ' FROM ' . $db->nameQuote( '#__community_photos_albums' )
						. ' WHERE creator=' . $db->Quote( $userId );
				
						$db->setQuery( $query );
						$count = $db->loadResult();
						break;
						
			default :
						assert(0);
		}
		
		return CProfileStatusLibrary::get_weightage_of_feature($key , $count,$userId);
	}
	
	//fn will retrun individual weightage of any featur like 3 group required for 400 weightage and 2 is complete then this will retrun (400/3)*2
	function get_weightage_of_feature($key , $count,$userId)
	{
		$field = CProfileStatusLibrary::get_other_from_key($key);
		if($key != 'avatar' && $key != 'profile')
		{
			if(!empty($field))
			{
				if($count >= $field->total)
				{
					return $field->value;
				}
				else
				{
					$singleWeightage = $field->value / $field->total ;
					$weightage = $count * $singleWeightage;
					return $weightage;
				}
			}
			else
				return 0;
		}
		else if($key == 'avatar')
		{
			if($count == 1 && !empty($field->value))
				return $field->value;
			else
				return 0;
		}
		else if($key == 'profile')
		{
			$totalfieldcount = CProfileStatusLibrary::get_count_of_profile_fields($userId,'total');
			if($totalfieldcount == 0)
					return $field->value;
					
			if($count < $totalfieldcount)
			{
				$othertotal = CProfileStatusLibrary::get_totalvalue_of_other();
				if($othertotal == 0)
					return 0;
					
				$weightage = ($count/$totalfieldcount)*$field->value;
				
				return $weightage;
			}
			else
				return $field->value;
		}else
			assert(0);
	}
	
	//fn will return total fill value of other not empty or total
	function get_fill_weightage_count_of_other($userId)
	{
		$fillValue = 0;
		$otherfields = CProfileStatusLibrary::get_other();
		if(!empty($otherfields))
		{
			foreach($otherfields as $otherfield)
			{
				$value = CProfileStatusLibrary::get_fillvaluecount_of_other($otherfield->key,$userId);
				$fillValue = $fillValue + $value;
			}
		}
		return $fillValue;
	}
	
	//Fn will return count of profile fields ( count can be fill or total )
	// this will store in $what , it wil be 'fill' for getting fillvalue count
	function get_count_of_profile_fields($userId,$what)
	{
		$profileModel = CFactory::getModel('profile');
		$profile = $profileModel->getEditableProfile($userId);
		$fields = new stdClass();
		$fields = $profile['fields'];
		$db		=& JFactory::getDBO();
		$totalcount = 0; 
		$fillcount = 0; 
		
		if(!empty($fields))
		{
			foreach($fields as $name => $fieldGroup)
			{
				foreach($fieldGroup as $field)
				{
					$value = CProfileStatusLibrary::get_fieldvalue_from_fieldid($field['id']);
					$totalcount = $totalcount + $value;
					
					if($profileModel->_fieldValueExists($field['fieldcode'],$userId))
					{
						$query = 'SELECT value FROM #__community_fields_values' . ' '
						. 'WHERE `field_id`=' .$db->Quote( $field['id'] ) . ' '
						. 'AND `user_id`=' . $db->Quote( $userId );

						$db->setQuery( $query );
						if($db->getErrorNum()) {
							JError::raiseError( 500, $db->stderr());
						}

						$result = $db->loadResult();
						
						if(!empty($result))
							$fillcount = $fillcount + $value;
					}
				}
			}
		}
		
		if($what == 'total')
			return $totalcount;
		else if($what == 'fill')
			return $fillcount;
		else
			assert(0);
	}
	
	
	function check_jspt_existance()
	{
		$jspt_admin = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_jsprofiletypes';
		$jspt_front = JPATH_ROOT . DS . 'components' . DS . 'com_jsprofiletypes';
		
		if(!is_dir($jspt_admin))
			return false;
		
		if(!is_dir($jspt_front))
			return false;
		
		return true;
	}
	
	
	//fn will return array of those feature that require to complete to make profile 100 % complete , value should be total count of that feature
	function get_incomplete_feature_array($userId)
	{
		$incomplete_feature = array();
		$otherfields = CProfileStatusLibrary::get_other();
		if(!empty($otherfields))
		{
			$totalOther =  CProfileStatusLibrary::get_totalvalue_of_other();
			foreach($otherfields as $otherfield)
			{
					$fillValue = CProfileStatusLibrary::get_fillvaluecount_of_other($otherfield->key,$userId);
					if($fillValue != $otherfield->value)
						$incomplete_feature[$otherfield->key] = 100* $otherfield->value/$totalOther;
			}
		}
		
		return $incomplete_feature;
	}
	
function getCompletionLink($key)
	{
		$result = array();
		switch($key)
		{
			case 'photo' 		:
				$result[]=JText::_("ADD PHOTOS");
				$result[]="index.php?option=com_community&view=photos&task=uploader";
				break;	
			case 'profile' 		:	
				$result[]=JText::_("EDIT PROFILE");
				$result[]="index.php?option=com_community&view=profile&task=edit";
				break;	
			case 'groupowner'	:
				$result[]=JText::_("CREATE GROUP");
				$result[]="index.php?option=com_community&view=groups&task=create";
				break;	
			case 'groupmember' 	:
				$result[]=JText::_("JOIN GROUPS");
				$result[]="index.php?option=com_community&view=groups";
				break;	
			case 'video' 		:
				$result[]=JText::_("ADD VIDEOS");
				$result[]="index.php?option=com_community&view=videos&task=myvideos";
				break;	
			case 'avatar'		:	
				$result[]=JText::_("CHANGE AVATAR");
				$result[]="index.php?option=com_community&view=profile&task=uploadAvatar";
				break;			
			case 'album' 		:
				$result[]=JText::_("ADD ALBUM");
				$result[]="index.php?option=com_community&view=photos&task=newalbum";
				break;	
			default :
				assert(0);
		}
		return $result;
	}
}