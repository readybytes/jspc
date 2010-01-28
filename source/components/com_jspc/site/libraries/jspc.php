<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php');
require_once (JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jspc'.DS.'includes.jspc.php');

/*Langauge file will be independent now */
$lang =& JFactory::getLanguage();
if($lang) 
	$lang->load( 'com_jspc' );


class JspcLibrary
{
	
	function calulateFillCountOfUser($userid)
	{
		$totalFillFeature = 0;
		/* 
		 * get All published Criteria List and calculate individual fill count
		 * return all published criterial fill count
		 * */
		$filter = array();
		$filter['published'] = 1;
		$allPublishFeature = addonFactory::getAddonsInfo($filter);
		if(empty($allPublishFeature))
			return 100;
			
		foreach($allPublishFeature as $feature) {
			$featureObject = addonFactory::getAddonObject($feature->name);
			
			$binddata = array();
			$binddata['addonparams'] = $feature->addonparams;
			$binddata['coreparams'] = $feature->coreparams;
			$binddata['featurename'] = $feature->featurename;
			$binddata['published'] = $feature->published;
			
			$featureObject->bind($binddata);
			if($featureObject->isApplicable($userid)){
				$fillvalue  = $featureObject->calculateCompletness($userid);
				$totalFillFeature = $totalFillFeature + $fillvalue; 
			}
		}
		
		return $totalFillFeature;
	}
	
	
	function calulateTotalCount($userid)
	{
		$totalFeature = 0;
		/* 
		 * get All published Criteria List and calculate individual fill count
		 * return all published criterial fill count
		 * */
		$filter = array();
		$filter['published'] = 1;
		$allPublishFeature = addonFactory::getAddonsInfo($filter);
		if(empty($allPublishFeature))
			return 100;
			
		foreach($allPublishFeature as $feature) {
			$featureObject = addonFactory::getAddonObject($feature->name);
			
			$binddata = array();
			$binddata['addonparams'] = $feature->addonparams;
			$binddata['coreparams'] = $feature->coreparams;
			$binddata['featurename'] = $feature->featurename;
			$binddata['published'] = $feature->published;
			
			$featureObject->bind($binddata);
			
			if($featureObject->isApplicable($userid)){
				$totalvalue  = $featureObject->getFeatureContribution($userid);
				$totalFeature = $totalFeature + $totalvalue; 
			}
		}
		
		return $totalFeature;
	}
	
	
	//fn will return array of those feature that require to complete to make profile 100 % complete , value should be total count of that feature
	function getIncompleteFeatures($userid)
	{
		$incompleteFeature = array();
		
		$filter = array();
		$filter['published'] = 1;
		$allPublishFeature = addonFactory::getAddonsInfo($filter);
		if(empty($allPublishFeature))
			return $incompleteFeature;

		$totals = self::calculateTotals($userid);
			
		foreach($allPublishFeature as $feature) {
			$featureObject = addonFactory::getAddonObject($feature->name);
			
			$binddata = array();
			$binddata['addonparams'] = $feature->addonparams;
			$binddata['coreparams'] = $feature->coreparams;
			$binddata['featurename'] = $feature->featurename;
			$binddata['published'] = $feature->published;
			
			$featureObject->bind($binddata);
			
			if($featureObject->isApplicable($userid)){
				$fillvalue  = $featureObject->calculateCompletness($userid);
				$totalvalue  = $featureObject->getFeatureContribution($userid);
				
				if($fillvalue != $totalvalue)
						$incompleteFeature[$feature->name] = 100* ($totalvalue - $fillvalue)/$totals;
			}
		}
		
		
		return $incompleteFeature;
	}
	
	
	
	function calculateTotals($userid,$isCheckPublished=true)
	{
		$total = 0;
	
		$filter = array();
		$filter['published'] = 1;
		$allPublishFeature = addonFactory::getAddonsInfo($filter);
		if(empty($allPublishFeature))
			return $total;
			
		foreach($allPublishFeature as $feature) {
			$featureObject = addonFactory::getAddonObject($feature->name);
			
			$binddata = array();
			$binddata['addonparams'] = $feature->addonparams;
			$binddata['coreparams'] = $feature->coreparams;
			$binddata['featurename'] = $feature->featurename;
			$binddata['published'] = $feature->published;
			
			$featureObject->bind($binddata);
			
			if($featureObject->isApplicable($userid))
				$total  = $total + $featureObject->getFeatureContribution($userid);
				
		}
		
		return $total;
	}
	
	
	function getCompletionLink($addonName)
	{
		//assert($addonName);
		$addonObject = addonFactory::getAddonObject($addonName);
		$info  = $addonObject->getCompletionLink();
		return $info;
	}
}