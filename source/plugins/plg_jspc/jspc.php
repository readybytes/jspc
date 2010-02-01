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
		$this->_path	= dirname( dirname( JPATH_COMPONENT ) ) . DS . 'administrator' . DS . 'components' . DS . 'com_community'; 
		$this->plugin =& JPluginHelper::getPlugin('community', $this->_name); 		
		$this->_params 	= new JParameter($this->plugin->params);		
    }
    
    
    function includes()
    {
		if($this->isIncludes)
			return true;
		$this->isIncludes = true;	
    	jimport( 'joomla.filesystem.folder' );
		
		$jspcPath = JPATH_ROOT.DS.DS.'components'.DS.'com_jspc';

		if(!JFolder::exists($jspcPath))
			return false;
		
		require_once( JPATH_ROOT . DS . 'components' . DS . 'com_jspc'  . DS . 'includes.jspc.php');

		$communityPath = JPATH_ROOT.DS.DS.'components'.DS.'com_community';

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
		if(!$this->includes())
			return;
		
		$my					=& CFactory::getUser();
		$user				=& CFactory::getActiveProfile();
		
		// Do not stop admins
		if(isSuperAdministrator())
			$my	= $user;
		else if ($my->_userid != $user->_userid)
			return;
		
		return $this->_getJspcHTML($my->_userid); 
	}
	
	function _getJspcHTML($userId)
	{		
		$fillValue = JspcLibrary::calulateFillCountOfUser($userId);
		$totalValue = JspcLibrary::calulateTotalCount($userId);
		$profile_completion_percentage = '';
		
		if($totalValue == 0){
				$profile_completion_percentage = 100;
		}				
		else
			$profile_completion_percentage = ($fillValue/$totalValue)*100;
		
		//get array of those feature which is not complete
		$incomplete_feature = JspcLibrary::getIncompleteFeatures($userId);
		//sort the array in descending order with not changing key
		arsort($incomplete_feature);
		
		$profile_completion_percentage = round($profile_completion_percentage,1	);
		
		$showProfile = $this->_params->get('showProfile','1');
		if($showProfile == 0 && $profile_completion_percentage == 100)
			return false;
		
		$imageGenerator = new JspcImageGenerator($this->_params);
		$filename	= $imageGenerator->createPercentageBarImageFile('plg_',$profile_completion_percentage);
		
		$data = JspcLibrary::getDisplayInformationOfUser($userId);
		$data['userId']							= $userId;
		$data['filename'] 						= $filename;
		$data['incomplete_feature']				= $incomplete_feature ;
		$data['profile_completion_percentage']	= $profile_completion_percentage;
		
		$percentStyling = '<span class="SPS_SpanPer" style="color:#'. $this->_params->get('SPS_FGColor','9CD052').'">'.$profile_completion_percentage.'% </span>';
		$displayText    = sprintf(JText::_('PROFILE STATUS COMPLETION'),$percentStyling);
		
		$data['displayText']					= $displayText;
		return $this->_getDisplay($data);
	}
	
	
	
	function _getDisplay($data = array())
	{
		ob_start();	
			?>
			<div id="application-group">
				<div style="float:left">
					<img src="<?php echo $data['avatar']; ?>" 
								alt="<?php echo $data['name']; ?>" 
								style="padding: 2px; border: solid 1px #ccc;" />
				</div>
				
				<div class="SPS_CompletionBar">
					<img src="<?php echo $data['filename'];?>"> 
					<br /><br />
					<div style="SPS_CompletionText">
					<?php
						echo $data['displayText'];	 
					?> 
					</div>
				</div>
				
				<?php 
			   	if($data['profile_completion_percentage'] != 100) {?>				
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
								$total -=$value;?>
								<li> <?php echo $value; ?>% &nbsp;
									<a class="SPS_JSMessage" href="<?php echo JRoute::_($nextTask['link'],false); ?>"> 
										<?php echo $nextTask['text'];?> 
									</a>
								</li><?php
							}?>
						</ul>
					</div><?php 
				}?>
			</div>
			<div style='clear:both;'></div>
			<?php
			$contents	= ob_get_contents();
			ob_end_clean();
			return $contents;
	}
}
