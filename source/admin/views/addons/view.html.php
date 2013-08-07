<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class JspcViewAddons extends JViewLegacy 
{
	function display($tpl = null)
	{

		$aModel 	= JspcFactory::getModel('addons');
		$pagination = $aModel->getPagination();
				
		$addonsInfo 	  		= addonFactory::getAddonsInfo();
		$addonProfiletype 		= array();
		$profileTypeArray 		= array();
		$publishPercentage 		= array();
		$totals[]				= array();
		$profileTypeArrayObject = array();
		$profilesExist 			= false;
		$ptype					= 0;
		$integrate_with 		= 'none';
		
		//check JSPT or JS Multi profiles exist or not
		$isXiptExist	   = JspcHelper::checkXiptExists();
		$multiprofileExist = JspcHelper::checkMultiProfileExists();
		
		if($isXiptExist){
			$profilesExist 			= true;
			$profileTypeArrayObject	= XiptAPI::getProfiletypeInfo();
		}
		
		if($multiprofileExist){
			$profilesExist   		= true;
			$profileTypeArrayObject	= MultiProfile::getProfiletypeInfo();
		}
			
		foreach($profileTypeArrayObject as $ptypeId)
		{
			$profileTypeArray[$ptypeId->id]= $ptypeId->id;
			$profileTypeName[$ptypeId->id] = $ptypeId->name;
		}
					
		if(!empty($addonsInfo))
		{
			foreach($addonsInfo as $addon) 
			{
				$data				= (array)$addon;
				$totals[$addon->id] = array();
				$totals[$addon->id] = JspcHelper::getTotalContributionOfCriteria($addon->id);
							
				
				$publishPercentage[$addon->id] = array();			
					
				$addonObject = addonFactory::getAddonObject($addon->name);
				$addonObject->bind($addon);
				$integrate_with = $addonObject->getCoreParams('integrate_with',"jspt");
				
				if($isXiptExist && $integrate_with == "jspt")
				{
					$ptype = $addonObject->getCoreParams('jspc_profiletype',0);
					
					if($ptype == 0)
						$addonProfiletype[$addon->id] = 'all';
					else
						$addonProfiletype[$addon->id] = $profileTypeName[$ptype];
				}
				
				if($multiprofileExist && $integrate_with == "multiprofile")
				{
					$ptype = $addonObject->getCoreParams('jspc_multiprofile',0);
					
					if($ptype == 0)
						$addonProfiletype[$addon->id] = 'all';
					else
						$addonProfiletype[$addon->id] = $profileTypeName[$ptype];
				}
				
				$this->_calculateContributionOfPtype($data,$publishPercentage[$addon->id],$ptype);				
			}			
		}
		
		$this->setToolbar('display');
		if($profilesExist){
			$this->assign('profileTypeArray',  $profileTypeArray);		
			$this->assign('addonProfiletype' , $addonProfiletype );
			$this->assignRef('profileTypeName',$profileTypeName);
			$this->assignRef('integrate_with',$integrate_with);
		}
		$this->assign('profilesExist', $profilesExist);
		$this->assign( 'addonsInfo' , $addonsInfo );
		$this->assign( 'totals' , $totals );
		$this->assign( 'publishPercentage' , $publishPercentage );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }

	
	function setToolBar($task='display')
	{      
		$task = JRequest::getVar('task',$task);
		?>
		<style type="text/css">
		#toolbar-aboutus
		{
	 		background-image:  url(../administrator/components/com_jspc/assets/images/icon-aboutus.png);
	 		background-repeat:no-repeat;
	 		background-position: top center;
	 	}
	 	.icon-48-addons{
			background-image:  url(../administrator/components/com_jspc/assets/images/jspc.png);
			background-repeat:no-repeat;
		}
		</style>
		<?php 
		
		// Set the titlebar text
		
		JToolBarHelper::title( JspcText::_( 'PROFILE_COMPLETENESS' ), 'addons' );
		if($task === 'add' || $task === 'renderaddon'){
			return true;
		}
			// Add the necessary buttons
			JToolBarHelper::back('Home' , 'index.php?option=com_jspc');
			JToolBarHelper::custom('aboutus','aboutus','',JspcText::_('ABOUT_US'),0,0); 
			JToolBarHelper::divider();
			JToolBarHelper::addNew('add', JspcText::_( 'ADD_FEATURE' ));
			JToolBarHelper::trash('remove', JspcText::_( 'DELETE' ));
			JToolBarHelper::divider();
			JToolBarHelper::publishList('publish', JspcText::_( 'PUBLISHED' ));
			JToolBarHelper::unpublishList('unpublish', JspcText::_( 'UNPUBLISHED' ));
			return true;
	}

	function add($tpl = null)
	{
		$addons = addonFactory::getAddons();
		$this->assign( 'addons' , $addons );
		$this->setToolbar('add');
		return parent::display($tpl);
	}
	
	function renderaddon($data,$tpl = null)
	{
		$coreParamsHtml  = '';
		$addonParamsHtml = '';
		$percentage 	 = 0;
		$profilesExist 	 = false;
		$profileTypeArrayObject = array();
		$ptype			 = 0;
		
		//call htmlrender fn
		$addonObject = addonFactory::getAddonObject($data['name']);
		$addonObject->bind($data);
		$addonObject->getHtml($coreParamsHtml,$addonParamsHtml);
		
		$integrate_with = $addonObject->getCoreParams('integrate_with', 'jspt');
		
		if($integrate_with == "jspt")
			$ptype = $addonObject->getCoreParams('jspc_profiletype',0);
		elseif($integrate_with == "multiprofile")
			$ptype = $addonObject->getCoreParams('jspc_multiprofile',0);
			
		$isXiptExist	   = JspcHelper::checkXiptExists();
		$multiprofileExist = JspcHelper::checkMultiProfileExists();

		// xipt does not exists
		$percentage = array();
		$this->_calculateContributionOfPtype($data,$percentage,$ptype);
		
		if($isXiptExist && $integrate_with == "jspt")
		{	
			$profilesExist 			 = true;
			$profileTypeArrayObject	 = XiptAPI::getProfiletypeInfo();		
		}
		
		if($multiprofileExist && $integrate_with == "multiprofile")
		{	
			$profilesExist 			 = true;
			$profileTypeArrayObject	 = MultiProfile::getProfiletypeInfo();			
		}

		foreach($profileTypeArrayObject as $ptypeId)
		{
			$profileTypeArray[$ptypeId->id]= $ptypeId->id;
			$profileTypeName[$ptypeId->id] = $ptypeId->name;
		}
		
		$this->assignRef('profileTypeArray',    $profileTypeArray);
		$this->assignRef('profileTypeName',     $profileTypeName);

		$this->assign('profilesExist',$profilesExist);
		$this->assignRef('coreParamsHtml',		$coreParamsHtml);
		$this->assignRef('addonParamsHtml',		$addonParamsHtml);
		$this->assign('addonInfo',$data);
		$this->assign('percentage',$percentage);
		$this->setToolBar();
		parent::display($tpl);
	}
	
	function aboutus($tpl = null)
	{
		$this->setToolbar();
		parent::display( $tpl);
	}
	
	function _calculateContributionOfPtype($data,&$percentage,$ptype)
	{
	
		//$addonsInfo = addonFactory::getAddonsInfo();
		$totals = array();
		$addonProfiletype = array();
		$profilesExist 	 = false;
		//include the library file of XIPT if exist then includes file 
		$isXiptExist 	   = JspcHelper::checkXiptExists();
		$multiprofileExist = JspcHelper::checkMultiProfileExists();
		
		if($isXiptExist){
			$profilesExist 		= true;
			$profileTypeArray	= XiptAPI::getProfiletypeInfo();
		}
		
		if($multiprofileExist){
			$profilesExist 		= true;
			$profileTypeArray	= MultiProfile::getProfiletypeInfo();
		}
		
		
		$percentage 		 = array();
		$total 				 = JspcHelper::getAllTotals(true,	$profilesExist);
		$totals[$data['id']] = JspcHelper::getTotalContributionOfCriteria($data['id']);
		
		if(!$profilesExist)
		{	
			if($data['published'] == false)
				$percentage=0;
			else if($total != 0)
				$percentage = ($totals[$data['id']] / $total ) * 100;
			else
				$percentage = 100;
			
			return;
		}
		
		if(!$data['published']) {
			foreach($profileTypeArray as $ptypeId)
				$percentage[$ptypeId->id] = 0 ;
											 	
			return;
		}	
				
		if($ptype !=0)
		{
			if(key_exists($ptype,$total) ==false)
				$percentage[$ptype] = 0;
			else if($total[$ptype] != 0)
				$percentage[$ptype] = ( $totals[$data['id']] / $total[$ptype] ) * 100 ;
			else 
				$percentage[$ptype] = 0;
			return;
		}
		
		
		foreach($profileTypeArray as $ptypeId)
		{
			if(key_exists($ptypeId->id,$total) ==false)
				$percentage[$ptypeId->id] = 0;
			else if($total[$ptypeId->id] != 0)
				$percentage[$ptypeId->id] = ( $totals[$data['id']] / $total[$ptypeId->id] ) * 100 ;
			else
				$percentage[$ptypeId->id] = 0;
		}
											 	
	}
	
}
