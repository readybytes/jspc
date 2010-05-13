<?php 

class imagegeneratorTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
    	  require_once JPATH_ROOT . DS . 'components' . DS . 'com_jspc' . DS . 'libraries' . DS . 'imagegenerator.php'; 
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testCreatePercentageBarImageFile()
	{
		jimport('joomla.filesystem.file');
		
		$paramarray = $this->getParamsarray();
		$params = new JParameter('','');
		$params->bind($paramarray);
		$imgGenerator = new JspcImageGenerator($params); 	
		$reqFileName =  'media'.DS.'system'.DS.'images'.DS.'jspc'. DS. 'test_2.5.jpg';
		JFile::delete(JPATH_ROOT.DS.$reqFileName);
		$filename = $imgGenerator->createPercentageBarImageFile('test_',2.5);
		
		$this->assertEquals($reqFileName,$filename);
		$this->assertTrue(JFile::exists(JPATH_ROOT.DS.$filename));
		
		//Comparing images
		$md5_ps = md5(JFile::read(JPATH_ROOT.DS.$filename));
		$goldPath=JPATH_ROOT.DS.'test'.DS.'test'.DS.'test_2.5.jpg';
		$md5_ps_gold=md5(JFile::read($goldPath));
		$this->assertEquals($md5_ps, $md5_ps_gold);
	}
	
	
	function getParamsarray()
	{
		$strparams = 'coreapp=1\ncache=1\nSPS_AvatarWidth=75\nSPS_AvatarHeight=75\n'
				. 'SPS_Length=200\nSPS_Height=25\nSPS_FontSize=3\nSPS_FGColor=9CD052\n'
				. 'SPS_BGColor=FFFFFF\nSPS_SLColor=000000\nSPS_STRColor=FFFFFF\n'
				. 'SPS_ImageDebugMode=0\nshowProfile=1\nSPS_VisibleFeatureNumber=all\n\n';
		
		$paramArray = array();
		$paramArray['coreapp'] = 1;
		$paramArray['cache'] = 1;
		$paramArray['SPS_AvatarWidth'] = 75;
		$paramArray['SPS_AvatarHeight'] = 75;
		$paramArray['SPS_Length'] = 200;
		$paramArray['SPS_Height'] = 25;
		$paramArray['SPS_FontSize'] = 3;
		$paramArray['SPS_FGColor'] = '9CD052';
		$paramArray['SPS_BGColor'] = 'FFFFFF';
		$paramArray['SPS_SLColor'] = '000000';
		$paramArray['SPS_STRColor'] = 'FFFFFF';
		$paramArray['SPS_ImageDebugMode'] = 0;
		$paramArray['showProfile'] = 1;
		$paramArray['SPS_VisibleFeatureNumber'] = 'all';
		
		
		
		return $paramArray;
	}
	
}