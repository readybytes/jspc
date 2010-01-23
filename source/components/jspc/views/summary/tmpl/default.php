<?php
defined('_JEXEC') or die('Restricted access');
?>

<form action=<?php echo JURI::base();?> method="post" name="adminForm" id="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="33%" class="title">
					<?php echo JText::_( 'Field Name' ); ?>
			</th>
			<th width="33%" class="title">
					<?php echo JText::_( 'Weightage' ); ?>
			</th>
			<th width="33%" class="title">
					<?php echo JText::_( 'Contribution in Percentage' ); ?>
			</th>
		</tr>
	</thead>
		<?php
		$count = 0;
		$i  = 0;
		
		if(!empty($this->datas))
		{
			?>
			<tr>
			<td><?php echo ""; ?> </td>
			<th width="50%" class="title">
							<legend><?php echo "Profile Fields Information";?></legend>
			</th>
			<td><?php echo ""; ?> </td>
			<td><?php echo ""; ?> </td>
			</tr>
			<?php 
			foreach($this->datas as $data)
			{
				//$input	= JHTML::_('grid.id', $count, $field->id);
				
				if($data->type != "group")
				{
					++$i;
					?>
					<tr>
					<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $data->id;?>">
					<td><?php echo $i;?></td>
					<td width="33%" class="title">
						<?php echo $data->fieldname; ?>
					</td>
					<td width="33%" class="title">
							<?php echo $data->value; ?>
					</td>
					<td width="33%" class="title">
							<?php echo $data->percentage." %"; ?>
					</td>
					</tr>
					<?php
				}
			}
		}
		
		if(!empty($this->otherfields))
		{
			?>
			<tr>
			<td><?php echo ""; ?> </td>
			<th width="50%" class="title">
							<legend><?php echo "Other Information";?></legend>
			</th>
			<td><?php echo ""; ?> </td>
			<td><?php echo ""; ?> </td>
			</tr>
			<?php 
			foreach($this->otherfields as $field)
			{
				++$i;
				?>
				<tr>
				<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $field->id;?>">
				<td><?php echo $i;?></td>
				<td>
					<?php echo $field->name; ?>
				</td>
				<td width="33%" class="title">
						<?php echo $field->value; ?>
				</td>
				<td width="33%" class="title">
						<?php echo ProfilestatusHelper::get_individual_percentage_contribution($field->value)." %"; ?>
				</td>
				
				</tr>
				<?php
			}
		}
		?>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_profilestatus" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

