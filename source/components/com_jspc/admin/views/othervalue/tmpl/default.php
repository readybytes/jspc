<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'profilestatus.php' );
?>

<form action=<?php echo JURI::base();?> method="post" name="adminForm" id="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="2%">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="28%" class="title">
					<?php echo JText::_( 'Task' ); ?>
			</th>
			<th width="10%" class="title">
					<?php echo JText::_( 'Quantity Required' ); ?>
			</th>
			<th width="10%" class="title">
					<?php echo JText::_( 'Weightage' ); ?>
			</th>
			<th  width="20%" class="title">
					<?php echo JText::_( 'Contribution in Overall Percentage' ); ?>
			</th>
			<th  width="30%" class="title">
					<?php echo JText::_( 'Help' ); ?>
			</th>
		</tr>
	</thead>
		<?php
		$count = 0;
		$i  = 0;
		
		foreach($this->fields as $field)
		{
				++$i;
				?>
				<tr>
				<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $field->id;?>">
				<td><?php echo $i;?></td>
				<td>
					<span class="editlinktip" title="<?php echo $field->name; ?>" id="name<?php echo $field->id;?>">
					<?php $link = JRoute::_('index.php?option=com_profilestatus&view=othervalue&task=editOther&editId='.$field->id, false); ?>
						<a href="<?php echo $link; ?>"><?php echo $field->name; ?></A>
						<?php //echo JHTML::_('link', 'javascript:void(0);', $row->name, 'onclick'=>"javascript:editFields()"); ?>
					</span>
				</td>
				<td class="title">
						<?php echo $field->total; ?>
				</td>
				<td class="title">
						<?php echo $field->value; ?>
				</td>
				<td class="title">
						<?php echo ProfilestatusHelper::get_individual_percentage_contribution($field->value)." %"; ?>
				</td>
				<?php
				if($i==1)
				{
					?>
					<td rowspan="14">
						<b>Configuration Settings :</b>	<br />
						 Here you should set up which task will contribute how much to 
						 overall profile completeness percentage. 
						 <br /> <br />E.g. if you think user should have at least 5 photos in his profile.
						 For this edit task Add Photos and set quantity to 5 and give some weightage.
						 <br /><br />  
						 Then we will calculate and convert Weightage into Percentage automatically.
						 By the concept of Weightage you can fine tune contribution of task into 
						 overall profile completeness.
					</td>
					<?php
				} 
				?>
				
				</tr>
				<?php
		}
		?>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_profilestatus" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

