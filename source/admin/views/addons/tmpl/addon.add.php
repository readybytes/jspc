<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_jspc&view=addons');
JToolBarHelper::cancel( 'cancel', JspcText::_('CLOSE' ));
?>

<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(action){
		var form = document.adminForm;
		switch(action)
		{
			case 'renderaddon' :
				if( form.addon.value == 0 )
				{
					alert( "<?php echo JspcText::_( 'PLEASE_SELECT_A_ADDON_FROM_LIST'); ?>" );
					break;
				} 
			case 'cancel':
			default:
				Joomla.submitform( action );
		}
	}
</script>
	
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JspcText::_('SELECT_CRITERIA_TO_USE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?option=com_jspc" method="post" name="adminForm" id="adminForm">
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo JspcText::_('ADDON');?></td>
			<td>:</td>
			<td>
				<select id="addon" name="addon" >
				<option value="0"><?php echo JspcText::_('SELECT_ADDON');?></option>
				<?php 
					if(!empty($this->addons)) 
					foreach($this->addons as $addon) { ?>
					    <option value="<?php echo $addon;?>" ><?php echo JspcText::_($addon);?></option>
					<?php 
					}
				?>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr"></div>
	<div id="next" style="width:28.5%; direction:rtl; margin-top:10px;">
	<input type="submit" name="addonnext" value="<?php echo JspcText::_('NEXT');?>" onclick="Joomla.submitbutton('renderaddon');"/>
	</div>
	<input type="hidden" name="option" value="com_jspc" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'addons' );?>" />
	<input type="hidden" name="task" value="renderaddon" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
