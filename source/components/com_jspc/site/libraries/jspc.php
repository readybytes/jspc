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
			$featureObject = addonFactory::getAddonObject($feature->name);
			
			$binddata = array();
			$binddata['addonparams'] = $feature->addonparams;
			$binddata['coreparams'] = $feature->coreparams;
			$binddata['featurename'] = $feature->featurename;
			$binddata['published'] = $feature->published;
			$binddata['percentage'] = self::calculateFeatureContributionInPercentage($feature->id,$userid);
			
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

		$totals = self::calulateTotalCount($userid,true);
			
		foreach($allPublishFeature as $feature) {
			$featureObject = addonFactory::getAddonObject($feature->name);
			
			$binddata = array();
			$binddata['addonparams'] = $feature->addonparams;
			$binddata['coreparams'] = $feature->coreparams;
			$binddata['featurename'] = $feature->featurename;
			$binddata['published'] = $feature->published;
			$binddata['percentage'] = self::calculateFeatureContributionInPercentage($feature->id,$userid);
			
			$featureObject->bind($binddata);
			
			if($featureObject->isApplicable($userid)){
				$fillvalue  = $featureObject->calculateCompletness($userid);
				$totalvalue  = $featureObject->getFeatureContribution($userid);
				
				if($fillvalue != $totalvalue)
						$incompleteFeature[$feature->id] = 100* ($totalvalue - $fillvalue)/$totals;
			}
		}
		
		
		return $incompleteFeature;
	}
	
	
	
	function getCompletionLink($featureid,$userid)
	{
		$filter = array();
		$filter['published'] = 1;
		$filter['id'] = $featureid;
		$featureInfo = addonFactory::getAddonsInfo($filter);
		
		
		if(empty($featureInfo)) {
			$info = array();
			$info['text'] = '';
			$info['link'] = '';
			return $info;
		}
		
		$addonObject = addonFactory::getAddonObject($featureInfo[0]->name);
		$info  = $addonObject->getCompletionLink($userid);
		return $info;
	}
	
	
	function calculateFeatureContributionInPercentage($featureid,$userid)
	{
		$total = self::calulateTotalCount($userid);
		$featureContribution = JspcHelper::getTotalContributionOfCriteria($featureid);
		$percentage = ( $featureContribution / $total ) * 100 ;
		return $percentage;
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
	
		
		$info = array();
		$user =& CFactory::getUser($userid);
		$info['userlink']	= CRoute::_('index.php?option=com_community&view=profile&userid='.$user->_userid);
		$info['name']		= $user->getDisplayName();
		$info['avatar']		= $user->getThumbAvatar();
		if($whichAvatar === 'avatar')
			$info['avatar']		= $user->getAvatar();
		
		return $info;
	}
}