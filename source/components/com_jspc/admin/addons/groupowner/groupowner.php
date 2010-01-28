<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class groupowner extends jspcAddons
{
	private $_debugMode;
	private $_name;
	public $addonparams;
	
	function __construct($debugMode)
	{
		$this->_name = __CLASS__;
		//$this->_params = $params ; //create new object everytime for new rule
		$this->_debugMode = $debugMode;
		$xmlpath =  JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_jspc' . DS . 'addons' . DS . $this->_name . DS . $this->_name.'.xml';
		$this->addonparams = new JParameter('',$xmlpath);
	}
	
	
	public function isApplicable($userid)
	{} 
	
	
	public function calculateCompletness($userid)
	{}
	
	
	
	
	
	public function saveParams()
	{}
}