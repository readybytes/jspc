<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcArticles extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	function getCompletionLink($userid)
	{
		$result 		= array();
		$result['text'] = $this->getDisplayText($userid); 
		$result['link']	= JRoute::_('index.php?option=com_content&view=article&layout=form',false);
		return $result;
	}

	public function calculateCount($userid)
	{
		$db		= JFactory::getDBO();
		$query	= 'SELECT COUNT(*) '
				. ' FROM ' . $db->quoteName( '#__content' )
				. ' WHERE created_by=' . $db->Quote( $userid );

		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
}
