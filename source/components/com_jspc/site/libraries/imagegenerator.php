<?php

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
		
		// if file exist return the file name
		$filename	= 'components/com_jspc/jspc/'.$imagePreText.$per. '.jpg';
		
		// For debug mode generate file everytime
		if(JFile::exists($filename))
		{
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
		imagestring 		($img,	$this->fontsize, $per/2, $this->height/5, $strPercent, $this->strColor); 
		
		$result	=	 imagejpeg($img,$filename);
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
}
