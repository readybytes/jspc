<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class ProfileCompleteHelper
{

	function getJspcHTML($userId, &$mod_params)
	{
		// if no user id return blank
		if(empty($userId) || $userId == '0' || $userId == 0)
			return "";
			
		$params =& $mod_params;
		//include proper style sheet
		$document	= JFactory::getDocument();
		
		$hcss = JURI::root() .'modules/mod_jspc/style.css';
		$vcss = JURI::root() .'modules/mod_jspc/style.vert.css';
		
		//include proper style sheet
		$document	= JFactory::getDocument();
		if ($params->get('SPS_Layout','horizontal')=='vertical')
			$document->addStyleSheet($vcss);
		else
			$document->addStyleSheet($hcss);

		
		$fillValue = JspcLibrary::calulateFillCountOfUser($userId);
		$totalValue = JspcLibrary::calulateTotalCount($userId);
		$profile_completion_percentage = JspcLibrary::calulatePCPercentage($userId);

		//get array of those feature which is not complete
		$incomplete_feature = JspcLibrary::getIncompleteFeatures($userId);
		JspcLibrary::roundOffPercentage($incomplete_feature, $profile_completion_percentage);
		
		//if profile is 100% complete then do not show module
		$showProfile = $params->get('showProfile','1');
		if($showProfile == 0 && $profile_completion_percentage == 100)
			return;
		
		$imageGenerator = new JspcImageGenerator($params);
		$filename		= $imageGenerator->createPercentageBarImageFile('mod_',$profile_completion_percentage);
		
		$urlpath = JspcLibrary::getUrlpathFromFilePath($filename);	
		
		$data = JspcLibrary::getDisplayInformationOfUser($userId,'avatar');
		$data['userId']							= $userId;
		$data['filename'] 						= $urlpath;
		$data['incomplete_feature']				= $incomplete_feature ;
		$data['profile_completion_percentage']	= $profile_completion_percentage;
		
		$percentStyling = '<span class="jspc_percentage" style="color:#'. $params->get('SPS_FGColor','9CD052').'">'.$profile_completion_percentage.'% </span>';
		if($profile_completion_percentage == 100)
			$displayText    = sprintf(JText::_('MOD_JSPC_PROFILE_STATUS_COMPLETION_100'),$percentStyling);
		else
			$displayText    = sprintf(JText::_('MOD_JSPC_PROFILE_STATUS_COMPLETION'),$percentStyling);
		
		$data['displayText']					= $displayText;
		$data['params']							= $params;
		return self::_getDisplay($data);
	}
	
	
	function _getDisplay($data = array())
	{
		ob_start();	?>
		<div id="application-group">
		<?php 
		// if avatar required
		if ($data['params']->get('SPS_ShowAvatar',0))
		{
			$avatarWidth=$data['params']->get('SPS_AvatarWidth', 100);
			$avatarHeight=$data['params']->get('SPS_AvatarHeight', 100);
			?>
				
		<!--  show-avatar#start --> 
		<div class="jspc_avatar">
			<img src="<?php echo $data['avatar']; ?>" 
						alt="<?php echo $data['name']; ?>" 
						width="<?php echo $avatarWidth; ?>"
						height="<?php echo $avatarHeight; ?>"
						/>
		</div>
		<!--  show-avatar#done -->
		<?php
		}	
		
		// Vertical spacing
		if ($data['params']->get('SPS_Layout','horizontal')=='vertical')
		{	?>
			<div class="clr"></div>
			<?php
		}	?>
		
		<!-- show-completion-bar -->		
		<div class="jspc_column2" style="width:<?php echo $data['params']->get('SPS_Length','1') +20 ; ?>px;">
			<div class="jspc_completion_bar">
				<img src="<?php echo $data['filename'];?>">
			</div> 
			<div style="jspc_completion_text"><?php
						echo $data['displayText']; ?>
			</div>
		</div>
		<!-- show-completion-bar#Done -->
		
		<?php // Vertical spacing
		if ($data['params']->get('SPS_Layout','horizontal')=='vertical')
		{	?>
			<div class="clr"></div>
			<?php
		}	?>
		
		<?php 
		if($data['profile_completion_percentage'] != 100)
	   	{?>				
	   		<div class="jspc_column3">
			<ul id="jspc_completion_links">
			<?php
				$visibleFeatureCount=$data['params']->get('SPS_VisibleFeatureNumber','all');
				if(!is_numeric($visibleFeatureCount) && strtolower($visibleFeatureCount)!='all')
					$visibleFeatureCount=0;
				foreach($data['incomplete_feature'] as $key => $value)
				{
					if(!$visibleFeatureCount)
						break;
					
					$nextTask	      = JspcLibrary::callAddonFunction($key, 'getCompletionLink', $data['userId']);
					$nextTask['text'] = preg_replace("/COM_JSPC_/", "", $nextTask['text']);
					?>
					<li> 
						<span class="jspc_link_percent"> <?php echo $value; ?>% &nbsp; </span>
						<span class="jspc_link_text"> 
							 <a id="jspc_incomplete_link_<?php echo $key;?>" href="<?php echo $nextTask['link'];?>"> 
								<?php echo $nextTask['text'];?> 
							</a>
						</span>
					</li>
					<?php
					if(is_numeric($visibleFeatureCount)) 
						$visibleFeatureCount--;
				}?>
			</ul>
			</div><?php 
		}?>
		<!-- show-column3#done -->
			
		</div>
		<div style='clear:both;'></div>
		<?php
		$contents	= ob_get_contents();
		ob_end_clean();
		return $contents;
	}
}
