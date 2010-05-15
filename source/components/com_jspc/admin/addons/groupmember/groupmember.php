<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class groupmember extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	
	
	
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid); // JText::_("JOIN GROUPS");
		$result['link']=CRoute::_('index.php?option=com_community&view=groups');
		return $result;
	}
	
	
	
	
	
	public function calculateCount($userid)
	{
		$gModel =& CFactory::getModel('groups');
		$count = $gModel->getGroupsCount( $userid );
		return $count;
	}
}
