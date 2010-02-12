<?php

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
		$totals = array();
		$addonProfiletype = array();
		$profileTypeArray = array();
		$publishPercentage = array();

		//include the library file of XIPT if exist then includes file 
		$isXiptExist=JspcHelper::checkXiptExists();
		
		if($isXiptExist)
			$profileTypeArray=XiPTHelperProfiletypes::getProfiletypeArray();
			
		$total = JspcHelper::getAllTotals(true,	$isXiptExist);
			
		//get total of each criteria
		if(!empty($addonsInfo))
		{
			foreach($addonsInfo as $addon) 
			{
				$totals[$addon->id] = JspcHelper::getTotalContributionOfCriteria($addon->id);
				
				/*XITODO : pull all this code into function , defined already */					
				//if xipt do not exist
				if(!$isXiptExist)
				{
					if($addon->published == false)
						$publishPercentage[$addon->id] = 0 ;
					else
						$publishPercentage[$addon->id] = ( $totals[$addon->id] / $total ) * 100 ;
					
					continue;
				}
				
				//if xipt exist
				$publishPercentage[$addon->id] = array();			
					
				$addonObject = addonFactory::getAddonObject($addon->name);
				$addonObject->bind($addon);
				$ptype = $addonObject->getCoreParams('jspc_profiletype',0);
				$addonProfiletype[$addon->id] = XiPTHelperProfiletypes::getProfiletypeName($ptype);
				
				if($addon->published == false)
				{
						$publishPercentage[$addon->id][$ptype] = 0 ;
						continue;
				}	
				
				if($ptype !=0)
				{
					$publishPercentage[$addon->id][$ptype] = ( $totals[$addon->id] / $total[$ptype] ) * 100 ;
					continue;							
				}
				
				foreach($profileTypeArray as $ptypeId)
					$publishPercentage[$addon->id][$ptypeId] = ( $totals[$addon->id] / $total[$ptypeId] ) * 100 ;								 	
			}
			
			$this->assign('profileTypeArray', $profileTypeArray);		
			$this->assign('addonProfiletype' , $addonProfiletype );
		}
		
		$this->setToolbar();
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
		$isXiptExist=JspcHelper::checkXiptExists();

		// xipt does not exists
		if(!$isXiptExist)
		{	
			$total 				 = JspcHelper::getAllTotals(true);
			$featureContribution = JspcHelper::getTotalContributionOfCriteria($data['id']);
			
			if($total != 0)
				$percentage = ($featureContribution / $total ) * 100;
			else
				$percentage = 100;
		}
		else
		{
			$percentage=array();
			$this->_calculateContributionOfPtype($data,$percentage);	
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
	
	
	
	function _calculateContributionOfPtype($data,&$percentage)
	{
	
		//$addonsInfo = addonFactory::getAddonsInfo();
		$totals = array();
		$addonProfiletype = array();
		
		//include the library file of XIPT if exist then includes file 
		$xipt_exist=JspcHelper::checkXiptExists();
		$percentage = array();
		
		$profileTypeArray=XiPTHelperProfiletypes::getProfiletypeArray();
		if(!$data['published']) {
			foreach($profileTypeArray as $ptypeId)
				$percentage[$ptypeId] = 0 ;
											 	
			return;
		}	
		
		$total = JspcHelper::getAllTotals(true,	$xipt_exist);
			
		$totals[$data['id']] = JspcHelper::getTotalContributionOfCriteria($data['id']);
		$addonObject = addonFactory::getAddonObject($data['name']);
		$addonObject->bind($data);
		$ptype = $addonObject->getCoreParams('jspc_profiletype',0);
		
		
		if($ptype !=0)
		{
			$percentage[$ptype] = ( $totals[$data['id']] / $total[$ptype] ) * 100 ;
			return;
		}
		
		
		foreach($profileTypeArray as $ptypeId)
			$percentage[$ptypeId] = ( $totals[$data['id']] / $total[$ptypeId] ) * 100 ;
											 	
	}
	
}
