<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcAvatar extends jspcAddons
{
	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	public function calculateCompletness($userid)
	{	
		$count 		  = $this->calculateCount($userid);		
		$contribution = $this->getCoreParams('jspc_core_total_contribution',0);
		
		if($count >= 1)
			return $contribution;
		else 
			return 0;		
	}
	
	function getCompletionLink($userid)
	{
		$result 		= array();
		$result['text'] = $this->getDisplayText($userid);
		$result['link'] = CRoute::_('index.php?option=com_community&view=profile&task=uploadAvatar');
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
		$user		 	= CFactory::getUser($userid);		
		$userAvatar  	= $user->_avatar;
		$count 		 	= 0;
		$integrate_with = $this->getCoreParams('integrate_with', 'jspt');
		
		if(JspcHelper::checkXiptExists() && $integrate_with == 'jspt')
		{
	    	$ptypeavatar = $this->getPtypeAvatar($userid);
	    		
	    	if(!empty($userAvatar) && !JString::stristr($userAvatar,$ptypeavatar))  
	    		$count = 1;
	    }
	    elseif(JspcHelper::checkMultiProfileExists() && $integrate_with == 'multiprofile')
	    {
	    	$ptypeavatar = $this->getmultiProfileAvatar($userid);
	    	
	    	if(!empty($ptypeavatar)){
	    		if(!empty($userAvatar) && !JString::stristr($userAvatar,$ptypeavatar))  
	    			$count = 1;
	    	}
	    	else{
	    		if(!empty($userAvatar))  
	    			$count = 1;
	    	}
	    }
	    else{
			if(!empty($userAvatar) && !strpos($userAvatar,"default.jpg") && !strpos($userAvatar,"user.png"))
				$count = 1;
	    }
		return $count;
	}
	
	public function getPtypeAvatar($userId)
	{
	    $ptype = XiptWrapper::getUserInfo($userId);	
		$field = array_shift(XiptWrapper::getProfiletypeInfo($ptype));
		return $field->avatar;
	}
	
	public function getmultiProfileAvatar($userId)
	{
	    $ptype = MultiProfile::getUserInfo($userId);	
		$field = array_shift(MultiProfile::getProfiletypeInfo($ptype));
		return $field->avatar;
	}
}
