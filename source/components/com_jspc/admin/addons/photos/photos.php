<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class photos extends jspcAddons
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
	
	/* 
	 * $debugMode will contain debug session parameter
	 * $addonInfo will contain row (id and params) as key value pair
	 * Function will return instance of individual rule 
	 * */
	static function getInstance($debugMode,$addonInfo)
	{	
		//$instance will comtain all addon object according to rule
		//Every rule will have different object
		static $instance = array();
		if(isset($instance[$addonInfo->id]))
			return $instance[$params->id];
			
		$instance[$params->id] = new photos($debugMode,$params);	
		return $instance[$params->id];
	}
	
	
	public function isApplicable($userid)
	{} 
	
	
	public function calculateCompletness($userid)
	{}
	
	
	public function saveParams()
	{}
}