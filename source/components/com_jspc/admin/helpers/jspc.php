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
	
	
	
	function getAllTotals($isCheckPublished=true, $isXiptExist=false)
	{
		$total = $isXiptExist ? array() : 0 ;
		
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
			
			if($isXiptExist == false)
			{
				$total = $total + $contribution;	
				continue;
			}
			
			$ptype = addonFactory::getValueFromParams('jspc_profiletype',$info->coreparams,0);
			if($ptype)
			{
				if(array_key_exists($ptype, $total)==false)
				$total[$ptype] = 0;
				
				$total[$ptype] = $total[$ptype] + $contribution;
				continue;
			}	
				
			$profileTypeArray=XiPTHelperProfiletypes::getProfiletypeArray();
				
			foreach($profileTypeArray as $ptypeId)
			{
				if(array_key_exists($ptypeId, $total)==false)
				$total[$ptypeId] = 0;
				
				$total[$ptypeId] = $total[$ptypeId] + $contribution;
			}
		}
		return $total;
}

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

		require_once(JPATH_ROOT.DS. 'administrator' .DS. 'components' .DS. 'com_xipt' . DS . 'helpers' . DS . 'profiletypes.php' );
		require_once(JPATH_ROOT.DS. 'components' .DS. 'com_xipt' . DS . 'libraries' . DS . 'profiletypes.php' );

		return true;
	}
	
}
