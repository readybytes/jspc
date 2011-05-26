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
		$this->_path	= dirname( dirname( JPATH_ROOT ) ) . DS . 'administrator' . DS . 'components' . DS . 'com_community'; 
		$this->plugin =& JPluginHelper::getPlugin('community', $this->_name); 		
		$this->_params 	= new JParameter($this->plugin->params);		
    }
    
    
    function includes()
    {
		if($this->isIncludes)
			return true;
			
		$this->isIncludes = true;	
    	jimport( 'joomla.filesystem.folder' );
		
		$jspcPath = JPATH_ROOT.DS.'components'.DS.'com_jspc';
		
		if(!JFolder::exists($jspcPath))
			return false;
		
		require_once( JPATH_ROOT . DS . 'components' . DS . 'com_jspc'  . DS . 'includes.jspc.php');

		$communityPath = JPATH_ROOT.DS.'components'.DS.'com_community';

		if(!JFolder::exists($communityPath))
			return false;
		
		//community files
		require_once(JPATH_ROOT.DS.'components'.DS.'com_community' . DS . 'libraries' . DS . 'core.php' );
		require_once (JPATH_ROOT. DS.'components'.DS.'com_community'.DS.'helpers'.DS.'owner.php');
			
		JPlugin::loadLanguage( 'plg_jspc', JPATH_ADMINISTRATOR );
		
		$document	= JFactory::getDocument();
		$document->addStyleSheet('plugins/community/jspc/style.css');
		return true;
    }

	
	function onProfileDisplay()
	{
		//xitodo : display message to admin
		if(!$this->includes())
			return;
		
		$my			=& CFactory::getUser();
		$user		=& CFactory::getActiveProfile();
		
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
		
		//generate image
		$imageGenerator = new JspcImageGenerator($this->_params);
		$filename	= $imageGenerator->createPercentageBarImageFile('plg_',$profile_completion_percentage);

		$urlpath = JspcLibrary::getUrlpathFromFilePath($filename);

		$data = JspcLibrary::getDisplayInformationOfUser($userId,'avatar');
		$data['userId']							= $userId;
		$data['filename'] 						= $urlpath;
		$data['incomplete_feature']				= $incomplete_feature ;
		$data['profile_completion_percentage']	= $profile_completion_percentage;
		
		$percentStyling = '<span class="jspc_percentage" style="color:#'. $this->_params->get('SPS_FGColor','9CD052').'">'.$profile_completion_percentage.'% </span>';
		if($profile_completion_percentage == 100)
			$displayText    = sprintf(JText::_('PROFILE STATUS COMPLETION 100'),$percentStyling);
		else
			$displayText    = sprintf(JText::_('PROFILE STATUS COMPLETION'),$percentStyling);
		
		$data['displayText']					= $displayText;
		return $this->_getDisplay($data);
	}
	
	
	
	function _getDisplay($data = array())
	{
		$avatarWidth=$this->_params->get('SPS_AvatarWidth',75);
		$avatarHeight=$this->_params->get('SPS_AvatarHeight',75);
		
		ob_start();	
		?>
		<div id="application-group">
		<?php 
		// if avatar required
		if ($this->_params->get('SPS_ShowAvatar',0))
		{?>
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
		?>
		<!-- show-completion-bar -->		
		<div class="jspc_column2" style="width:<?php echo $this->_params->get('SPS_Length','1') +20 ; ?>px;">
			<div class="jspc_completion_bar">
				<img src="<?php echo $data['filename'];?>">
			</div> 
			<div style="jspc_completion_text"><?php
						echo $data['displayText']; ?>
			</div>
		</div>
		<!-- show-completion-bar#Done -->
		
		<!-- show-column3 -->	
		<?php 
		if($data['profile_completion_percentage'] != 100)
		{?>				
			<div class="jspc_column3">
			<ul id="jspc_completion_links">
			<?php
				$total =  100 - $data['profile_completion_percentage'];
				$visibleFeatureCount=$this->_params->get('SPS_VisibleFeatureNumber','all');
				if(!is_numeric($visibleFeatureCount) && strtolower($visibleFeatureCount)!='all')
					$visibleFeatureCount=0;
				foreach($data['incomplete_feature'] as $key => $value)
				{
					if(!$visibleFeatureCount) 
						break;
					
					$nextTask	= JspcLibrary::callAddonFunction($key, 'getCompletionLink', $data['userId']);
					?>
					<li> 
						<span class="jspc_link_percent"> <?php echo $value; ?>% &nbsp; </span>
						<span class="jspc_link_text"> 
							 <a id="jspc_incomplete_link_<?php echo $key;?>" href="<?php echo $nextTask['link']; ?>"> 
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
