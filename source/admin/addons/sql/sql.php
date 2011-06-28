<?php
defined('_JEXEC') or die('Restricted access');

class JspcSql extends jspcAddons
{
function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid);
		//enter the link
		$link = $this->addonparams->get('sql_url','');
		$result['link']=JRoute::_($link);
		return $result;
	}
	
	public function calculateCount($userid)
	
	{
		$db		= JFactory::getDBO();
		
		$query = $this->addonparams->get('sql_query','');
		if($query == '')
			return false;
			
		$query = JString::str_ireplace('<<userid>>', $userid, $query);

		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
}