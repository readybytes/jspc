<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcFriends extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	function getCompletionLink($userid)
	{
		$result 		= array();
		$result['text']	= $this->getDisplayText($userid);
		$result['link']	= CRoute::_('index.php?option=com_community&view=search&task=browse');
		return $result;
	}
	
	public function calculateCount($userid)
	{
		$db		= JFactory::getDBO();
		$query	= 'SELECT COUNT(*) '
				. ' FROM ' . $db->quoteName( '#__community_connection' )
				. ' WHERE `connect_from`=' . $db->Quote( $userid ) 
				. ' AND `status`=1';

		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
}
