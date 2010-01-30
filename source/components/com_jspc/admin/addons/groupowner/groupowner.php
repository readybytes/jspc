<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class groupowner extends jspcAddons
{
	
	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	public function calculateCompletness($userid)
	{
		$count = $this->calculateCount($userid);			
		$total = $this->addonparams->get('groupowner_total',0);
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user group creator count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}				
	}
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid); //JText::_("CREATE GROUP");
		$result['link']="index.php?option=com_community&view=groups&task=create";
		return $result;
	}
	
	
	public function getRemainingCount($userid)
	{
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->get('groupowner_total',0);
		
		if(0 == $total)
			return 0;
			
		if($count >= $total)
			return 0;
			
		return ($total - $count);
	}
	
	
	public function calculateCount($userid)
	{
		$db		=& JFactory::getDBO();
		
		$query	= 'SELECT COUNT(*) FROM ' 
		. $db->nameQuote( '#__community_groups' ) . ' '
		. 'WHERE ' . $db->nameQuote( 'ownerid' ) . '=' . $db->Quote( $userid );
		
		$db->setQuery( $query );
		$count	= $db->loadResult();
		return $count;
	}
}