<?php 
defined('_JEXEC') or die('Restricted access'); 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
 JHTML::_('behavior.tooltip'); ?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_jspc&view=addons');
JToolBarHelper::divider();
JToolBarHelper::apply('apply', JspcText::_('APPLY'));
JToolBarHelper::save('save',JspcText::_('SAVE'));
JToolBarHelper::cancel( 'cancel', JspcText::_('CLOSE' ));
?>
<?php 
$doc =& JFactory::getDocument();
$style = '#publish-values label{min-width:0px;clear:none;}'; 
$doc->addStyleDeclaration( $style );
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
			alert( "<?php echo JspcText::_( 'FEATURE_MUST_HAVE_A_NAME', true ); ?>" );
		} else {
			submitform(pressbutton);
		}
	}
</script>

<form action="index.php" method="post" name="adminForm">
<div>
<div class="col width-40" style="width:40%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo JspcText::_( 'Details' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" class="key">
				<label for="name" title=" <?php echo JspcText::_( 'NAME.DESC' ); ?> ">
					<?php echo JspcText::_( 'NAME' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->addonInfo['name']; ?>
			</td>
		</tr>
		<tr>
			<td width="100" class="key">
				<label for="featurename" title=" <?php echo JspcText::_( 'FEATURE_NAME.DESC' ); ?> ">
					<?php echo JspcText::_( 'FEATURE_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="featurename" id="featurename" size="35" value="<?php echo $this->addonInfo['featurename']; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
			<label for="published" title=" <?php echo JspcText::_( 'PUBLISHED.DESC' ); ?> ">
				<?php echo JspcText::_( 'PUBLISHED' ); ?>:
			</label>
			</td>
			<td>
				<div id="publish-values">
					<?php echo JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $this->addonInfo['published'] ); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
			<label for="contribution" title=" <?php echo JspcText::_( 'TOTAL_CONTRIBUTION_IN_PERCENTAGE' ); ?> ">
				<?php echo JspcText::_('CONTRIBUTION_IN_PERCENTAGE'); ?>:
			</label>
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
	<legend><?php echo JspcText::_( 'CORE_PARAMETERS' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('core-pane');
		//echo $pane->startPanel(JText :: _('Core Fields Parameters'), 'coreparam-page');
		echo $this->coreParamsHtml;
		//echo $pane->endPanel();
		?>
	</fieldset>
</div>
</div>
<div>
<div class="col width-60" style="width:60%; float:right;">
	<fieldset class="adminform">
	<legend><?php echo JspcText::_( 'ADDON_PARAMETERS' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = JPane::getInstance('sliders', array('allowAllClose' => true));
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
	<input type="hidden" name="editId" value="<?php echo $this->addonInfo['id'];?>" />
	<input type="hidden" name="id" value="<?php echo $this->addonInfo['id'];?>" />
	<input type="hidden" name="name" value="<?php echo $this->addonInfo['name'];?>" />
	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="view" value="addons" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
