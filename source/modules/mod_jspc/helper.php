<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class ProfileCompleteHelper
{
	var $params = '';

		function getJspcHTML($userId, &$mod_params)
		{
			if(empty($userId) || $userId == '0' || $userId == 0)
				return "";
				
			$this->params =& $mod_params;
			
			$document	= JFactory::getDocument();
			if ($this->params->get('SPS_Layout','horizontal')=='vertical')
				$document->addStyleSheet('modules/mod_jspc/style.vert.css');
			else
				$document->addStyleSheet('modules/mod_jspc/style.css');

			$fillValue = JspcLibrary::calulateFillCountOfUser($userId);
			$totalValue = JspcLibrary::calulateTotalCount($userId);

			if($totalValue == 0)
				$profile_completion_percentage = 100;
			else
				$profile_completion_percentage = ($fillValue/$totalValue)*100;
					
			//get array of those feature which is not complete
			$incomplete_feature = JspcLibrary::getIncompleteFeatures($userId);
			arsort($incomplete_feature);
					
			$profile_completion_percentage = round($profile_completion_percentage,1	);
			
			$imageGenerator = new JspcImageGenerator($this->params);
			$filename	= $imageGenerator->createPercentageBarImageFile('mod_',$profile_completion_percentage);
			
			$my =& CFactory::getUser();
			$myLink=JRoute::_('index.php?option=com_community&view=profile&userid='.$my->id);
			$myName	=$my->getDisplayName();
			if ($this->params->get('SPS_Layout','horizontal')=='vertical')
				$myAvatar=$my->getAvatar();
			else
				$myAvatar=$my->getThumbAvatar();
				
			ob_start();	?>
				<?php // if avatar required
				if ($this->params->get('SPS_ShowAvatar',0))
				{	?>
				<div style="float:left">
					<img src="<?php echo $myAvatar; ?>" 
								alt="<?php echo $myName; ?>" 
								style="padding: 2px; border: solid 1px #ccc;" />
				</div>
					<?php
				}	?>
				
				
				<?php // Vertical spacing
				if ($this->params->get('SPS_Layout','horizontal')=='vertical')
				{	?>
					<div class="clr"></div>
					<?php
				}	?>
				
				<div class="SPS_CompletionBar">
					<img src="<?php echo $filename;?>"> 
					<br /><br />
					<div style="SPS_CompletionText">
					Your Profile is <span class="SPS_SpanPer" style="color:#<?php echo $this->params->get('SPS_FGColor','9CD052'); ?>;"><?php echo $profile_completion_percentage;?>%</span> complete. 
					</div>
				</div>
				
				<?php // Vertical spacing
				if ($this->params->get('SPS_Layout','horizontal')=='vertical')
				{	?>
					<div class="clr"></div>
					<?php
				}	?>
				
				<?php 
			   	if($profile_completion_percentage != 100)
			   	{?>				
		   		<div class="SPS_CompleteMessage">
					<ul id="featurelist">
					<?php
						$total =  100 - $profile_completion_percentage;
						foreach($incomplete_feature as $key => $value)
						{
							$nextTask	= JspcLibrary::getCompletionLink($key,$userId);
							$value 		= round($value,1);
							if($value > $total)
								$value = $total;
							$total -= $value;?>
							<li> <?php echo $value; ?>% &nbsp;
								<a class="SPS_JSMessage" href="<?php echo JRoute::_($nextTask['link'],false); ?>"> 
									<?php echo $nextTask['text'];?> 
								</a>
							</li><?php
						}?>
					</ul>
				</div><?php 
				}?>
			<div class="clr"></div>
			<?php
			$contents	= ob_get_contents();
			ob_end_clean();
			return $contents;
		}
}
