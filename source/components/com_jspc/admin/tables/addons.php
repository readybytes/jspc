<?php

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Jom Social Table Model
 */
class JspcTableAddons extends JTable
{
	var $name			= null;
	var $featurename	= null;
	var $coreparams		= null;
	var $addonparams	= null;
	var $published		= null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__jspc_addons' , 'id' , $db );
	}
	
	/*
	function load($id,$addon)
	{
		if(!$id) {
			$this->name				= $addon;
			$this->featurename		= '';
			$this->coreparams		= '';
			$this->addonparams		= '';
			$this->published		= 1;
		}
		
		parent::load($id);
	}
	*/
	
	/**
	 * Save the configuration
	 **/	 	
	function store()
	{
		return parent::store();
	}
	
	
	function bind($data)
	{
		$this->name				= $data['name'];
		$this->featurename		= $data['featurename'];
		$this->coreparams		= $data['coreparams'];
		$this->addonparams		= $data['addonparams'];
		$this->published		= $data['published'];
	}
}