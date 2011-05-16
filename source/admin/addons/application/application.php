<?php
defined('_JEXEC') or die('Restricted access');
class application extends jspcAddons
{
	function __construct($debugMode)
	{
		parent::__construct(__CLASS__,$debugMode);
	}
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid);
		$result['link']=CRoute::_('index.php?option=com_community&view=apps');
		return $result;
	}
	
	public function calculateCount($userid)
	{
		$db		= JFactory::getDBO();	

	    $query='SELECT COUNT(*) '
		. ' FROM ' . $db->nameQuote( '#__community_apps' )
		. ' WHERE '. $db->nameQuote('userid').'=' . $db->Quote( $userid );	
		$db->setQuery($query);
		$count=$db->loadResult();

		return $count;
	}
}