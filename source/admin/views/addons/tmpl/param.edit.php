<?php 
defined('_JEXEC') or die('Restricted access'); 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

JToolBarHelper::back('Home' , 'index.php?option=com_jspc&view=addons');
JToolBarHelper::divider();
JToolBarHelper::apply('apply', JspcText::_('APPLY'));
JToolBarHelper::save('save',JspcText::_('SAVE'));
JToolBarHelper::cancel( 'cancel', JspcText::_('CLOSE' ));

$doc =& JFactory::getDocument();
$style = '#publish-values label{min-width:0px;clear:none;}'; 
$doc->addStyleDeclaration( $style );
?>
<script language="javascript" type="text/javascript">
Joomla.submitbutton = function(action){
	submitbutton( action );
}
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

<script type="text/javascript">

		jQuery(document).ready(function($) {
						
			$("select#coreparamsintegrate_with").change(function() {
				
				$("#coreparams\\[jspc\\_multiprofile\\]").attr("disabled", "disabled");
				$("#coreparams\\[jspc\\_profiletype\\]").attr("disabled", "disabled");
				
				if(this.value === 'multiprofile') {
					$("#coreparams\\[jspc_multiprofile\\]").removeAttr('disabled');
					$("#coreparams\\[jspc_profiletype\\]").attr("disabled", "disabled");
				}
				if(this.value === 'jspt') {
					$("#coreparams\\[jspc_profiletype\\]").removeAttr('disabled');
				}
			});

			$('#coreparamsintegrate_with').change();
		});
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="row-fluid">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo JspcText::_('Details' ); ?> </legend>
		
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>				
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('featurename'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('featurename'); ?></div>				
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('published'); ?></div>				
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('percentage'); ?></div>
				<div class="controls">
				<?php 
					if(!$this->profilesExist){
						echo  round($this->percentage,2)." %";
					}
					else
					{
						foreach($this->profileTypeArray as $ptypeId)
						{						
							echo $this->profileTypeName[$ptypeId];
							if(array_key_exists($ptypeId, $this->percentage)){
						 		echo " : " . round($this->percentage[$ptypeId],2)." %";
							}
						 	else {
					 		    echo " : -"; 
						 	}
					 	 	?><br/><?php    
						}
					}	?>
				</div>				
			</div>
	</fieldset>	
	
	<fieldset class="form-horizontal">
				<legend> <?php echo JspcText::_('CORE_PARAMETERS' ); ?> </legend>
				<?php foreach ($this->form->getFieldset('coreparams') as $field):?>
					<?php $class = $field->group.$field->fieldname; ?>
					<div class="control-group <?php echo $class;?>">
						<div class="control-label"><?php echo $field->label; ?> </div>
						<div class="controls"><?php echo $field->input; ?></div>								
					</div>
				<?php endforeach;?>
		</fieldset>
	
	</div>
	
	<div class="span6">
		<fieldset class="form-horizontal">
				<legend> <?php echo JspcText::_('ADDON_PARAMETERS' ); ?> </legend>
				<?php foreach ($this->form->getFieldset('addonparams') as $field):?>
					<?php $class = $field->group.$field->fieldname; ?>
					<div class="control-group <?php echo $class;?>">
						<div class="control-label"><?php echo $field->label; ?> </div>
						<div class="controls"><?php echo $field->input; ?></div>								
					</div>
				<?php endforeach;?>
		</fieldset>
	</div>
</div>		
	<input type="hidden" name="option" value="com_jspc" />
	<input type="hidden" name="editId" value="<?php echo $this->addonInfo['id'];?>" />
	<input type="hidden" name="id" value="<?php echo $this->addonInfo['id'];?>" />
	<input type="hidden" name="name" value="<?php echo $this->addonInfo['name'];?>" />
	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="view" value="addons" />
	<input type="hidden" name="task" value="" />
	
</form>
