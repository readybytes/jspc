<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class videos extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	
	public function calculateCompletness($userid)
	{	
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->get('video_total',0);
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user videos count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}				
	}
	
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid); //JText::_("ADD VIDEOS");
		$result['link']="index.php?option=com_community&view=videos&task=myvideos";
		return $result;
	}
	
	
	public function getRemainingCount($userid)
	{
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->get('video_total',0);
		
		if(0 == $total)
			return 0;
			
		if($count >= $total)
			return 0;
			
		return ($total - $count);
	}
	
	
	public function calculateCount($userid)
	{
		$db		=& JFactory::getDBO();
		
		$query  = "SELECT COUNT(*) FROM #__community_videos WHERE `creator`=".$userid." AND `published`='1' AND `status`='ready' ";
		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
}