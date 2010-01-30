<?php
defined('_JEXEC') or die('Restricted access');
?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_jspc&view=addons');
JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
?>

<script language="javascript" type="text/javascript">

	function checkForm()
	{
		var form = document.adminForm;		
		if( form.addon.value == 0 )
		{
			return false;
		}
		return true;
	}
	
	function submitbutton(action) {
		var form = document.adminForm;
		switch(action)
		{
			case 'renderaddon' :
				if( form.addon.value == 0 )
				{
					alert( "<?php echo JText::_( 'PLEASE SELECT A ADDON FROM LIST'); ?>" );
					break;
				} 
			case 'cancel':
			default:
				submitform( action );
		}
	}
</script>
	
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_('DISABLE CAPTCHA FOR FOLLOWING GROUP IRRESEPECT OF COMPONENT ENABLE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?option=com_jspc" method="post" name="adminForm" id="adminForm" onSubmit="return checkForm();" >
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo JText::_('ADDON');?></td>
			<td>:</td>
			<td>
				<select id="addon" name="addon" >
				<option value="0">SELECT ADDON</option>
				<?php
					if(!empty($this->addons)) 
					foreach($this->addons as $addon) {
					   
					   //$selected	= ( JString::trim($id) == $this->row->comid ) ? ' selected="true"' : '';
						?>
					    <option value="<?php echo $addon;?>" <?php //echo $selected;?> ><?php echo JText::_($addon);?></option>
					<?php 
					}
				?>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr"></div>

	<input type="submit" name="addonnext" value="<?php echo JText::_('NEXT');?>" onclick="submitbutton('renderaddon');"/>
	
	<input type="hidden" name="option" value="com_jspc" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'addons' );?>" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="renderaddon" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
