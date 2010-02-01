<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class profilefields extends jspcAddons
{

	function __construct($debugMode)
	{
		$this->addonparams = new JParameter('','');
		parent::__construct(__CLASS__, $debugMode);
	}
	
	
	public function getAddonParamsHtml()
	{
		$addonParamsHtml = '';
		require_once dirname(__FILE__).DS.'helper.php';
		
		$filter = array();
		$filter['published'] = 1;
		$fields = helper::getJomsocialProfileFields($filter);
		
		if(empty($fields)) {
			$addonParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
			return $addonParamsHtml;
		}
		
		$fieldsPercentage = array();
		$fieldsPercentageInTotal = array();
			
		$fieldstotal = helper::calculateTotal($this->addonparams,$fields,0);
		$coretotal = $this->coreparams->get('jspc_core_total_contribution',0);
		//$allFeatureTotal = JspcHelper::getAllTotals(true);
		$featureContribution = $this->percentage;//( $coretotal / $coretotal ) * 100;
		
		foreach($fields as $f) {
			if($f->type != 'group') {
				$fieldValue = $this->addonparams->get($f->id,0);
				
				$fieldsPercentage[$f->id] = helper::calculatePercentage($coretotal,$fieldstotal,$fieldValue);
				
				$fieldsPercentageInTotal[$f->id] = helper::calculatePercentage($featureContribution,$fieldstotal,$fieldValue); 
			}
		}
		
		$addonParamsHtml = helper::getFieldsHtml($this->addonparams,$fieldsPercentage,$fieldsPercentageInTotal);
		
		return $addonParamsHtml;
	}
	
	
	
	public function calculateCompletness($userid)
	{
		/*XITODO : Calculate completness according to user profiletype */
		
		$count = $this->get_count_of_profile_fields($userid,'fill');				
		$total = $this->get_count_of_profile_fields($userid,'total');
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
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
		$result = array();
		$result['text']= $this->getDisplayText($userid); //JText::_("ADD ALBUM");
		$result['link']="index.php?option=com_community&view=profile&task=edit&userid=".$userid;
		return $result;
	}
	
	
	public function getRemainingCount($userid)
	{
		$count = $this->get_count_of_profile_fields($userid,'fill');				
		$total = $this->get_count_of_profile_fields($userid,'total');
		
		if(0 == $total)
			return 0;
			
		if($count >= $total)
			return 0;
			
		return ($total - $count);
	}
	
	
	/*Fn will return count of profile fields ( count can be fill or total )
	 * this will store in $what , it wil be 'fill' for getting fillvalue count
	 */
	 
	function get_count_of_profile_fields($userid,$what='fill')
	{
		$profileModel = CFactory::getModel('profile');
		$profile = $profileModel->getEditableProfile($userid);
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
					$value =  $this->addonparams->get($field['id'],0);
					$totalcount = $totalcount + $value;
					
					if($profileModel->_fieldValueExists($field['fieldcode'],$userid))
					{
						$query = 'SELECT value FROM #__community_fields_values' . ' '
						. 'WHERE `field_id`=' .$db->Quote( $field['id'] ) . ' '
						. 'AND `user_id`=' . $db->Quote( $userid );

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
}
