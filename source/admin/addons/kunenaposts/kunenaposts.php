<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcKunenaposts extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	function getCompletionLink($userid)
	{
		$result 		= array();
		$result['text'] = $this->getDisplayText($userid);
		$result['link'] = JRoute::_('index.php?option=com_kunena',false);
		return $result;
	}

	public function calculateCount($userid)
	{
		if(false == $this->isKunenaExist())
			return 0;
		
		$kUser = KunenaUserHelper::get($userid);
		
		return $kUser->posts;
	}
	
	function getFeatureContribution($userid)
	{
		if(false == $this->isKunenaExist())
			return 0;
				
		$total = $this->getCoreParams('jspc_core_total_contribution',0);
		return $total;
	}
	
	public function checkAddonAccesibility($userid)
	{
		if(false == $this->isKunenaExist())
			return false;
			
		return true;
	}
	
	private function isKunenaExist()
	{
		jimport( 'joomla.filesystem.file' );
		jimport( 'joomla.filesystem.folder' );
		
		$kunenapath = JPATH_ROOT.'/components/com_kunena';
		
		if(!JFolder::exists($kunenapath))
			return false;
			
		return true;
	}
}
