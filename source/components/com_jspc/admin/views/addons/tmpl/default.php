<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla toolbar calls it
 **/ 
function submitbutton( action )
{
	switch( action )
	{
		case 'remove':
			if( !confirm( '<?php echo JText::_('ARE YOU SURE YOU WANT TO REMOVE THIS CRITERIA?'); ?>' ) )
			{
				break;
			}
		case 'publish':
		case 'unpublish':
		default:
			submitform( action );
	}
}
</script>

<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_('FOLLOWING PUBLISHED CRITERIA WILL BE APPLIED FOR PROFILE COMPLETENESS');?>
</div>

<form action="<?php echo JURI::base();?>index.php?option=com_jspc" method="post" name="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr class="title">
			<th width="1%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->addonsInfo ); ?>);" />
			</th>
			<th>
				<?php echo JText::_( 'CRITERIA NAME' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'ADDON NAME' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'TOTAL' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'PUBLISHED' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'TOTAL CONTRIBUTION IN PERCENTAGE' ); ?>
			</th>
		</tr>		
	</thead>
<?php
	$count	= 0;
	$i		= 0;

	if(!empty($this->addonsInfo))
	foreach($this->addonsInfo as $addon)
	{
		$input	= JHTML::_('grid.id', $count, $addon->id);
		
		// Process publish / unpublish images
		++$i;
?>
		<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $addon->id;?>">
			<td><?php echo $i;?></td>
			<td>
				<?php echo $input; ?>
			</td>
			<td>
				<span class="editlinktip" title="<?php echo $addon->featurename; ?>" id="featurename<?php echo $addon->id;?>">
					<?php $link = JRoute::_('index.php?option=com_jspc&view=addons&task=renderaddon&editId='.$addon->id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $addon->featurename; ?></A>
				</span>
			</td>
			<td>
				<?php echo $addon->name; ?>
			</td>
			<td>
				<?php echo $this->totals[$addon->id]; ?>
			</td>
			<td align="center" id="published<?php echo $addon->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $addon->published ? 'unpublish' : 'publish' ?>')">
							<?php if($addon->published)
							{ ?>
								<img src="images/tick.png" width="16" height="16" border="0" alt="Published" />
							<?php 
							}
							else 
							{ ?>
								<img src="images/publish_x.png" width="16" height="16" border="0" alt="Unpublished" />
						<?php 
							} //echo $published;
						?>
				</a>
			</td>	
			<td>
				<?php echo $this->publishPercentage[$addon->id]." %"; ?>
			</td>	
		</tr>
<?php
		
		$count++;
	}
?>
	<tfoot>
	<tr>
		<td colspan="15">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
	</tfoot>
</table>



<input type="hidden" name="view" value="addons" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_jspc" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	
