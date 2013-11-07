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

class XipcParameter extends JRegistry
{
	public static function getInstance($name, $data = null, $options = array(), $replace = true, $xpath = false)
	{
		$data = trim($data);

		if (empty($data))
		{
			throw new InvalidArgumentException(sprintf('JForm::getInstance(name, *%s*)', gettype($data)));
		}

		// Instantiate the form.
		JForm::addFieldPath(JPATH_ADMINISTRATOR.'/components/com_jspc/fields');
		
		$forms[$name] = JForm::getInstance($name,$data,array(),false,'//config');


		// Load the data.
		if (substr(trim($data), 0, 1) == '<')
		{
			if ($forms[$name]->load($data, $replace, $xpath) == false)
			{
				throw new RuntimeException('JForm::getInstance could not load form');
			}
		}
		else
		{
			if ($forms[$name]->loadFile($data, $replace, $xpath) == false)
			{
				throw new RuntimeException('JForm::getInstance could not load file');			}
		}

		return $forms[$name];
	}
	
	public function bind($data, $group = '_default')
	{
		if (is_array($data))
		{
			return $this->loadArray($data, $group);

		} elseif (is_object($data))
		{
			return $this->loadObject($data, $group);

		} else
		{
			// Return JSON
			return $this->loadString($data);
		}
	}
}
