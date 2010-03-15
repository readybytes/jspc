<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class kunenaposts extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']= $this->getDisplayText($userid); //JText::_("ADD ALBUM");
		$result['link']="index.php?option=com_kunena";
		return $result;
	}

	public function calculateCount($userid)
	{
		if(false == $this->isKunenaExist())
			return 0;
			
		require_once(JPATH_ROOT.DS. 'components' .DS. 'com_kunena' . DS . 'lib' . DS . 'kunena.user.class.php' );
		
		$kUser = new CKunenaUserprofile($userid);
		
		return $kUser->posts;
	}
	
	
	function getFeatureContribution($userid)
	{
		if(false == $this->isKunenaExist())
			return 0;
				
		$total = $this->coreparams->get('jspc_core_total_contribution',0);
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
		
		$kunenapath = JPATH_ROOT.DS.'components'.DS.'com_kunena';
		
		if(!JFolder::exists($kunenapath))
			return false;
			
		return true;
	}
}