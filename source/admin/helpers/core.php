<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcFactory 
{
	
	static function getModel( $name = '')
	{
		static $modelInstances = null;
		
		if(!isset($modelInstances[$name]))
		{
			include_once( JPATH_ADMINISTRATOR.'/components/com_jspc'
							.'/models/'. JString::strtolower( $name ) .'.php');
			$classname = 'JspcModel'.$name;
			$modelInstances[$name] = new $classname;
		}
		
		return $modelInstances[$name];
	}	
}
