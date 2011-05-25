<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class JspcText
{		
	function sprintf($string)
	{
		$args = func_get_args();
		return call_user_func_array(array('JText','sprintf'), $args);
	}
	
	static function _($string, $jsSafe = false)
	{
    	$string='COM_JSPC_'.$string;
        return JText::_($string, $jsSafe);
    }
}