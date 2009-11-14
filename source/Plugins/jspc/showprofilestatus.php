<?php


// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_BASE . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php');
require_once( JPATH_BASE . DS . 'components' . DS . 'com_profilestatus' . DS . 'libraries' . DS . 'profilestatus.php');

class plgCommunityShowProfileStatus extends CApplications
{
	var $name 		= "Profile Completion";
	var $_name		= 'showprofilestatus';
	var $_path		= '';
	var $_user		= '';
	var $_my		= '';
	var $_params	= '';
	
	function plgCommunityShowProfileStatus(& $subject, $config)
    {
		parent::__construct($subject, $config);
		$this->_path	= dirname( dirname( JPATH_COMPONENT ) ) . DS . 'administrator' . DS . 'components' . DS . 'com_community'; 
		$plugin =& JPluginHelper::getPlugin('community', $this->_name); 		
		$this->_params 	= new JParameter($plugin->params);		
    }

	
	function onProfileDisplay()
	{
		JPlugin::loadLanguage( 'plg_showprofilestatus', JPATH_ADMINISTRATOR );
		
		$my					=& CFactory::getUser();
		$user				=& CFactory::getActiveProfile();
		
		require_once (JPATH_ROOT. DS.'components'.DS.'com_community'.DS.'helpers'.DS.'owner.php');
		// Do not stop admins
		if(isSuperAdministrator())
		{
			// show active profile
			$my	= $user;
		}
		else if ($my->_userid != $user->_userid)
			return;
		
		$document	= JFactory::getDocument();
		$document->addStyleSheet('plugins/community/showprofilestatus/style.css');
		$uri		= JURI::base();			
		return plgCommunityShowProfileStatus::_getShowProfileStatusHTML($my->_userid); 
	}
	
	function _getShowProfileStatusHTML($userId)
	{		
			$fillValue = CProfileStatusLibrary::get_fill_weightage_count_of_other($userId);
			$totalValue = CProfileStatusLibrary::get_totalvalue_of_other();

			if($totalValue == 0)
				$profile_completion_percentage = 100;
			else
				$profile_completion_percentage = ($fillValue/$totalValue)*100;
			
			//get array of those feature which is not complete
			$incomplete_feature = CProfileStatusLibrary::get_incomplete_feature_array($userId);
			//sort the array in descending order with not changing key
			arsort($incomplete_feature);
			
			$profile_completion_percentage = round($profile_completion_percentage,1	);
			$filename	= plgCommunityShowProfileStatus::createPercentageBarImageFile($profile_completion_percentage);
			
			$my =& CFactory::getUser($userId);
			$myLink=CRoute::_('index.php?option=com_community&view=profile&userid='.$my->id);
			$myName	=$my->getDisplayName();
			$myAvatar=$my->getThumbAvatar();
			
			ob_start();	
			?>
			<div id="application-group">
				<div style="float:left">
					<img src="<?php echo $myAvatar; ?>" 
								alt="<?php echo $myName; ?>" 
								style="padding: 2px; border: solid 1px #ccc;" />
				</div>
				
				<div class="SPS_CompletionBar">
					<img src="<?php echo $filename;?>"> 
					<br /><br />
					<div style="SPS_CompletionText">
					<?php
						$percentStyling = '<span class="SPS_SpanPer" style="color:'. $this->params->get('SPS_FGColor','#9CD052').'">'.$profile_completion_percentage.' % </span>';
						echo sprintf(JText::_('CC PROFILE STATUS COMPLETION'),$percentStyling); 
						?> 
					</div>
				</div>
				
				<?php 
			   	if($profile_completion_percentage != 100)
			   	{?>				
		   		<div class="SPS_CompleteMessage">
					<ul id="featurelist">
					<?php
						$total =  100 - $profile_completion_percentage;
						foreach($incomplete_feature as $key => $value)
						{
							$nextTask	= CProfileStatusLibrary::getCompletionLink($key);
							$value 		= round($value,1);
							if($value > $total)
								$value = $total;
							$total -=$value;?>
							<li> <?php echo $value; ?>% &nbsp;
								<a class="SPS_JSMessage" href="<?php echo CRoute::_($nextTask[1],false); ?>"> 
									<?php echo $nextTask[0];?> 
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
	
	function createPercentageBarImageFile($per)
	{
		jimport('joomla.filesystem.file');
		
		// if file exist return the file name
		$per		= $per;
		$filename	= 'plugins/community/showprofilestatus/'. $per. '.jpg';
		
		// For debug mode generate file everytime
		if(JFile::exists($filename))
		{
			if($this->params->get('SPS_ImageDebugMode'))
				JFile::delete($filename);
			else
				return $filename;
		}
			
		// These should be added in plugin configuration
		$width		=	$this->params->get('SPS_Length'); // 200;
		$height		=	$this->params->get('SPS_Height'); // 25;
		$fontsize	= 	$this->params->get('SPS_FontSize'); // 3;
		
		$strPercent	= 	$per . "%";
		$img 		= 	ImageCreateTrueColor($width, $height);

		// $bg 		= imagecolorallocate($img, 255, 255, 255);
		$bgColor	= plgCommunityShowProfileStatus::getColor($img,
									$this->params->get('SPS_BGColor','#FFFFFF'));
		
		//rgb(156, 208, 82)
		$fgColor	= plgCommunityShowProfileStatus::getColor($img,
									$this->params->get('SPS_FGColor','#9CD052'));

		//rgb 50, 55, 55
		$slColor	= plgCommunityShowProfileStatus::getColor($img,
									$this->params->get('SPS_SLColor','#000000'));
		
		// 255 255 255
		$strColor 	= plgCommunityShowProfileStatus::getColor($img,
									$this->params->get('SPS_STRColor','#FFFFFF'));
		
		// calculate bar fill length
		$per		= $width*	$per	/	100;
		$per		= round($per);
		
		imagefilledrectangle($img,	1,		1,	$width,	$height,	$bgColor);
		imagefilledrectangle($img,	1,		1,	$per,	$height,	$fgColor);
		
		imagerectangle		($img,	0,		0,	$width-1,	$height-1,	$slColor);
		imagestring 		($img,	$fontsize, $per/2, $height/5, $strPercent, $strColor); 
		
		$result	=	 imagejpeg($img,$filename);
		imagedestroy($img);
		// if file creation is successfull return filename , else false
		return $result ? $filename :  false;
	}
	
	
	function getColor($img , $hexcode)
	{
		assert($img);
		$color	=	plgCommunityShowProfileStatus::html2rgb($hexcode);
		//print_r($hexcode . "=>" . $color[0] .",". $color[1] .",". $color[2]);
		return imagecolorallocate($img, $color[0],$color[1],$color[2]);
	}
	
	// convert color into RGB
	function html2rgb($color)
	{
	    if ($color[0] == '#')
	        $color = substr($color, 1);

	    if (strlen($color) == 6)
	        list($r, $g, $b) = array($color[0].$color[1],
	                                 $color[2].$color[3],
	                                 $color[4].$color[5]);
	    elseif (strlen($color) == 3)
	        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	    else
	        return false;

	    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

	    return array($r, $g, $b);
	}
}