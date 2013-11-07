<?php

class ProfileTypeTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testProfileOfManager()
	{
		$compare['fillValue']  = 133.3;
		$compare['totalValue'] = 290;
		$compare['percentage'] = 46;
		
		$compare['incomplete'][3] = 16.1;
		$compare['remain'][3]=7;
		
		$compare['incomplete'][4] = 13.8;
		$compare['remain'][4]=1;
		
		$compare['incomplete'][6] = 13.8;
		$compare['remain'][6]=6;
		
		$compare['incomplete'][8] = 10.3;
		$compare['remain'][8]=3;
		
		$compare['incomplete'][9] = 0;
		$compare['remain'][9]=0;
		
		$this->verifyPercentageForPtype(66,$compare);	
	}
	
	function testProfileOfDirector()
	{
		$compare['fillValue']  = 100.8;
		$compare['totalValue'] = 300;
		$compare['percentage'] = 33.6;
		
		$compare['incomplete'][1] = 20.8;
		$compare['remain'][1]=5;
		
		$compare['incomplete'][3] = 13.3;
		$compare['remain'][3]=6;
		
		$compare['incomplete'][4] = 13.3;
		$compare['remain'][4]=1;
		
		$compare['incomplete'][6] = 8.9;
		$compare['remain'][6]=4;
		
		$compare['incomplete'][8] = 10;
		$compare['remain'][8]=3;
		
		$this->verifyPercentageForPtype(70,$compare);	
	}
	
	function testProfileOfTeacher()
	{
		$compare['fillValue']  = 174;
		$compare['totalValue'] = 280;
		$compare['percentage'] = 62.1;
		
		$compare['incomplete'][7] = 5.7;
		$compare['remain'][7]=3;
		
		$compare['incomplete'][3] = 9.5;
		$compare['remain'][3]=4;
		
		$compare['incomplete'][4] = 14.3;
		$compare['remain'][4]=1;
		
		$compare['incomplete'][6] = 4.8;
		$compare['remain'][6]=2;
		
		$compare['incomplete'][8] = 3.6;
		$compare['remain'][8]=1;
		
		$this->verifyPercentageForPtype(67,$compare);	
	}
	
	function testProfileOfParents()
	{
		$compare['fillValue']  = 159.6;
		$compare['totalValue'] = 290;
		$compare['percentage'] = 55;
		
		$compare['incomplete'][2] = 11.6;
		$compare['remain'][2]=3;
		
		$compare['incomplete'][3] = 2.3;
		$compare['remain'][3]=1;
		
		$compare['incomplete'][4] = 13.8;
		$compare['remain'][4]=1;
		
		$compare['incomplete'][6] = 6.9;
		$compare['remain'][6]=3;
		
		$compare['incomplete'][8] = 10.3;
		$compare['remain'][8]=3;
		
		$this->verifyPercentageForPtype(69,$compare);	
	}
	
	function testProfileOfStudent()
	{
		$compare['fillValue']  = 70;
		$compare['totalValue'] = 270;
		$compare['percentage'] = 25.9;
		
		$compare['incomplete'][5] = 17.3;
		$compare['remain'][5]=6;
		
		$compare['incomplete'][3] = 12.3;
		$compare['remain'][3]=5;
		
		$compare['incomplete'][4] = 14.8;
		$compare['remain'][4]=1;
		
		$compare['incomplete'][6] = 14.8;
		$compare['remain'][6]=6;
		
		$compare['incomplete'][8] = 14.8;
		$compare['remain'][8]=4;
		
		$this->verifyPercentageForPtype(68,$compare);	
	}
	
	function verifyPercentageForPtype($userId,$compare)
	{
		require_once( JPATH_ROOT . DS . 'components' . DS . 'com_jspc'  . DS . 'includes.jspc.php');	
		require_once( JPATH_ROOT . DS . 'administrator'. DS. 'components' . DS . 'com_jspc'  . DS . 'addons' . DS . 'addons.php');
		
		$fillValue = JspcLibrary::calulateFillCountOfUser($userId);
		$totalValue = JspcLibrary::calulateTotalCount($userId);
		$percentage = JspcLibrary::calulatePCPercentage($userId);
		$incomplete_feature = JspcLibrary::getIncompleteFeatures($userId);
		
		
		$this->assertEquals(round($compare['fillValue'],1),round($fillValue,1));
		$this->assertEquals(round($compare['totalValue'],1),round($totalValue,1));
		$this->assertEquals(round($compare['percentage'],1),round($percentage,1));
		
		for($featureId=1 ; $featureId<=9 ; $featureId++)
		{
			if(!array_key_exists($featureId,$compare['incomplete']))
				continue;
				
			if(!isset($incomplete_feature[$featureId])){
				$incomplete_feature[$featureId]  = 0;
			}
			$this->assertEquals(round($compare['incomplete'][$featureId],1),round($incomplete_feature[$featureId],1));
			$remainCount = JspcLibrary::callAddonFunction($featureId,"getRemainingCount",$userId);
			$this->assertEquals(round($compare['remain'][$featureId],1),round($remainCount,1));	
		}
		
	}
}
