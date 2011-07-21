<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	Frontend
* @contact 		shyam@readybytes.in
*/
if(defined('_JEXEC')===false) die();

/*
 * We have extended JDocument class so that we can control what to do
 * on particular times
 */
jimport('joomla.html.parameter');

class XipcParameter extends JParameter
{
	public function __construct($data = '', $path = '')
	{
		parent::__construct($data, $path);
	}
	
	//need to use it as binding forwards to loadJSON, rathern then INI
	function bind($data, $group = '_default')
	{
		if ( is_array($data) ) {
			return $this->loadArray($data, $group);
		} elseif ( is_object($data) ) {
			return $this->loadObject($data, $group);
		} else {
			return $this->loadINI($data, $group);
		}
	}
}
