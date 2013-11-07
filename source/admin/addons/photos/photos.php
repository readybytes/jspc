<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcPhotos extends jspcAddons
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
		
	function getCompletionLink($userid)
	{
		$result 		= array();
		$result['text'] = $this->getDisplayText($userid);
		$result['link'] = CRoute::_('index.php?option=com_community&view=photos&task=uploader');
		return $result;
	}
	
	public function calculateCount($userid)
	{
		/*For photos we have to check user photo count
		 * and compare with required photo count */
		$pModel = CFactory::getModel('photos');
		$count  = $pModel->getPhotosCount($userid);
		return $count;
	}
}
