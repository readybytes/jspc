<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class articles extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid); 
		$result['link']="index.php?option=com_content&view=article&layout=form";
		return $result;
	}

	public function calculateCount($userid)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT COUNT(*) '
		. ' FROM ' . $db->nameQuote( '#__content' )
		. ' WHERE created_by=' . $db->Quote( $userid );

		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
}
