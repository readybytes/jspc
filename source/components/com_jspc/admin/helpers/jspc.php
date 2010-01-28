<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcHelper 
{

	function getTotalContributionOfCriteria($criteriaID,$isCheckPublished=false)
	{
		$filter = array();
		$filter['id'] = $criteriaID;
		$info = addonFactory::getAddonsInfo($filter);
		if(!$info)
			return 0;
			
		if($isCheckPublished 
			&& !$info[0]->published)
			return 0;
		
		$total = addonFactory::getValueFromParams('jspc_core_total_contribution',$info[0]->coreparams,0);
		return $total;
	}
	
	
	function getAllTotals($isCheckPublished=true)
	{
		$total = 0;
		$addonsinfo = addonFactory::getAddonsInfo();
		if(empty($addonsinfo))
			return $total;
			
		foreach($addonsinfo as $info) {
			if($isCheckPublished && $info->published) {
			
				//add value into total contribution
				$value = addonFactory::getValueFromParams('jspc_core_total_contribution',$info->coreparams,0);				
				$total = $total + $value;
			}
		}
		
		return $total;
	}
	
}
?>