<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class JspcControllerCPanel extends JControllerLegacy 
{    
	public function getModel($modelName=null,  $prefix = '', $config = array())
    {
		// support for parameter
        if($modelName===null || $modelName === $this->getName())
        	return false;

		return parent::getModel($modelName);
    }
       
}
