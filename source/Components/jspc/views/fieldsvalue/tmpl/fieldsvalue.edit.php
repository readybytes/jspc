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
				<?php echo JText::_( 'Field Name' ); ?> :
			</td>
			<td width="50%">
					<?php echo $this->fieldname; ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
					<?php echo JText::_( 'Weightage' ); ?> :
			</td>
			<td width="50%">
					<input class="text" type="text" name="percentage" id="percentage"<?php echo $this->row->id;?> value="<?php echo $this->value; ?>" />
			</td>
		</tr>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_profilestatus" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'profilestatus' );?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="fieldid" value="<?php echo $this->fieldid; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
