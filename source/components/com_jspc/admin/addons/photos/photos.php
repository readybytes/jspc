<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class photos extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
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
	
	
	public function checkAddonAccesibility($userid)
	{
		/*XITODO : check according to addon params
		 * user accesibility option
		 * for ex :- if photo is not available to user according to profiletype rule
		 * then this fn should return false*/
		return true;
	} 
	
	
	public function calculateCompletness($userid)
	{
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->get('photo_total',0);
		$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
		
		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user photo count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}				
	}
	
	function getCompletionLink($userid)
	{
		$result = array();
		$result['text']=$this->getDisplayText($userid); //JText::_("ADD PHOTOS");
		$result['link']="index.php?option=com_community&view=photos&task=uploader";
		return $result;
	}
	
	
	public function getRemainingCount($userid)
	{
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->get('photo_total',0);
		
		if(0 == $total)
			return 0;
			
		if($count >= $total)
			return 0;
			
		return ($total - $count);
	}
	
	
	public function calculateCount($userid)
	{
		/*For photos we have to check user photo count
		 * and compare with required photo count */
		$pModel =& CFactory::getModel('photos');
		$count = $pModel->getPhotosCount($userid);
		return $count;
	}
	
}