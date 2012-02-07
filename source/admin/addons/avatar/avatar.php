<?php
// no direct access

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

class JspcAvatar extends jspcAddons
{
	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
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
		$result['link']=CRoute::_('index.php?option=com_community&view=profile&task=uploadAvatar');
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
		$my 		   = CFactory::getUser($userid);		
		$pathofAvatar  = $my->_avatar;
		$count = 0;
		$integrate_with = $addonObject->getCoreParams('integrate_with', 'jspt');
		
		if(JspcHelper::checkXiptExists() && $integrate_with == 'jspt'){
	    	$ptypeavatar=$this->getPtypeAvatar($userid);	
	    	if(!empty($pathofAvatar) 
	    		&& !JString::stristr($pathofAvatar,$ptypeavatar))  
	    		$count=1;
	    }
	    elseif(JspcHelper::checkMultiProfileExists() && $integrate_with == 'multiprofile'){
	    	$ptypeavatar = $this->getmultiProfileAvatar($userid);	
	    	if(!empty($pathofAvatar) 
	    		&& !JString::stristr($pathofAvatar,$ptypeavatar))  
	    		$count=1;
	    }
	    else{
			if(!empty($pathofAvatar) && !strpos($pathofAvatar,"default.jpg") && !strpos($pathofAvatar,"user.png"))
				$count = 1;
	    }
		return $count;
	}
	
	public function getPtypeAvatar($userId)
	{
	    $ptype  = XiptWrapper::getUserInfo($userId);	
		$field = array_shift(XiptWrapper::getProfiletypeInfo($ptype));
		return $field->avatar;
	}
	
	public function getmultiProfileAvatar($userId)
	{
	    $ptype  = MultiProfile::getUserInfo($userId);	
		$field = array_shift(MultiProfile::getProfiletypeInfo($ptype));
		return $field->avatar;
	}
}
