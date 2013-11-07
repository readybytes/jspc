<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JFormFieldMultiProfiles extends JFormFieldList
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'MultiProfiles';

	function getOptions()
	{
		$profiles	= array();
		
		$reqnone 	= isset($this->element['addnone'])  ? true  : false;
		$reqall   	= isset($this->element['addall'])   ? true  : false;
		
		if($reqnone){
			$reqnone 		= new stdClass();
			$reqnone->id 	= -1;
			$reqnone->name 	= 'None';
			$profiles[] 	= array_merge($profiles, array($reqnone));
		}
			
		if($reqall){
			$reqall 		= new stdClass();
			$reqall->id 	= 0;
			$reqall->name 	= 'All';
			$profiles		= array_merge($profiles, array($reqall));
		}
		
		if(JspcHelper::checkMultiProfileExists())
		{	
			$multiprofiles = MultiProfile::getProfiletypeInfo();
			$profiles		= array_merge($profiles, $multiprofiles);
		}
		
		foreach ($profiles as $profile)
		{
			$options[] = JHtml::_('select.option', $profile->id, $profile->name);
		}
		
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}