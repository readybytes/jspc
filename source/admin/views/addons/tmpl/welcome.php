<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
	?>
<form action="<?php echo $uri; ?>" method="post" name="adminForm">
	<div class="row-fluid">
		<div class="span12">
			<p class="lead center"><?php echo JspcText::_('ABOUT_US_HEADING'); ?></p>
			<p class="center"><?php echo JspcText::_('ABOUT_US_MESSAGE'); ?></p>
		</div>
		<div>&nbsp;</div>
		<div class="center">
			<a href="http://www.joomlaxi.com/support/forum.html" target="_blank" class="btn disabled"><i class="icon-question-sign "></i>&nbsp;<?php echo JspcText::_('SUPPORT');?></a>
			<a href="http://www.joomlaxi.com/jomsocial-profiles-completeness.html" target="_blank" class="btn disabled"><i class="icon-book"></i>&nbsp;<?php echo JspcText::_('DOCUMENTATION');?></a>
		</div>
		
	</div> 
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<?php
