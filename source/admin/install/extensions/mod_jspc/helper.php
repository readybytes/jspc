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
		
		$css = JURI::root() .'modules/mod_jspc/style.css';		
		//include proper style sheet
		$document	= JFactory::getDocument();
		$document->addStyleSheet($css);
		

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
		ob_start();?>

			<?php // Vertical spacing
				if ($data['params']->get('SPS_Layout','horizontal')=='vertical')
				{	?>
				<div id="application-group">
					<div class="row-fluid">
					<?php 
					if ($data['params']->get('SPS_ShowAvatar',0))
					{
						$avatarWidth	= $data['params']->get('SPS_AvatarWidth', 100);
						$avatarHeight	= $data['params']->get('SPS_AvatarHeight', 100);
					?>
							<!--  show-avatar#start -->
							<div class="pull-left span7">
								<img class="jspc-avatar-img" src="<?php echo $data['avatar']; ?>" 
								 alt="<?php echo $data['name']; ?>" 
								 width="<?php echo $avatarWidth; ?>"
								 height="<?php echo $avatarHeight; ?>" />					
							</div>
							<div class="span5 pull-left">
									<div class="row-fluid">&nbsp;</div>
									<div class="row-fluid"><h3><?php echo $data['profile_completion_percentage'] ?>%</h3></div>
								</div>
							<!--  show-avatar#done -->
					<?php 
					}?>
					</div>
					<div class="row-fluid">
							<h6><?php echo JspcText::_("PERCENTAGE_COMPLETED");?></h6>
					</div>						
					<div class="row-fluid">
						<!-- show-completion-bar -->													
							<div class="progress progress-striped">
								<div class="bar jspc_bar" style="width:<?php echo $data['profile_completion_percentage'] ?>%;  background-color:<?php echo "#".$data['params']->get('SPS_FGColor',0)?>";"></div>
							</div>
						<!-- show-completion-bar#Done -->
							<p><?php echo JspcText::_("CLICK_ON_LINKS");?></p>
					</div>	
					<?php
				}else{	?>
					<div id="application-group" class="container-fluid">
								<div class="row-fluid">
								<?php 
								// if avatar required
								if ($data['params']->get('SPS_ShowAvatar',0))
								{
									$avatarWidth	= $data['params']->get('SPS_AvatarWidth', 100);
									$avatarHeight	= $data['params']->get('SPS_AvatarHeight', 100);
									?>
								
										<!--  show-avatar#start -->
										<div class="span2">
											<img class="jspc-avatar-img" src="<?php echo $data['avatar']; ?>" 
											 alt="<?php echo $data['name']; ?>" 
											 width="<?php echo $avatarWidth; ?>"
											 height="<?php echo $avatarHeight; ?>" />					
										</div>
										<!--  show-avatar#done -->
								<?php
								}?>
										<div class="span8">					
											<div class="row-fluid">
												&nbsp;
											</div>
											<div class="row-fluid">
												<h3><?php echo JspcText::_("PERCENTAGE_COMPLETED");?></h3>
											</div>						
											<div class="row-fluid">
												<!-- show-completion-bar -->													
												<div class="progress progress-striped jspc_bar">
														<div class="bar jspc_bar" style="width:<?php echo $data['profile_completion_percentage'] ?>%;  background-color:<?php echo "#".$data['params']->get('SPS_FGColor',0)?>";"></div>
												</div>
												<!-- show-completion-bar#Done -->
											</div>						
										</div>
										
										<div class="span2">
											<div class="row-fluid">&nbsp;</div>
											<div class="row-fluid"><h1><?php echo $data['profile_completion_percentage'] ?>%</h1></div>
										</div>
								</div>
									
								<div class="row-fluid jspc_completion_text">
									<?php echo $data['displayText']; ?>
								</div>
				<?php 				
				}?>	
								<div class="row-fluid">
									<?php 
										if($data['profile_completion_percentage'] != 100)
										{?>
										<table class="table table-hover table-striped" style="margin-top:10px;">
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
														<tr>
															<td><a id="jspc_incomplete_link_<?php echo $key;?>" href="<?php echo $nextTask['link'];?>"><i class="icon-plus"></i><?php echo $nextTask['text'];?></a></td>
															<td><a id="jspc_incomplete_link_<?php echo $key;?>" href="<?php echo $nextTask['link'];?>"><?php echo $value."%";?></a></td>
														</tr>
														<?php
														if(is_numeric($visibleFeatureCount)) 
															$visibleFeatureCount--;
													}?>							
										</table>
										<?php 
										}?>
								</div>	
							</div>
				
			
		<?php 
		$contents	= ob_get_contents();
		ob_end_clean();
		return $contents;
	}	
}
?>