<?php
defined('_JEXEC') or die('Restricted access');
class events extends jspcAddons
{
	function __construct($debugMode)
	{
	  parent::__construct(__CLASS__,$debugMode);
	}
	
	function getCompletionLink($userid)
	{
    	$result = array();
		$result['text']= $this->getDisplayText($userid);
		$result['link']=CRoute::_('index.php?option=com_community&view=events&task=myevents');
		return $result;
	}
	
	public function calculateCount($userid)
	{
	   $db= JFactory::getDBO();
	   $query='SELECT COUNT(*) '
		. ' FROM ' . $db->nameQuote( '#__community_events' )
		. ' WHERE '. $db->nameQuote('creator').'=' . $db->Quote( $userid );	
		$db->setQuery($query);
		$count=$db->loadResult();
		
		return $count;
	}
}