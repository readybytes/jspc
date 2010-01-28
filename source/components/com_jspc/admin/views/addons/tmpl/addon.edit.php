<?php
defined('_JEXEC') or die('Restricted access');
?>
	
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_('DISABLE CAPTCHA FOR FOLLOWING GROUP IRRESEPECT OF COMPONENT ENABLE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?option=com_jspc" method="post" name="adminForm" id="adminForm">
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
					    <option value="<?php echo $addon;?>" <?php //echo $selected;?> ><?php echo $addon;?></option>
					<?php 
					}
				?>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr"></div>

	<input type="submit" name="addonnext" value="<?php echo JText::_('NEXT');?>" />
	
	<input type="hidden" name="option" value="com_jspc" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'addons' );?>" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="renderaddon" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
