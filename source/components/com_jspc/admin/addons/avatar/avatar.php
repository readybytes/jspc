<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class avatar extends jspcAddons
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
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
		if($count >= 1)
			return $contribution;
		else 
			return 0;		
	}
	
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']=$this->getDisplayText($userid); //JText::_("CHANGE AVATAR");
		$result['link']="index.php?option=com_community&view=profile&task=uploadAvatar";
		return $result;
	}
	
	
	public function getRemainingCount($userid)
	{
		$count = $this->calculateCount($userid);
		
		//count == 1 means no need to change avatar
		//so remainig is 0
		if($count)
			return 0;
		
		return 1;
	}
	
	
	public function calculateCount($userid)
	{
		$my =& CFactory::getUser($userid);
		$pathofAvatar  =$my->getAvatar();
		$count = 0;
		if(!empty($pathofAvatar) || strpos($pathofAvatar,"default.jpg"))
			$count = 1;
			
		return $count;
	}
}