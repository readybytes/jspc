<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class ProfileCompleteHelper
{

	static function getJspcHTML($userId, &$mod_params)
	{
		// if no user id return blank
		if(empty($userId) || $userId == '0' || $userId == 0){
			return "";
		}
				
		$params 	=& $mod_params;
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

		// In joomla 2.5 Load bootstrap if not loaded
		$version = new JVersion();
		if($version->RELEASE === '2.5')
		{
			if($params->get('Bootstrap_CSS',1))
			{
				$bootstarpCss	= JURI::base().'administrator/components/com_community/installer/css/bootstrap.min.css';
				$document->addStyleSheet($bootstarpCss);
		
				$bootstarpResCss	= JURI::base().'administrator/components/com_community/installer/css/bootstrap-responsive.min.css';
				$document->addStyleSheet($bootstarpResCss);
			}	
		}

		
		$fillValue 						= JspcLibrary::calulateFillCountOfUser($userId);
		$totalValue 					= JspcLibrary::calulateTotalCount($userId);
		$profile_completion_percentage 	= JspcLibrary::calulatePCPercentage($userId);

		//get array of those feature which is not complete
		$incomplete_feature = JspcLibrary::getIncompleteFeatures($userId);
		JspcLibrary::roundOffPercentage($incomplete_feature, $profile_completion_percentage);
		
		//if profile is 100% complete then do not show module
		$showProfile = $params->get('showProfile','1');
		if($showProfile == 0 && $profile_completion_percentage == 100)
			return;
		
		$data 									= JspcLibrary::getDisplayInformationOfUser($userId,'avatar');
		$data['userId']							= $userId;
		$data['incomplete_feature']				= $incomplete_feature ;
		$data['profile_completion_percentage']	= $profile_completion_percentage;
		
		$percentStyling = '<span class="strong label" style="background-color:#'.$params->get('SPS_FGColor',0).'">'.$profile_completion_percentage.'% </span>';
		if($profile_completion_percentage == 100)
			$displayText    = sprintf(JText::_('MOD_JSPC_PROFILE_STATUS_COMPLETION_100'),$percentStyling);
		else
			$displayText    = sprintf(JText::_('MOD_JSPC_PROFILE_STATUS_COMPLETION'),$percentStyling);
		
		$data['displayText']					= $displayText;
		$data['params']							= $params;
		return self::_getDisplay($data);
	}
	
	
	static function _getDisplay($data = array())
	{
		ob_start();	?>
		<div id="application-group">
			<?php 
			// if avatar required
			if ($data['params']->get('SPS_ShowAvatar',0))
			{
				$avatarWidth	= $data['params']->get('SPS_AvatarWidth', 100);
				$avatarHeight	= $data['params']->get('SPS_AvatarHeight', 100);
				?>
					
				<!--  show-avatar#start --> 
				<div class="jspc_avatar">
					<img src="<?php echo $data['avatar']; ?>" 
						 alt="<?php echo $data['name']; ?>" 
						 width="<?php echo $avatarWidth; ?>"
						 height="<?php echo $avatarHeight; ?>" />
				</div>
				
				<div>&nbsp;</div>
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
				<div class="jspc_column2">
					<div class="progress progress-striped">
						<div class="bar" style="width:<?php echo $data['profile_completion_percentage'] ?>%;  background-color:<?php echo "#".$data['params']->get('SPS_FGColor',0)?>";"></div></div> 
					<div class="jspc_completion_text">
						<p><?php echo $data['displayText']; ?></p>
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
					<ul class="unstyled" id="jspc_completion_links">
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
								 <a id="jspc_incomplete_link_<?php echo $key;?>" href="<?php echo $nextTask['link'];?>">
								 	<i class="icon-plus"></i>
									<?php echo $value."% &nbsp".$nextTask['text'];?> 				
								 </a>
			
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
