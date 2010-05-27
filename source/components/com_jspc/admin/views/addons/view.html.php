<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class JspcViewAddons extends JView 
{
	function display($tpl = null)
	{

		$aModel = JspcFactory::getModel('addons');
		$pagination = $aModel->getPagination();
				
		$addonsInfo = addonFactory::getAddonsInfo();
		$addonProfiletype = array();
		$profileTypeArray = array();
		$publishPercentage = array();
		$totals[]=array();
		
		//include the library file of XIPT if exist then includes file 
		$isXiptExist=JspcHelper::checkXiptExists();
		
		if($isXiptExist){
			$profileTypeArray	 = XiPTHelperProfiletypes::getProfileTypeArray();
			foreach($profileTypeArray as $ptypeId)
				$profileTypeName[$ptypeId] = XiPTHelperProfiletypes::getProfileTypeName($ptypeId);
		}
								
		if(!empty($addonsInfo))
		{
			foreach($addonsInfo as $addon) 
			{
				$data=(array)$addon;
				$totals[$addon->id] = array();
				$totals[$addon->id] = JspcHelper::getTotalContributionOfCriteria($addon->id);
							
				
				$publishPercentage[$addon->id] = array();			
					
				$addonObject = addonFactory::getAddonObject($addon->name);
				$addonObject->bind($addon);
				$ptype = $addonObject->getCoreParams('jspc_profiletype',0);
				if($isXiptExist)
				{
					if($ptype==0)
						$addonProfiletype[$addon->id]='all';
					else
						$addonProfiletype[$addon->id] = $profileTypeName[$ptype];
				}
				
				$this->_calculateContributionOfPtype($data,$publishPercentage[$addon->id],$ptype);				
			}			
		}
		
		$this->setToolbar();
		if($isXiptExist){
			$this->assign('profileTypeArray',  $profileTypeArray);		
			$this->assign('addonProfiletype' , $addonProfiletype );
			$this->assignRef('profileTypeName',$profileTypeName);
		}
		$this->assign('isXiptExist', $isXiptExist);
		$this->assign( 'addonsInfo' , $addonsInfo );
		$this->assign( 'totals' , $totals );
		$this->assign( 'publishPercentage' , $publishPercentage );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }

	
	function setToolBar()
	{
		?>
		<style type="text/css">
		#toolbar-aboutus
		{
	 		background-image:  url(../administrator/components/com_jspc/assets/images/icon-aboutus.png);
	 		background-repeat:no-repeat;
	 		background-position: top center;
	 	}
		</style>
		<?php 
		
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'PROFILE COMPLETENESS' ), 'addons' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_jspc');
		JToolBarHelper::custom('aboutus','aboutus','',JText::_('ABOUT US'),0,0); 
		JToolBarHelper::divider();
		JToolBarHelper::addNew('add', JText::_( 'ADD FEATURE' ));
		JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'PUBLISHED' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISHED' ));
	}
	
	

	function add($tpl = null)
	{
		$addons = addonFactory::getAddons();
		$this->assign( 'addons' , $addons );
		parent::display($tpl);
	}
	
	
	function renderaddon($data,$tpl = null)
	{
		$coreParamsHtml = '';
		$addonParamsHtml = '';
		$percentage=0;
		//call htmlrender fn
		$addonObject = addonFactory::getAddonObject($data['name']);
		$addonObject->bind($data);
		$addonObject->getHtml($coreParamsHtml,$addonParamsHtml);
		$ptype = $addonObject->getCoreParams('jspc_profiletype',0);
		$isXiptExist=JspcHelper::checkXiptExists();

		// xipt does not exists
		$percentage=array();
		$this->_calculateContributionOfPtype($data,$percentage,$ptype);
		if($isXiptExist)
		{	
			$profileTypeArray	 = XiPTHelperProfiletypes::getProfileTypeArray();
			foreach($profileTypeArray as $ptypeId)
				$profileTypeName[$ptypeId] = XiPTHelperProfiletypes::getProfileTypeName($ptypeId);
			
			$this->assignRef('profileTypeArray',    $profileTypeArray);
			$this->assignRef('profileTypeName',     $profileTypeName);			
		}
		$this->assign('isXiptExist',$isXiptExist);
		$this->assignRef('coreParamsHtml',		$coreParamsHtml);
		$this->assignRef('addonParamsHtml',		$addonParamsHtml);
		$this->assign('addonInfo',$data);
		$this->assign('percentage',$percentage);
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
		
		//include the library file of XIPT if exist then includes file 
		$isXiptExist=JspcHelper::checkXiptExists();
		$percentage = array();
		$total = JspcHelper::getAllTotals(true,	$isXiptExist);
		$totals[$data['id']] = JspcHelper::getTotalContributionOfCriteria($data['id']);
		if(!$isXiptExist)
		{	
			if($data['published'] == false)
				$percentage=0;
			else if($total != 0)
				$percentage = ($totals[$data['id']] / $total ) * 100;
			else
				$percentage = 100;
			
			return;
		}
		
		$profileTypeArray=XiPTHelperProfiletypes::getProfiletypeArray();
		if(!$data['published']) {
			foreach($profileTypeArray as $ptypeId)
				$percentage[$ptypeId] = 0 ;
											 	
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
			if(key_exists($ptypeId,$total) ==false)
				$percentage[$ptypeId] = 0;
			else if($total[$ptypeId] != 0)
				$percentage[$ptypeId] = ( $totals[$data['id']] / $total[$ptypeId] ) * 100 ;
			else
				$percentage[$ptypeId] = 0;
		}
											 	
	}
	
}
