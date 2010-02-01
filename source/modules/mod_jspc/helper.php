<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class ProfileCompleteHelper
{

	function getJspcHTML($userId, &$mod_params)
	{
		if(empty($userId) || $userId == '0' || $userId == 0)
			return "";
			
		$params =& $mod_params;
		
		$document	= JFactory::getDocument();
		if ($params->get('SPS_Layout','horizontal')=='vertical')
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
		
		$imageGenerator = new JspcImageGenerator($params);
		$filename	= $imageGenerator->createPercentageBarImageFile('mod_',$profile_completion_percentage);
		
		$whichAvatar = 'thumb';
		
		if ($params->get('SPS_Layout','horizontal')=='vertical')
			$whichAvatar	= 'avatar';
			
		$data = JspcLibrary::getDisplayInformationOfUser($userId,$whichAvatar);
		$data['userId']							= $userId;
		$data['filename'] 						= $filename;
		$data['incomplete_feature']				= $incomplete_feature ;
		$data['profile_completion_percentage']	= $profile_completion_percentage;
		
		$percentStyling = '<span class="SPS_SpanPer" style="color:#'. $params->get('SPS_FGColor','9CD052').'">'.$profile_completion_percentage.'% </span>';
		$displayText    = sprintf(JText::_('PROFILE STATUS COMPLETION'),$percentStyling);
		
		$data['displayText']					= $displayText;
		$data['params']							= $params;
		return self::_getDisplay($data);
		
	}
	
	
	function _getDisplay($data = array())
	{
		ob_start();	?>
		<?php // if avatar required
		if ($data['params']->get('SPS_ShowAvatar',0))
		{	?>
		<div style="float:left">
			<img src="<?php echo $data['avatar']; ?>" 
						alt="<?php echo $data['name']; ?>" 
						style="padding: 2px; border: solid 1px #ccc;" />
		</div>
			<?php
		}	
		
		// Vertical spacing
		if ($data['params']->get('SPS_Layout','horizontal')=='vertical')
		{	?>
			<div class="clr"></div>
			<?php
		}	?>
		
		<div class="SPS_CompletionBar">
			<img src="<?php echo $data['filename'];?>"> 
			<br /><br />
			<?php echo $data['displayText'];?> 
		</div>
		
		<?php // Vertical spacing
		if ($data['params']->get('SPS_Layout','horizontal')=='vertical')
		{	?>
			<div class="clr"></div>
			<?php
		}	?>
		
		<?php 
	   	if($data['profile_completion_percentage'] != 100)
	   	{?>				
	   		<div class="SPS_CompleteMessage">
				<ul id="featurelist">
				<?php
					$total =  100 - $data['profile_completion_percentage'];
					foreach($data['incomplete_feature'] as $key => $value)
					{
						$nextTask	= JspcLibrary::getCompletionLink($key,$data['userId']);
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
