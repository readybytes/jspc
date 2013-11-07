<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcProfilefields extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	public function calculateCompletness($userid)
	{
		/*XITODO : Calculate completness according to user profiletype */
		
		$count = $this->get_count_of_profile_fields($userid,'fill');				
		$total = $this->get_count_of_profile_fields($userid,'total');
		$contribution = $this->getCoreParams('jspc_core_total_contribution',0);
		
		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user album count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}				
	}
	
	function getCompletionLink($userid)
	{
		$result 		= array();
		$result['text'] = $this->getDisplayText($userid);
		$result['link'] = CRoute::_('index.php?option=com_community&view=profile&task=edit&userid='.$userid, false);
		return $result;
	}
	
	public function getRemainingCount($userid)
	{
		$count = $this->get_count_of_profile_fields($userid,'empty');
		return $count;				
	}
	
	/*Fn will return count of profile fields ( count can be fill or total )
	 * this will store in $what , it wil be 'fill' for getting fillvalue count
	 */
	function get_count_of_profile_fields($userid,$what='fill')
	{
		$profileModel = CFactory::getModel('profile');
		$profile 	  = $profileModel->getEditableProfile($userid);
		
		$fields 	= new stdClass();
		$fields 	= $profile['fields'];
		$db		    = JFactory::getDBO();
		$totalcount = 0; 
		$fillcount  = 0; 
		$empty 		= 0;
		
		if(!empty($fields))
		{
			foreach($fields as $name => $fieldGroup)
			{
				foreach($fieldGroup as $field)
				{
					$value 		= addonFactory::getValueFromParams($field['id'], $this->addonparams, 0); 
					$totalcount = $totalcount + $value;
					
					if($profileModel->_fieldValueExists($field['fieldcode'],$userid))
					{
						$query = ' SELECT value FROM #__community_fields_values '
								. ' WHERE `field_id`= ' . $db->Quote( $field['id'] )
								. ' AND `user_id`= ' . $db->Quote( $userid );

						$db->setQuery( $query );
						if($db->getErrorNum()) {
							JError::raiseError( 500, $db->stderr());
						}

						$result = $db->loadResult();
						
						if(!empty($result))
							$fillcount = $fillcount + $value;
						elseif($value)
							$empty++;
					}
					elseif($value)
							$empty++;
				}
			}
		}
		
		if($what === 'total')
			return $totalcount;
		elseif($what === 'fill')
			return $fillcount;
		elseif($what === 'empty')
			return $empty;
		else
			assert(0);
		
		return $fillcount;
	}
}
