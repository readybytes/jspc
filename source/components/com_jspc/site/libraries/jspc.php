<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

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
			$featureObject = JspcLibrary::getFeatureIDAddonObject($feature->id);
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
			$featureObject = JspcLibrary::getFeatureIDAddonObject($feature->id);
			if($featureObject->isApplicable($userid)){
				$totalvalue  = $featureObject->getFeatureContribution($userid);
				$totalFeature = $totalFeature + $totalvalue; 
			}
		}
		
		return $totalFeature;
	}
	
	function calculateFeatureContributionInPercentage($userid)
	{
		$total = self::calulateTotalCount($userid);
		$featureContribution = JspcHelper::getTotalContributionOfCriteria($this->id);
		$percentage = ( $featureContribution / $total ) * 100 ;
		return $percentage;
	}
	
	
	//fn will return array of those feature that require to complete 
	// to make profile 100 % complete , value should be total count of that feature
	function getIncompleteFeatures($userid)
	{
		$incompleteFeature = array();
		
		$filter = array();
		$filter['published'] = 1;
		$allPublishFeature = addonFactory::getAddonsInfo($filter);
		if(empty($allPublishFeature))
			return $incompleteFeature;

		$totals = self::calulateTotalCount($userid,true);
			
		foreach($allPublishFeature as $feature) 
		{
			$featureObject = self::getFeatureIDAddonObject($feature->id);
			
			if($featureObject->isApplicable($userid)){
				$fillvalue  = $featureObject->calculateCompletness($userid);
				$totalvalue  = $featureObject->getFeatureContribution($userid);
				
				if($fillvalue != $totalvalue)
						$incompleteFeature[$feature->id] = 100* ($totalvalue - $fillvalue)/$totals;
			}
		}
		
		arsort($incompleteFeature);
		return $incompleteFeature;
	}
	
	/*
	 * This allow you to call any function on any particular object
	 */
	function callAddonFunction($featureid, $functionName, $userid)
	{
		$featureObject = self::getFeatureIDAddonObject($featureid);
		
		//we need to change these things
		//XITODO : and also add error handling routines
		return  $featureObject->$functionName($userid);
	}
	

	function getDisplayInformationOfUser($userid,$whichAvatar='thumb')
	{
		
		jimport( 'joomla.filesystem.folder' );
		$communityPath = JPATH_ROOT.DS.DS.'components'.DS.'com_community';

		if(!JFolder::exists($communityPath)) {
			JError::raiseError(JText::_("UNABLE TO GET INFORMATION"));
			return;
		}
		
		//community files
		require_once(JPATH_ROOT.DS.'components'.DS.'com_community' . DS . 'libraries' . DS . 'core.php' );
	
		$user =& CFactory::getUser($userid);		

		$info = array();
		$info['userlink']	= CRoute::_('index.php?option=com_community&view=profile&userid='.$user->_userid);
		$info['name']		= $user->getDisplayName();
		$info['avatar']		= $user->getThumbAvatar();
		if($whichAvatar === 'avatar')
			$info['avatar']		= $user->getAvatar();
		
		return $info;
	}
	
	function calulatePCPercentage($userId)
	{
		$fillValue = JspcLibrary::calulateFillCountOfUser($userId);
		$totalValue = JspcLibrary::calulateTotalCount($userId);
		
		if($totalValue == 0)
			$profile_completion_percentage = 100;
		else
			$profile_completion_percentage = ($fillValue/$totalValue)*100;
			
		$profile_completion_percentage = round($profile_completion_percentage,1	);
		return $profile_completion_percentage;
	}
	
	function roundOffPercentage(&$featureData, $pcPercentage)
	{
		$total =  100 - $pcPercentage;
		foreach($featureData as $key => $value)
		{
			$value	= round($value,1);
			
			if($value > $total)
				$value = $total;

			$total -= $value;
			$featureData[$key]=$value;
		}
	}
	
	function getFeatureIDAddonObject($featureId)
	{
		//find the params of object
		$filter = array();
		$filter['published'] = 1;
		$filter['id'] = $featureId;
		$feature = addonFactory::getAddonsInfo($filter);
		
		//if feature is not available OR unpublished
		assert($feature);
		
		$featureObject = addonFactory::getAddonObject($feature[0]->name);
		assert($featureObject);
		
		$featureObject->load($featureId);
		return $featureObject; 
	}
}
