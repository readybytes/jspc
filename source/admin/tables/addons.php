<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Jom Social Table Model
 */
class JspcTableAddons extends JTable
{
	var $id				= null;
	var $name			= null;
	var $featurename	= null;
	var $coreparams		= null;
	var $addonparams	= null;
	var $published		= null;
	
	function __construct($db)
	{
		parent::__construct( '#__jspc_addons' , 'id' , $db );
	}
	
	/*
	function load($id,$addon)
	{
		if(!$id) {
			$this->id				= 0;
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
	function store($updateNulls = false)
	{
		parent::store();
		return $this->id;
	}
	
	
	function bind($data, $ignore = array())
	{
		$this->id				= $data['id'];
		$this->name				= $data['name'];
		$this->featurename		= $data['featurename'];
		$this->coreparams		= $data['coreparams'];
		$this->addonparams		= $data['addonparams'];
		$this->published		= $data['published'];
	}
}
