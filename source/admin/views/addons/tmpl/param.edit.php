<?php 
defined('_JEXEC') or die('Restricted access'); 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

JToolBarHelper::back('Home' , 'index.php?option=com_jspc&view=cpanel');
JToolBarHelper::divider();
JToolBarHelper::apply('apply', JspcText::_('APPLY'));
JToolBarHelper::save('save',JspcText::_('SAVE'));
JToolBarHelper::cancel( 'cancel', JspcText::_('CLOSE' ));

$doc = JFactory::getDocument();
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

(function($){

	$(document).ready(function(){
						
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
})(joms.jQuery);
</script>

<form action="index.php" method="post" name="adminForm" id="adminform">
<div>
<div class="col span6" style="float:left;">
	<fieldset class="adminform">
	<h3><?php echo JspcText::_( 'Details' ); ?></h3><hr>
	<table class="admintable">
		<tr>
			<td width="150" class="key">
				<label for="name" title=" <?php echo JspcText::_( 'NAME_DESC' ); ?> ">
					<?php echo JspcText::_( 'NAME' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->addonInfo['name']; ?>
			</td>
		</tr>
		<tr>
			<td width="150" class="key">
				<label for="featurename" title=" <?php echo JspcText::_( 'FEATURE_NAME_DESC' ); ?> ">
					<?php echo JspcText::_( 'FEATURE_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="featurename" id="featurename" size="35" value="<?php echo $this->addonInfo['featurename']; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
			<label for="published" title=" <?php echo JspcText::_( 'PUBLISHED_DESC' ); ?> ">
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
				if(!$this->profilesExist)
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
	<h3><?php echo JspcText::_( 'CORE_PARAMETERS' ); ?></h3><hr>
	<table class="admintable">
			<?php foreach ($this->form->getFieldset('coreparams') as $field):?>
			<?php $class = $field->group.$field->fieldname; ?>
			<tr>
				<td valign="top"  width="150" class="key <?php echo $class;?>">
					<label for="coreparameters"><?php echo $field->label; ?> </label>
				</td>
			
				<td><?php echo $field->input; ?>
				<?php if($field->fieldname === 'integrate_with'){ ?>
					<p class="muted"><i><b><?php echo JspcText::_('INTEGRATE_WITH_HELP_MESSAGE');?></b></i></p>
				<?php }?>	
				</td>	
			</tr>					
				<?php endforeach;?>
		</table>
	</fieldset>
</div>
</div>
<div>
<div class="col span6" style="float:left;">
	<fieldset class="adminform">
	<h3><?php echo JspcText::_( 'ADDON_PARAMETERS' ); ?></h3><hr>
	<table class="admintable">
		<?php foreach ($this->form->getFieldset('addonparams') as $field):?>
			<?php $class = $field->group.$field->fieldname; ?>
			<tr>
				<td valign="top" width="150" class="key <?php echo $class;?>">
					<label><?php echo $field->label; ?> </label>
				</td>
				<td><?php echo $field->input; ?></td>	
			</tr>							
		<?php endforeach;?>
	</table>
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
