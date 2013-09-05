<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class JspcViewInstall extends JViewLegacy 
{

	public function display()
  	{
    	return parent::display();
	}
	 
	protected function _adminToolbar()
	{
		$this->_adminToolbarTitle();
	}
}

