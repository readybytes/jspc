<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 * Joomla! 1.5 component jspc
 *
 * @version $Id: addons.php
 * @author Team Joomlaxi
 * @package Joomla
 * @subpackage jspc
 * @license GNU/GPL
 *
 * Joomla component for jomsocial to show completion of profile
 * This file class will call of any feature ( rule ) request.
 * 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class addonFactory
{
	
	public function getAddonsInfo($filter='',$join='AND')
	{
		$db			= JFactory::getDBO();
		
		$filterSql = ''; 
		if(!empty($filter)){
			$filterSql = ' WHERE ';
			$counter = 0;
			foreach($filter as $name => $info) {
				$filterSql .= $counter ? ' '.$join.' ' : '';
				$filterSql .= $db->quoteName($name).'='.$db->Quote($info);
				$counter++;
			}
		}

		$query = 'SELECT * FROM '.$db->quoteName('#__jspc_addons')
				.$filterSql;
				
		$db->setQuery($query);
		$addonsinfo = $db->loadObjectList();
		
		return $addonsinfo;
	}

	public function getAddons()
	{
		$path	= JPATH_ROOT.'/administrator/components/com_jspc/addons';
	
		jimport( 'joomla.filesystem.folder' );
		$addons = array();
		$addons = JFolder::folders($path);
		return $addons;
	}
	
	public function getAddonObject($addonName)
	{
		$path	= dirname(__FILE__).'/'.$addonName.'/'.$addonName.'.php';
		
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($path))
		{
			JError::raiseError(400,JspcText::_("INVALID_ADDON_FILE"));
			return false;
		}

		require_once $path;
			
		//$instance will comtain all addon object according to rule
		//Every rule will have different object
		$addonName = 'Jspc'.ucfirst($addonName);
		static $instance = array();
		if(isset($instance[$addonName]))
			return $instance[$addonName];
			
		//XITODO send debugmode
		$instance[$addonName] = new $addonName(0);	
		return $instance[$addonName];
	}
	
	public function getValueFromParams($what,$from,$default=0)
	{
		$params = new XipcParameter( $from );
		$value  = $params->get($what,$default);
		return $value;
	}
}




abstract class jspcAddons
{
	protected $id;
	protected $name;
	protected $coreparams;
	protected $featurename;
	protected $published;
	protected $addonparams;
	protected $debugMode;
	
	function __construct($className,$debugMode)
	{
		jimport( 'joomla.filesystem.files' );
		$this->debugMode = $debugMode;
		$this->name      = $className;

		//load addon xml if we need to do it
		// this->addonparams can be set by child constructor, 
		// then we do not need to create addon params
		$className    = substr($className, 4);
		$addonXmlpath =  dirname(__FILE__).'/'.strtolower($className) .'/'.strtolower($className).'.xml';
		if(empty($this->addonparams) && JFile::exists($addonXmlpath)){
			$this->addonparams =  XipcParameter::getInstance('addonparams',$addonXmlpath);
		}
		
		$corexmlpath = dirname(__FILE__) .'/coreparams.xml';		
		if(JFile::exists($corexmlpath)){
			$this->coreparams = XipcParameter::getInstance('coreparams',$corexmlpath);
		}
	}
	
	function load($id)
	{
		$info = array();
		if(0 == $id) {
			$this->id          = 0;
			$this->featurename = '';
			$this->published   = 1;
		}
		else {
			$filter       = array();
			$filter['id'] = $id;
			$info         = addonFactory::getAddonsInfo($filter);
			
			if($info) {
				$this->id 			= $info[0]->id;
				$this->name 		= $info[0]->name;
				$this->published 	= $info[0]->published;
				$this->featurename 	= $info[0]->featurename;
				
				$this->coreparams->bind($info[0]->coreparams);
				$this->addonparams->bind($info[0]->addonparams);
			}
		}
	}
	
	
	
