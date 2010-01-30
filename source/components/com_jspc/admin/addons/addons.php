<?php
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
		$db			=& JFactory::getDBO();
		
		$filterSql = ''; 
		if(!empty($filter)){
			$filterSql = ' WHERE ';
			$counter = 0;
			foreach($filter as $name => $info) {
				$filterSql .= $counter ? ' '.$join.' ' : '';
				$filterSql .= $db->nameQuote($name).'='.$db->Quote($info);
				$counter++;
			}
		}

		$query = 'SELECT * FROM '.$db->nameQuote('#__jspc_addons')
				.$filterSql;
				
		$db->setQuery($query);
		$addonsinfo = $db->loadObjectList();
		
		return $addonsinfo;
	}
	
	
	
	public function getAddons()
	{
		$path	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_jspc' . DS . 'addons';
	
		jimport( 'joomla.filesystem.folder' );
		$addons = array();
		$addons = JFolder::folders($path);
		return $addons;
	}
	
	
	public function getAddonObject($addonName)
	{
		$path	= dirname(__FILE__). DS . $addonName . DS . $addonName.'.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($path))
		{
			//XITODO: err message
			JError::raiseError(400,JText::_("INVALID ADDON FILE"));
			return false;
		}

		require_once $path;
			
		//$instance will comtain all addon object according to rule
		//Every rule will have different object
		static $instance = array();
		if(isset($instance[$addonName]))
			return $instance[$addonName];
			
		//XITODO send debugmode
		$instance[$addonName] = new $addonName(0);	
		return $instance[$addonName];
	}
	
	
	public function getValueFromParams($what,$from,$default=0)
	{
		$params = new JParameter( $from );
		$value = $params->get($what,$default);
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
	protected $percentage;//it must not be saved in database .calculate everytime
	protected $debugMode;
	
	function __construct($className,$debugMode)
	{
		jimport( 'joomla.filesystem.files' );
		$this->debugMode = $debugMode;
		$this->name = $className;
		$xmlpath =  dirname(__FILE__) . DS . strtolower($className) . DS . strtolower($className).'.xml';
		if(JFile::exists($xmlpath)
			&& !$this->addonparams)
			$this->addonparams = new JParameter('',$xmlpath);

		$corexmlpath = dirname(__FILE__) . DS . 'coreparams.xml';
		if(JFile::exists($corexmlpath)
			$this->coreparams = new JParameter('',$corexmlpath);
	}
	
	
	function load($id)
	{
		$info = array();
		if(0 == $id) {
			$this->id = 0;
			$this->featurename = '';
			$this->published = 1;
		}
		if($id) {
			$filter = array();
			$filter['id'] = $id;
			$info = addonFactory::getAddonsInfo($filter);
			if($info) {
				$this->id = $info[0]->id;
				$this->name = $info[0]->name;
				$this->featurename = $info[0]->featurename;
				$this->coreparams = $info[0]->coreparams;
				$this->addonparams = $info[0]->addonparams;
			}
		}
	}
	
	
	
	final public function setCoreParams()
	{
		if($this->coreparams)
			return;
			
		$xmlpath = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_jspc' . DS . 'addons' . DS . 'coreparams.xml';
		$this->coreparams = new JParameter('',$xmlpath);
	}
	
	
	public function getHtml(&$coreParamsHtml,&$addonParamsHtml,&$standardHtml)
	{
		//Imp : Function will always call core field html
		$coreParamsHtml = $this->getCoreParamsHtml();
		$addonParamsHtml = $this->getAddonParamsHtml();
		$standardHtml = "Write html for published field , just write a text box";
	}
	
	
	public function getAddonParamsHtml()
	{
		$addonParamsHtml = $this->addonparams->render('addonparams');
		
		if($addonParamsHtml)
			return $addonParamsHtml;
		
		$addonParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
		
		return $addonParamsHtml;
	}
	
	
	final public function getCoreParamsHtml()
	{
		$this->setCoreParams();
		$coreParamsHtml = '';
		$coreParamsHtml .= "<td width='40%' class='paramlist_key'>".JText::_('CONTRIBUTION IN PERCENTAGE',false)." ( ".round($this->percentage,2)." % )</td>";
		$coreParamsHtml .= $this->coreparams->render('coreparams');
		
		if($coreParamsHtml)
			return $coreParamsHtml;
		
		$coreParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
		
		return $coreParamsHtml;
	}
	
	
	function collectParamsFromPost($postdata)
	{
		assert($postdata['addonparams']);
		$registry	=& JRegistry::getInstance( 'jspc' );
		$registry->loadArray($postdata['addonparams'],'jspc_addonparams');
		$addonparams =  $registry->toString('INI' , 'jspc_addonparams' );
		return $addonparams;
	}
	
	
	
	function bind($data)
	{
		$this->addonparams->bind($data['addonparams']);
		if(!$this->coreparams)
			$this->setCoreParams();
		$this->coreparams->bind($data['coreparams']);
		$this->featurename = $data['featurename'];
		$this->published = $data['published'];
		if(isset($data['percentage']))
			$this->percentage = $data['percentage'];
	}
	
	
	function getFeatureContribution($userid)
	{
		/*XITODO : for profile fields we have to overite this fn
		 * b'coz some fields may be not aplicable to user according to profiletype
		 * and in that case total may change so let to handle this fields class
		 */ 
		$total = $this->coreparams->get('jspc_core_total_contribution',0);
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
		return true;
	}
	
	
	public function getDisplayText($userid)
	{
		$text = $this->coreparams->get('jspc_core_display_text','');
		/*here i will return remaining no's , so if user want to show msg like
		 * 3 photo need to be added to complete profile
		 * that he can
		 */
		if(empty($text)) { 
			//write some dummy text
			$classname = $this->getMe();
			$text = sprintf(JText::_('ADD %s',false),JText::_($classname));
			return $text;
		}
		$text = sprintf(JText::_($text,false),$this->getRemainingCount($userid));
		return $text;
	}
	
	public function getMe()
	{
		$name =  get_class($this);
		return $name;
	}
	
	abstract public function getRemainingCount($userid);
	
}
