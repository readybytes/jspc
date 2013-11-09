<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );

class JFormFieldProfiletypes extends JFormFieldList
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'Profiletypes';

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
		
		$xiptPath = JPATH_ROOT.'/components/com_xipt';
		if(JFolder::exists($xiptPath)){
			require_once JPATH_ROOT.'/components/com_xipt/api.xipt.php';
			
			$profiletype	= XiptAPI::getProfiletypeInfo();
			$profiles	= array_merge($profiles, $profiletype);
		}
		
		foreach ($profiles as $profile)
		{
			$options[] = JHtml::_('select.option', $profile->id, $profile->name);
		}
		
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}