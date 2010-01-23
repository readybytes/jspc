<?php
defined('_JEXEC') or die('Restricted access');
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		submitform( pressbutton );
	}
</script>

<form action=<?php echo JURI::base();?> method="post" name="adminForm" id="adminForm">
<table class="adminlist" cellspacing="1">
		<tr>
			<td width="30%">
				<?php echo JText::_( 'Name' ); ?> :
			</td>
			<td width="50%">
					<?php echo $this->data->name; ?>
			</td>
		</tr>
		<tr>
		<tr>
			<td width="30%">
				<?php echo JText::_( 'Quanitity' ); ?> :
			</td>
			<td width="50%">
					<input class="text" type="text" name="total" id="toal"<?php echo $this->data->id;?> value="<?php echo $this->data->total; ?>" />
			</td>
		</tr>
		<tr>
			<td width="30%">
					<?php echo JText::_( 'Weightage' ); ?> :
			</td>
			<td width="50%">
					<input class="text" type="text" name="value" id="value"<?php echo $this->data->id;?> value="<?php echo $this->data->value; ?>" />
			</td>
		</tr>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_profilestatus" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'profilestatus' );?>" />
	<input type="hidden" name="id" value="<?php echo $this->data->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
