<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class albums extends jspcAddons
{
	private $_debugMode;
	private $_name;
	public $addonparams;
	
	function __construct($debugMode)
	{
		$this->_name = __CLASS__;
		//$this->_params = $params ; //create new object everytime for new rule
		$this->_debugMode = $debugMode;
		$xmlpath = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_jspc' . DS . 'addons' . DS . $this->_name . DS . $this->_name.'.xml';
		$this->addonparams = new JParameter('',$xmlpath);
	}
	
	
	public function calculateCompletness($userid)
	{
		$count = $this->calculateCount($userid);				
		$total = $this->addonparams->get('album_total',0);
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user album count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}				
	}
	
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid); //JText::_("ADD ALBUM");
		$result['link']="index.php?option=com_community&view=photos&task=newalbum";
		return $result;
	}
	
	
	public function getRemainingCount($userid)
	{
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->get('album_total',0);
		
		if(0 == $total)
			return 0;
			
		if($count >= $total)
			return 0;
			
		return ($total - $count);
	}
	
	
	public function calculateCount($userid)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT COUNT(*) '
		. ' FROM ' . $db->nameQuote( '#__community_photos_albums' )
		. ' WHERE creator=' . $db->Quote( $userid );

		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
}