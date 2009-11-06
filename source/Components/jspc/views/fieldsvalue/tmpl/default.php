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
			<th width="29%" class="title">
					<?php echo JText::_( 'Field Name' ); ?>
			</th>
			<th width="15%" class="title">
					<?php echo JText::_( 'Weightage' ); ?>
			</th>
			<th width="15%" class="title">
					<?php echo JText::_( 'Contribution in Percentage' ); ?>
			</th>
			<th width="40%" class="title">
					<?php echo ""; ?>
			</th>
		</tr>
	</thead>
		<?php
		$count = 0;
		$i  = 0;
		
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
				<td>
					<span class="editlinktip" title="<?php echo $data->fieldname; ?>" id="name<?php echo $data->id;?>">
					<?php $link = JRoute::_('index.php?option=com_profilestatus&view=fieldsvalue&task=editField&editId='.$data->fieldid, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $data->fieldname; ?></A>
						<?php //echo JHTML::_('link', 'javascript:void(0);', $row->name, 'onclick'=>"javascript:editFields()"); ?>
					</span>
				</td>
				<td class="title">
						<?php echo $data->value; ?>
				</td>
				<td class="title">
						<?php echo $data->percentage." %"; ?>
				</td>
				</tr>
				<?php
			}
			else
			{?>
				<td>
				<?php echo ""; ?>
				</td>
				<th class="title">
						<legend><?php echo $data->fieldname; ?></legend>
				</th>
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

