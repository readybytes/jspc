<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
		
class JspcViewCpanel extends JViewLegacy
{	
	function display($tpl = null)
	{
		$this->setToolbar();

		parent::display( $tpl );
	}

	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/
	function setToolBar()
	{
		?>
		<style type="text/css">
		 	.icon-48-addons{
				background-image:  url(../administrator/components/com_jspc/assets/images/jspc.png);
				background-repeat:no-repeat;
			}
		</style>
		<?php 
		JToolBarHelper::title( JspcText::_( 'CONTROL_PANEL' ), 'addons' );
	}
	
	function addIcon( $image , $url , $text , $newWindow = false )
	{	
		$newWindow	= ( $newWindow ) ? ' target="_blank"' : '';
		
		$this->assign('image',$image);
		$this->assign('url',$url);
		$this->assign('text',$text);
		$this->assign('newWindow',$newWindow);

		return $this->loadTemplate('addicon');
	}
}
?>