	function bind($data)
	{
		if(is_object($data)){
			
			$this->addonparams->bind($data->addonparams);
		
			if(!$this->coreparams) 	$this->setCoreParams();
			$this->coreparams->bind($data->coreparams);
			
			$this->featurename 	= $data->featurename;
			$this->published 	= $data->published;
		}
		if(is_array($data)){
			
			if(!empty($data['addonparams'])){
				$this->addonparams->bind($data['addonparams']);
			}
		
			if(!$this->coreparams) 	$this->setCoreParams();
			
			$coreparams	= $data['coreparams'];
			$this->coreparams->bind($coreparams);
			
			$this->featurename 	= $data['featurename'];
			$this->published 	= $data['published'];
		}
	}
	
	function getFeatureContribution($userid)
	{
		/*XITODO : for profile fields we have to overite this fn
		 * b'coz some fields may be not aplicable to user according to profiletype
		 * and in that case total may change so let to handle this fields class
		 */ 
		$total = $this->coreparams->getValue('jspc_core_total_contribution',0);
		return $total;
	}
	
	function isApplicable($userid)
	{
		/*XITODO : check according to addon params and core params
		 * we will give profiletype facility in core params
		 * user accesibility option
		 * for ex :- if some fields are not available to user 
		 * according to fields disable
		 * then this fn should return false*/
				
		$isApplicableAccToAddon = $this->checkAddonAccesibility($userid);
		$isApplicableAccToCore =  $this->checkCoreAccesibility($userid);
		
		if($isApplicableAccToAddon && $isApplicableAccToCore)
			return true;
			
		return false;
	}
	
	public function checkCoreAccesibility($userid)
	{
		return true;
	}
	
	public function checkAddonAccesibility($userid)
	{
		$integrate_with = $this->getCoreParams('integrate_with','jspt');
		
		if($integrate_with == 'jspt'){
			$xipt_exist = JspcHelper::checkXiptExists();
			if(!$xipt_exist)
				return true;
			
			$ptype = $this->getCoreParams('jspc_profiletype',0);
	        /* ptype 0 means rule is defined for all */
	        if(0 == $ptype)
	            return true;
	        //else check user profiletype
	        $userPtype = XiptWrapper::getUserInfo($userid,'PROFILETYPE');
	        if($userPtype == $ptype)
	            return true;    
		}
		elseif($integrate_with == 'multiprofile'){
			$multiprofile_exist = JspcHelper::checkMultiProfileExists();
			if(!$multiprofile_exist)
				return true;
			
			$ptype = $this->getCoreParams('jspc_multiprofile',0);
	        /* ptype 0 means rule is defined for all */
	        if(0 == $ptype)
	            return true;
	            
	        $userPtype = MultiProfile::getUserInfo($userid);
	        if($userPtype == $ptype)
	            return true;
		}
		else{
			return true;
		}
		return false;
	}
	
	public function getDisplayText($userid)
	{
		$text = $this->coreparams->getValue('jspc_core_display_text','');
		/*here i will return remaining no's , so if user want to show msg like
		 * 3 photo need to be added to complete profile
		 * that he can
		 */
		if(empty($text)) { 
			//write some dummy text
			$classname = $this->getMe();
			$text 	   = sprintf(JspcText::_('ADD %s',false),JspcText::_($classname));
			return $text;
		}
		$text = sprintf(JspcText::_($text,false),$this->getRemainingCount($userid));
		return $text;
	}
	
	public function getCoreParams($what,$default=0)
	{
		$value = $this->coreparams->getValue($what,$default);
		return $value;
	}
	
	public function getMe()
	{
		$name = get_class($this);
		return $name;
	}
	
	public function getRemainingCount($userid)
	{
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->getValue($this->name.'_total',0);
		
		if(0 == $total)
			return 0;
			
		if($count >= $total)
			return 0;
			
		return ($total - $count);
	}
	
	public function calculateCompletness($userid)
	{
		$count = $this->calculateCount($userid);
		$total = $this->addonparams->getValue($this->name.'_total',0);
		$contribution = $this->coreparams->getValue('jspc_core_total_contribution',0);

		if(0 == $total)
			return $contribution;
		
		if($count >= $total)
			return $contribution;
		else {
			/* calclulating percentage according to user album count */
			$percentage =  ( $count / $total ) * $contribution; 
			return $percentage;
		}		
	}
	
	abstract public function getCompletionLink($userid);
}