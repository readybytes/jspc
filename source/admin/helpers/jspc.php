<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
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
		
		/*$featureObject = addonFactory::getAddonObject($info[0]->name);
		assert($featureObject);
		
		$featureObject->bind($info[0]);
		$total = $featureObject->getFeatureContribution(0);*/
		
		$total = addonFactory::getValueFromParams('jspc_core_total_contribution',$info[0]->coreparams,0);
		return $total;
	}
	
	
	
	function getAllTotals($isCheckPublished=true, $profilesExist=false)
	{
		$total = $profilesExist ? array() : 0 ;
		
		$addonsinfo = addonFactory::getAddonsInfo();		
		if(empty($addonsinfo))
			return $total;
			
		foreach($addonsinfo as $info) 
		{
			if($isCheckPublished==false)
				continue;
				
			if($info->published == false)
				continue;
				
			/*$featureObject = addonFactory::getAddonObject($info->name);
			assert($featureObject);
			
			$featureObject->bind($info);
			$contribution = $featureObject->getFeatureContribution(0);*/

			$contribution = addonFactory::getValueFromParams('jspc_core_total_contribution',$info->coreparams,0);
			
			if($profilesExist == false)
			{
				$total = $total + $contribution;	
				continue;
			}
			
			$integrate_with = addonFactory::getValueFromParams('integrate_with',$info->coreparams,"jspt");
			
			if($integrate_with == "jspt"){
				$ptype 			  = addonFactory::getValueFromParams('jspc_profiletype',$info->coreparams,0);
				$profileTypeArray = XiptAPI::getProfiletypeInfo();
			}
			else{
				$ptype 			  = addonFactory::getValueFromParams('jspc_multiprofile',$info->coreparams,0);
				$profileTypeArray = MultiProfile::getProfiletypeInfo();
			}
			
			if($ptype)
			{
				if(array_key_exists($ptype, $total)==false)
				$total[$ptype] = 0;
				
				$total[$ptype] = $total[$ptype] + $contribution;
				continue;
			}			
				
			foreach($profileTypeArray as $ptypeId)
			{
				$id=$ptypeId->id;
				if(array_key_exists($id, $total)==false)
				$total[$id] = 0;
				
				$total[$id] = $total[$id] + $contribution;
			}
		}
		return $total;
}

//XITODO : Move to helper file
	function checkXiptExists()
	{
		jimport( 'joomla.filesystem.file' );
		jimport( 'joomla.filesystem.folder' );

		$xiptPath = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt';
		
		if(!JFolder::exists($xiptPath))
			return false;

		$xiptPath = JPATH_ROOT.DS.'components'.DS.'com_xipt';

		if(!JFolder::exists($xiptPath))
			return false;

		require_once(JPATH_ROOT.DS. 'components' .DS. 'com_xipt' . DS . 'api.xipt.php' );
		//require_once(JPATH_ROOT.DS. 'components' .DS. 'com_xipt' . DS . 'libraries' . DS . 'profiletypes.php' );

		return true;
	}
	
//XITODO : Move to helper file
	function checkMultiProfileExists()
	{
		$result  = MultiProfile::getProfileTypeIds();
		
		if(empty($result))
			return false;
			
		return true;
	}
	
}
