<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class groupmember extends jspcAddons
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
		$gModel =& CFactory::getModel('groups');
		$count = $gModel->getGroupsCount( $userid );
						
		$total = $this->addonparams->get('groupmember_total',0);
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user group member count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}				
	}
	
	
	function getCompletionLink()
	{
		$result = array();
		$result['text']=JText::_("JOIN GROUPS");
		$result['link']="index.php?option=com_community&view=groups";
		return $result;
	}
}
