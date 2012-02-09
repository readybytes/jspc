<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcVideos extends jspcAddons
{
	
	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	function getCompletionLink($userid)
	{
		$result 		= array();
		$result['text'] = $this->getDisplayText($userid);
		$result['link'] = CRoute::_('index.php?option=com_community&view=videos&task=myvideos');
		return $result;
	}
	
	public function calculateCount($userid)
	{
		$db		= JFactory::getDBO();
		
		$query  = 'SELECT COUNT(*) '
				.' FROM #__community_videos '
				.' WHERE `creator`= '.$userid
				." AND `published`='1' AND `status`='ready' ";
				
		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
}
