<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcFactory 
{
	
	function &getModel( $name = '')
	{
		static $modelInstances = null;
		
		if(!isset($modelInstances[$name]))
		{
			include_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jspc'
							.DS.'models'.DS. JString::strtolower( $name ) .'.php');
			$classname = 'JspcModel'.$name;
			$modelInstances[$name] =& new $classname;
		}
		
		return $modelInstances[$name];
	}
	
}
?>