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
		
		$total = JspcHelper::getAllTotals(true);
		
		$publishPercentage = array();
		
		$addonsInfo = addonFactory::getAddonsInfo();
		$totals = array();
		//get total of each criteria
		if(!empty($addonsInfo)) {
			foreach($addonsInfo as $addon) {
				$totals[$addon->id] = JspcHelper::getTotalContributionOfCriteria($addon->id);
				if($addon->published)
					$publishPercentage[$addon->id] = ( $totals[$addon->id] / $total ) * 100 ;
				else
					$publishPercentage[$addon->id] = 0 ;
			}
		}
		
		$this->setToolbar();
		
		$this->assign( 'addonsInfo' , $addonsInfo );
		$this->assign( 'totals' , $totals );
		$this->assign( 'publishPercentage' , $publishPercentage );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }
	
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'PROFILE COMPLETENESS' ), 'addons' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_jspc');
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
		JToolBarHelper::addNew('edit', JText::_( 'ADD FEATURE' ));
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'PUBLISHED' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISHED' ));
	}
	
	

	function edit($data,$tpl = null)
	{
		$coreParamsHtml = '';
		$addonParamsHtml = '';
		$standardHtml = '';
		
		if(isset($data['addonInfo'])){
			
			//call htmlrender fn
			$addonObject = addonFactory::getAddonObject($data['addonInfo']->name);
			$binddata = array();
			$binddata['addonparams'] = $data['addonInfo']->addonparams;
			$binddata['coreparams'] = $data['addonInfo']->coreparams;
			$binddata['featurename'] = $data['addonInfo']->featurename;
			$binddata['published'] = $data['addonInfo']->published;
			
			$addonObject->bind($binddata);
			$addonObject->getHtml($coreParamsHtml,$addonParamsHtml,$standardHtml);
			
			$this->assignRef('coreParamsHtml',		$coreParamsHtml);
			$this->assignRef('addonParamsHtml',		$addonParamsHtml);
			$this->assignRef('standardHtml',		$standardHtml);
			$this->assign('addonInfo',$data['addonInfo']);
		}
		
		//$this->assign( 'id' , $data['addonInfo']->id );
		if(!$data['id']) {
			$addons = addonFactory::getAddons();
			$this->assign( 'addons' , $addons );
		}
		parent::display($tpl);
	}
	
	
	function renderaddon($addonInfo,$tpl = null)
	{
		$coreParamsHtml = '';
		$addonParamsHtml = '';
		$standardHtml = '';
		//call htmlrender fn
		$addonObject = addonFactory::getAddonObject($addonInfo->name);
		$addonObject->getHtml($coreParamsHtml,$addonParamsHtml,$standardHtml);
				
		$this->assignRef('coreParamsHtml',		$coreParamsHtml);
		$this->assignRef('addonParamsHtml',		$addonParamsHtml);
		$this->assignRef('standardHtml',		$standardHtml);
		$this->assign('addonInfo',$addonInfo);
		parent::display($tpl);
	}
}
