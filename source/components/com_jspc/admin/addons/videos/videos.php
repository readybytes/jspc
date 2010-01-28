<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class videos extends jspcAddons
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
		$db		=& JFactory::getDBO();
		
		$query  = "SELECT COUNT(*) FROM #__community_videos WHERE `creator`=".$userid." AND `published`='1' AND `status`='ready' ";
		$db->setQuery( $query );
		$count = $db->loadResult();
		
		$total = $this->addonparams->get('video_total',0);
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user videos count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}				
	}
	
	
	function getCompletionLink()
	{
		$result = array();
		$result['text']=JText::_("ADD VIDEOS");
		$result['link']="index.php?option=com_community&view=videos&task=myvideos";
		return $result;
	}
}