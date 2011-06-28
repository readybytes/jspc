<?php
defined('_JEXEC') or die('Restricted access');
class JspcProfilevideo extends jspcAddons
{
		function __construct($debugMode)
		{
			parent::__construct(__CLASS__,$debugMode);
		}
		
		function getCompletionLink($userid)
		{
			$result = array();
			$result['text']= $this->getDisplayText($userid); //JText::_("ADD ALBUM");
			$result['link']=CRoute::_('index.php?option=com_community&view=profile&task=linkVideo');
			return $result;
		}
		
		function calculateCompletness($userid)
		{
			$count = $this->calculateCount($userid);		
			$contribution = $this->coreparams->get('jspc_core_total_contribution',0);
			
			if($count >= 1)
				return $contribution;
			else 
				return 0;
		}
		
		public function getRemainingCount($userid)
		{
			$count = $this->calculateCount($userid);
			if($count)
				return 0;
			
			return 1;
		}
		
		public function calculateCount($userid)
		{
			$my 		=   CFactory::getUser($userid);	
			$params		=	$my->getParams();
			$videoid	=	$params->get('profileVideo', 0);	
			
			if($videoid)
				return 1;
			
			return 0;
		}
}