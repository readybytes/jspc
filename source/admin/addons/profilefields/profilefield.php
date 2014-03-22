<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require JPATH_ADMINISTRATOR.'/components/com_jspc/addons/profilefields/helper.php';

class JFormFieldProfilefield extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'Profilefield';

	public function getInput()
	{
		$addonParamsHtml 	= '';
		
		$itemId				= JFactory::getApplication()->input->get('editId', 0);	
		$this->coreparams	= '';
		$this->addonparams	= '';
		if($itemId){
			$data	= addonFactory::getAddonsInfo(array('id' => $itemId));
			if($data) {
				$this->coreparams	= (array)json_decode($data[0]->coreparams);
				$this->addonparams	= (array)json_decode($data[0]->addonparams);
			}
		}
		
		$filter 			 = array();
		$filter['published'] = 1;
		$fields 			 = JspcProfileFieldHelper::getJomsocialProfileFields($this->coreparams, $this->addonparams, $filter);
		
		if(empty($fields)) {
			$addonParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".JspcText::_('CLICK_ON_APPLY_BUTTON_TO_SEE_THE_ADDONS_PARAMETERS')."</div>";
			return $addonParamsHtml;
		}
		
		$fieldsPercentage        = array();
		$fieldsPercentageInTotal = array();
			
		$fieldstotal			 = JspcProfileFieldHelper::calculateTotal($this->addonparams,$fields,0);
		$coretotal   			 = addonFactory::getValueFromParams('jspc_core_total_contribution', $this->coreparams, 0);
		
		//calculate percentage
		$total 				 	= JspcHelper::getAllTotals(true);
		$featureContribution 	= 0;
		
		if($total != 0){
			$featureContribution = ($coretotal / $total ) * 100;
		}
		else {
			$featureContribution = 100;
		}
			
		foreach($fields as $field) {
			if($field->type != 'group') {
				$fieldValue = addonFactory::getValueFromParams($field->id, $this->addonparams, 0);
				
				$fieldsPercentage[$field->id]        = JspcProfileFieldHelper::calculatePercentage($coretotal,$fieldstotal,$fieldValue);
				$fieldsPercentageInTotal[$field->id] = JspcProfileFieldHelper::calculatePercentage($featureContribution,$fieldstotal,$fieldValue); 
			}
		}
	
		$addonParamsHtml = JspcProfileFieldHelper::getFieldsHtml($this->coreparams, $this->addonparams,$fieldsPercentage,$fieldsPercentageInTotal);
		
		return $addonParamsHtml;
	}	
}