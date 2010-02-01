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
		$standardHtml = '';
		
		//call htmlrender fn
		$addonObject = addonFactory::getAddonObject($data['name']);
		
		$addonObject->bind($data);
		$addonObject->getHtml($coreParamsHtml,$addonParamsHtml,$standardHtml);
		
		$this->assignRef('coreParamsHtml',		$coreParamsHtml);
		$this->assignRef('addonParamsHtml',		$addonParamsHtml);
		$this->assignRef('standardHtml',		$standardHtml);
		$this->assign('addonInfo',$data);
		parent::display($tpl);
	}
	
	
	function aboutus($tpl = null)
	{
		$this->setToolbar();
		parent::display( $tpl);
	}
	
	
}
