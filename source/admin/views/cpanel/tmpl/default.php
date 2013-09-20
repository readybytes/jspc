<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');

$version 	= new JVersion();
if($version->RELEASE === '2.5'){
	require_once JPATH_ROOT . '/libraries/joomla/html/html/sliders.php';
}
?>

<form action="<?php echo JURI::base();?>index.php?option=com_jspc" method="post" name="adminForm">
<table width="100%" border="0">
	<tr>
		<td width="35%" valign="top">
			<div id="cpanel" class="clearfix">
				<?php echo $this->addIcon('jspc.png','index.php?option=com_jspc&view=addons', JspcText::_('ADD_FEATURE'));?>
				<?php echo $this->addIcon('documentation.png','http://www.joomlaxi.com/jomsocial-profiles-completeness.html', JspcText::_('DOCUMENTATION'));?>
				<?php echo $this->addIcon('support.png','http://www.joomlaxi.com/support/forum.html', JspcText::_('SUPPORT'));?>
				
			</div>
		</td>
		<td width="65%" valign="top">
			<?php 
				echo JHtmlSliders::start('slider');
				
				echo JHtmlSliders::panel( JspcText::_('WELCOME'), 'welcome' );
				echo $this->loadTemplate('welcome');
				
				echo JHtmlSliders::panel( JspcText::_('UPDATES'), 'update' );
				echo $this->loadTemplate('update');
				
				echo JHtmlSliders::end();
			?>
		</td>
	</tr>
</table>

<input type="hidden" name="view" value="cpanel" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_jspc" />
<input type="hidden" name="boxchecked" value="0" />
</form>	
<?php 