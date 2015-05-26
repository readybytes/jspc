<?php


// no direct access
defined('_JEXEC') or die('Restricted access');


class plgCommunityJspc extends CApplications
{
	var $name 		= "Profile Completion";
	var $_name		= 'jspc';
	var $_path		= '';
	var $_user		= '';
	var $_my		= '';
	var $_params	= '';
	var $plugin		= '';
	var $isIncludes = '';
	
	function plgCommunityJspc(& $subject, $config)
    {
		parent::__construct($subject, $config);
		$this->_path	= dirname( dirname( JPATH_ROOT ) ).'/administrator/components/com_community'; 
		$this->plugin 	= JPluginHelper::getPlugin('community', $this->_name); 		
		$this->_params 	= new JRegistry($this->plugin->params);		
    }
    
    
    function includes()
    {
		if($this->isIncludes)
			return true;
			
		$this->isIncludes = true;	
    	jimport( 'joomla.filesystem.folder' );
		
		$jspcPath = JPATH_ROOT.'/components/com_jspc';
		
		if(!JFolder::exists($jspcPath))
			return false;
		
		require_once( JPATH_ROOT.'/components/com_jspc/includes.jspc.php');

		$communityPath = JPATH_ROOT.'/components/com_community';

		if(!JFolder::exists($communityPath))
			return false;
		
		//community files
		require_once(JPATH_ROOT.'/components/com_community/libraries/core.php' );
		require_once (JPATH_ROOT.'/components/com_community/helpers/owner.php');
			
		JPlugin::loadLanguage( 'plg_jspc', JPATH_ADMINISTRATOR );
		
		$document	= JFactory::getDocument();
		$css		= JURI::base() .'plugins/community/jspc/jspc/style.css';
		$document->addStyleSheet($css);

		return true;
    }

	
	function onProfileDisplay()
	{
		//xitodo : display message to admin
		if(!$this->includes())
			return;
		
		$my			= CFactory::getUser();
		$user		= CFactory::getActiveProfile();
		
		// Do not stop admins
		if(isSuperAdministrator())
			$my	= $user;
		else if ($my->_userid != $user->_userid)
			return;
		
		return $this->_getJspcHTML($my->_userid); 
	}
	
	function _getJspcHTML($userId)
	{		
		$fillValue 	= JspcLibrary::calulateFillCountOfUser($userId);
		$totalValue = JspcLibrary::calulateTotalCount($userId);		
		$profile_completion_percentage = JspcLibrary::calulatePCPercentage($userId);
		
		//get array of those feature which is not complete
		$incomplete_feature = JspcLibrary::getIncompleteFeatures($userId);
		JspcLibrary::roundOffPercentage($incomplete_feature, $profile_completion_percentage);
		
		//if profile is 100% complete then do not show plugin
		$showProfile = $this->_params->get('showProfile','1');
		if($showProfile == 0 && $profile_completion_percentage == 100)
			return;
		
		$data = JspcLibrary::getDisplayInformationOfUser($userId,'avatar');
		$data['userId']							= $userId;
		$data['incomplete_feature']				= $incomplete_feature ;
		$data['profile_completion_percentage']	= $profile_completion_percentage;
		
		$percentStyling = '<span class="strong label" style="background-color:#'.$this->_params->get('SPS_FGColor',0).'">'.$profile_completion_percentage.'% </span>';
		if($profile_completion_percentage == 100)
			$displayText    = sprintf(JText::_('PLG_JSPC_PROFILE_STATUS_COMPLETION_100'),$percentStyling);
		else
			$displayText    = sprintf(JText::_('PLG_JSPC_PROFILE_STATUS_COMPLETION'),$percentStyling);
		
		$data['displayText']					= $displayText;
		$data['params']							= $this->_params;
		return $this->_getDisplay($data);
	}
	
	static function _getDisplay($data = array())
	{
		$params = $data['params'];
		if($params->get('Bootstrap_CSS',0))
		{
			// Load bootstrap
			JHtmlBootstrap::loadCss();
		}
		ob_start();?>
		<div id="application-group" class="container-fluid">
		
			<?php 
			// if avatar required
			if ($data['params']->get('SPS_ShowAvatar',0))
			{
				$avatarWidth	= $data['params']->get('SPS_AvatarWidth', 100);
				$avatarHeight	= $data['params']->get('SPS_AvatarHeight', 100);
				?>
				
						<div class="row-fluid">					
							<!--  show-avatar#start -->
							<div class="pull-left span2">
								<img class="jspc_plugin_avatar-img" src="<?php echo $data['avatar']; ?>" 
								 alt="<?php echo $data['name']; ?>" 
								 width="<?php echo $avatarWidth; ?>"
								 height="<?php echo $avatarHeight; ?>" />					
							</div>
							<!--  show-avatar#done -->
							
							<div class="span8">					
								<div class="row-fluid">
									&nbsp;
								</div>
								<div class="row-fluid">
									<h3><?php echo JText::_("PLG_JSPC_PERCENTAGE_COMPLETED");?></h3>
								</div>						
								<div class="row-fluid">
									<!-- show-completion-bar -->													
									<div class="progress progress-striped">
											<div class="bar jspc_plugin_bar" style="width:<?php echo $data['profile_completion_percentage'] ?>%;  background-color:<?php echo "#".$data['params']->get('SPS_FGColor',0)?>";"></div>
									</div>
									<!-- show-completion-bar#Done -->
								</div>						
							</div>
							
							<div class="span2">
								<div class="row-fluid">&nbsp;</div>
								<div class="row-fluid"><h1><?php echo $data['profile_completion_percentage'] ?>%</h1></div>
							</div>
						</div>
						
						<div class="row-fluid jspc_plugin_completion_text">
							<?php echo $data['displayText']; ?>
						</div>
						
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
				
				
				
				<?php
				}?>
		</div>
		<?php 
		$contents	= ob_get_contents();
		ob_end_clean();
		return $contents;
	}	
}

