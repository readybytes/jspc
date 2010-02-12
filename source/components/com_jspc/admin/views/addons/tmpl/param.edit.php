<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_jspc&view=addons');
JToolBarHelper::divider();
JToolBarHelper::apply('apply', JText::_('APPLY'));
JToolBarHelper::save('save',JText::_('SAVE'));
JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		if (pressbutton == "cancel") {
			submitform(pressbutton);
			return;
		}
		// validation
		var form = document.adminForm;
		if (form.featurename.value == "") {
			alert( "<?php echo JText::_( 'FEATURE MUST HAVE A NAME', true ); ?>" );
		} else {
			submitform(pressbutton);
		}
	}
</script>

<form action="index.php" method="post" name="adminForm">
<div>
<div class="col width-40" style="width:40%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'NAME' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->addonInfo['name']; ?>
			</td>
		</tr>
		<tr>
			<td width="100" class="key">
				<label for="featurename">
					<?php echo JText::_( 'FEATURE NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="featurename" id="featurename" size="35" value="<?php echo $this->addonInfo['featurename']; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
				<?php echo JText::_( 'PUBLISHED' ); ?>:
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $this->addonInfo['published'] ); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
				<?php echo JText::_('CONTRIBUTION IN PERCENTAGE'); ?>:
			</td>
			<td>
				<?php 
				if(!$this->isXiptExist)
					echo  round($this->percentage,2)." %";
				else
				{
					foreach($this->profileTypeArray as $ptypeId)
					{						
						echo $this->profileTypeName[$ptypeId];
						if(array_key_exists($ptypeId, $this->percentage))
					 		echo " : " . round($this->percentage[$ptypeId],2)." %";
					 	else
				 		    echo " : -"; 
				 	 	?><br/><?php    
					}
				}	
				?>
			</td>
		</tr>
		</table>
	</fieldset>
	<br />
	<br />
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Core Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('core-pane');
		//echo $pane->startPanel(JText :: _('Core Fields Parameters'), 'coreparam-page');
		echo $this->coreParamsHtml;
		//echo $pane->endPanel();
		?>
	</fieldset>
</div>
<div class="col width-60" style="width:60%; float:right;">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Addon Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('addon-pane');
		//echo $pane->startPanel(JText :: _('Addon Parameters'), 'addonparam-page');
		echo $this->addonParamsHtml;
		//echo $pane->endPanel();
	?>
	</fieldset>
</div>
</div>
<div class="clr"></div>

	<input type="hidden" name="option" value="com_jspc" />
	<input type="hidden" name="id" value="<?php echo $this->addonInfo['id'];?>" />
	<input type="hidden" name="name" value="<?php echo $this->addonInfo['name'];?>" />
	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="view" value="addons" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
