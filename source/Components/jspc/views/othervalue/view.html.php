<?php
/**
 * Joomla! 1.5 component profilestatus
 *
 * @version $Id: view.html.php 2009-07-01 01:02:25 svn $
 * @author Meenal Devpura
 * @package Joomla
 * @subpackage profilestatus
 * @license GNU/GPL
 *
 * Joomla component for jomsocial to show completion of profile
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
class ProfilestatusViewOthervalue extends JView 
{
	function display($tpl = null){
		$ovModel =& $this->getModel('othervalue');
		$fields = $ovModel->getData();
		
		$this->assign('fields', $fields);
		return parent::display($tpl);
    }
	
	function editOther($data)
	{
		$this->assign('data', $data);
		
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Edit Others Contribution in profile completion' ), 'profilestatus' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_profilestatus&view=othervalue');
		JToolBarHelper::divider();
		JToolBarHelper::save('saveOther','Save');
		JToolBarHelper::cancel( 'cancelOther', 'Close' );
		parent::display();
	}
}
?>