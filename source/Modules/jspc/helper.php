<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class ProfileCompleteHelper
{
	var $params = '';

		function _getShowProfileStatusHTML($userId, &$mod_params)
		{
			if(empty($userId) || $userId == '0' || $userId == 0)
				return "";
				
			$this->params =& $mod_params;
			
			$document	= JFactory::getDocument();
			if ($this->params->get('SPS_Layout','horizontal')=='vertical')
				$document->addStyleSheet('modules/mod_showprofilestatus/style.vert.css');
			else
				$document->addStyleSheet('modules/mod_showprofilestatus/style.css');

			$fillValue  = CProfileStatusLibrary::get_fill_weightage_count_of_other($userId);
			$totalValue = CProfileStatusLibrary::get_totalvalue_of_other();

			if($totalValue == 0)
				$profile_completion_percentage = 100;
			else
				$profile_completion_percentage = ($fillValue/$totalValue)*100;
					
			//get array of those feature which is not complete
			$incomplete_feature = CProfileStatusLibrary::get_incomplete_feature_array($userId);
			arsort($incomplete_feature);
					
			$profile_completion_percentage = round($profile_completion_percentage,1	);
			$filename	= ProfileCompleteHelper::createPercentageBarImageFile($profile_completion_percentage);
			
			$my =& CFactory::getUser();
			$myLink=CRoute::_('index.php?option=com_community&view=profile&userid='.$my->id);
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
					Your Profile is <span class="SPS_SpanPer" style="color:<?php echo $this->params->get('SPS_FGColor','#9CD052'); ?>;"><?php echo $profile_completion_percentage;?>%</span> complete. 
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
			<div class="clr"></div>
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
		$filename	= 'modules/mod_showprofilestatus/'. $per. '.jpg';
		
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
		$bgColor	= ProfileCompleteHelper::getColor($img,
									$this->params->get('SPS_BGColor','#FFFFFF'));
		
		//rgb(156, 208, 82)
		$fgColor	= ProfileCompleteHelper::getColor($img,
									$this->params->get('SPS_FGColor','#9CD052'));

		//rgb 50, 55, 55
		$slColor	= ProfileCompleteHelper::getColor($img,
									$this->params->get('SPS_SLColor','#000000'));
		
		// 255 255 255
		$strColor 	= ProfileCompleteHelper::getColor($img,
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
		$color	=	ProfileCompleteHelper::html2rgb($hexcode);
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
