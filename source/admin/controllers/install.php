<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

class JspcControllerInstall extends JControllerLegacy 
{
   
	public function getModel($name = '', $prefix = '', $config = array()) 
	{
		return null;
	}

	public function complete()
	{
		$app = JFactory::getApplication();
   		$app->redirect("index.php?option=com_jspc"); 
	}
}

