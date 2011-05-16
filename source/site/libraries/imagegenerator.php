<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

class JspcImageGenerator
{
	private $params;
	private $height;
	private $width;
	private $fontsize;
	private $bgColor;
	private $fgColor;
	private $slColor;
	private $strColor;
	
	function __construct($params)
	{
		$this->params 		= $params;
		$this->width		=	$this->params->get('SPS_Length',200); // 200;
		$this->height		=	$this->params->get('SPS_Height',25); // 25;
		$this->fontsize		= 	$this->params->get('SPS_FontSize',3); // 3;
		
		$this->bgColor		= 	$this->html2rgb($this->params->get('SPS_BGColor','FFFFFF'));
		$this->fgColor		= 	$this->html2rgb($this->params->get('SPS_FGColor','9CD052'));
		$this->slColor		= 	$this->html2rgb($this->params->get('SPS_SLColor','000000'));
		$this->strColor 	= 	$this->html2rgb($this->params->get('SPS_STRColor','FFFFFF'));	
	}
	

	function createPercentageBarImageFile($imagePreText,$per)
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		// if file exist return the file name
		$folderPath = 'media'.DS.'system'.DS.'images'.DS.'jspc';
		
		$filename	= $folderPath.DS.$imagePreText.$per. '.jpg';
		
		// For debug mode generate file everytime
		if(!JFolder::exists($folderPath))
			JFolder::create($folderPath,0777);

		if(JFile::exists(JPATH_ROOT.DS.$filename)) {
			if($this->params->get('SPS_ImageDebugMode'))
				JFile::delete($filename);
			else
				return $filename;
		}
		$strPercent	= 	$per . "%";
		$img 		= 	ImageCreateTrueColor($this->width, $this->height);
		
		//apply bakground color
		$this->bgColor = imagecolorallocate($img,$this->bgColor[0],$this->bgColor[1],$this->bgColor[2]);
		
		//apply foreground color
		$this->fgColor = imagecolorallocate($img,$this->fgColor[0],$this->fgColor[1],$this->fgColor[2]);

		$this->slColor = imagecolorallocate($img,$this->slColor[0],$this->slColor[1],$this->slColor[2]);
		
		//apply string color
		$this->strColor = imagecolorallocate($img,$this->strColor[0],$this->strColor[1],$this->strColor[2]);
		
		// calculate bar fill length
		$per		= ( $per / 100 ) *	$this->width;
		$per		= round($per);
		
		imagefilledrectangle($img,	1,		1,	$this->width,	$this->height,	$this->bgColor);
		imagefilledrectangle($img,	1,		1,	$per,	$this->height,	$this->fgColor);
		
		imagerectangle		($img,	0,		0,	$this->width-1,	$this->height-1,	$this->slColor);
		
		// get the position of text in fillbar
		$position=$this->calculatePositionOfFillbarText($img,$strPercent,$per);
		imagestring 		($img,	$this->fontsize, $position['x'], $position['y'], $strPercent, $this->strColor); 
		
		$result	=	 imagejpeg($img,JPATH_ROOT.DS.$filename);
		imagedestroy($img);
		// if file creation is successfull return filename , else false
		return $result ? $filename :  false;
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
	
	// using this calculation the percentage will appear in the center of fill bar
	function calculatePositionOfFillbarText($img,$strPercent, $per)
	{		
		$per_width = imagefontwidth($this->fontsize)*strlen($strPercent);
		if($per_width > $per)
		{
			$per=$this->width;
			$this->strColor=$this->color_inverse();
			$this->strColor = imagecolorallocate($img,$this->strColor[0],$this->strColor[1],$this->strColor[2]);
		}
 		$center = ceil($per/2);
 		$position['x'] = $center - (ceil($per_width/2));
 		$position['y'] = ($this->height/2)-(imagefontheight($this->fontsize)/2);
 		return $position;
	}
	

	function color_inverse()
	{
		$color=$this->params->get('SPS_BGColor','9CD052');	
		$color = str_replace('#', '', $color);
	    if (strlen($color) != 6){ return '000000'; }
	    $rgb = '';
	    for ($x=0;$x<3;$x++){
	        $c = 255 - hexdec(substr($color,(2*$x),2));
	        $c = ($c < 0) ? 0 : dechex($c);
	        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
	    }
	    return $this->html2rgb($rgb);
	}

		
}
