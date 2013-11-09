<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );

$jspcPath = JPATH_ADMINISTRATOR.'/components/com_jspc';

if(!JFolder::exists($jspcPath))
	return false;
	
/*$file = dirname(__FILE__);
$Protocol = "http://";
$tp =	$Protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);*/
?>
<script type="text/javascript" src="<?php echo JURI::root();?>administrator/components/com_jspc/fields/colorbox/jscolor.js"></script>

<?php 
class JFormFieldColorbox extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'Colorbox';

	protected function getInput()
	{
		$html = '<input class="color" type="text" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" />';

		return $html;
	}
	
}