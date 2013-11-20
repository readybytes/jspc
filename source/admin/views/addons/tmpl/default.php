<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
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
			if( !confirm( '<?php echo JspcText::_('ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THIS_CRITERIA'); ?>' ) )
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

<div class="alert alert-info">
	<strong><?php echo JspcText::_('FOLLOWING_PUBLISHED_CRITERIA_WILL_BE_APPLIED_FOR_PROFILE_COMPLETENESS');?></strong>
</div>
<div>&nbsp;</div>

<form action="<?php echo JURI::base();?>index.php?option=com_jspc" method="post" name="adminForm" id="adminForm" class="jspc">
  <table class="table table-hover">
    <thead>
		<!-- TABLE HEADER START -->
			<tr>
				<th class="default-grid-sno"><?php echo JspcText::_('NUM'); ?></th> 
        		
				<th  width="1%">
					<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
				</th>		
				
				<th><?php echo JspcText::_('CRITERIA_NAME'); ?></th>
				<th><?php echo JspcText::_('ADDON_NAME'); ?></th>
				<?php if($this->profilesExist && $this->integrate_with != 'none'){?>
					<th><?php echo JspcText::_( 'PROFILE_TYPE' ); ?></th>
				<?php }?>
				<th><?php echo JspcText::_( 'TOTAL_WEIGHTAGE' ); ?></th>
				<?php if($this->profilesExist == false || $this->integrate_with == 'none') {?>
					<th><?php echo JspcText::_( 'TOTAL_CONTRIBUTION_IN_PERCENTAGE' ); ?></th>
				<?php }
					else
					{
						if(isset($this->profileTypeName))
							foreach($this->profileTypeName as $ptype){?>
								<th><?php echo $ptype;?></th>
						<?php }	
						}?>
			
			<th><?php echo JspcText::_( 'PUBLISHED' ); ?></th>
				
		</tr>
		<!-- TABLE HEADER END -->
		</thead>
		<?php $count	= 0;
			  $i		= 0;
	
			if(!empty($this->addonsInfo))
				foreach($this->addonsInfo as $addon)
				{
					$input	= JHTML::_('grid.id', $count, $addon->id);
			
					// Process publish / unpublish images
					++$i; ?>
		
		<tbody>
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
			<?php if($this->profilesExist && $this->integrate_with != 'none'){?>
			<td>
				<?php if(!empty($this->addonProfiletype)):?>
				<?php echo $this->addonProfiletype[$addon->id]; ?>
				<?php endif;?>
			</td>
			<?php }?>
			<td>
				<?php echo $this->totals[$addon->id]; ?>
			</td>
			
			<?php 
			if($this->profilesExist && $this->integrate_with != 'none')
			{		
				foreach($this->profileTypeArray as $ptypeId)
				{
				?>	
				<td>
					<?php 
						if(array_key_exists($ptypeId, $this->publishPercentage[$addon->id]))
							echo round($this->publishPercentage[$addon->id][$ptypeId],2)." %";
						else
							echo " - "; 
					?>
				</td>	
				<?php 
				}
			}
			else {?>
			<td>
			<?php echo round($this->publishPercentage[$addon->id],2)." %"; ?>
			</td>
			<?php } ?>
			
			<td align="center" id="published<?php echo $addon->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $addon->published ? 'unpublish' : 'publish' ?>')">
							<?php if($addon->published)
							{ ?>
								<img src="components/com_jspc/assets/images/tick.png" width="16" height="16" border="0" alt="Published" />
							<?php 
							}
							else 
							{ ?>
								<img src="components/com_jspc/assets/images/publish_x.png" width="16" height="16" border="0" alt="Unpublished" />
						<?php 
							} //echo $published;
						?>
				</a>
			</td>
		</tr>
	<?php
		$count++;
	} ?>
	</tbody>
    
  </table>
  
  		<div class="row">
     		<div class="offset5 span7"><?php echo $this->pagination->getListFooter(); ?></div>
   		</div> 
  
<input type="hidden" name="view" value="addons" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_jspc" />
<input type="hidden" name="boxchecked" value="0" />
</form>
