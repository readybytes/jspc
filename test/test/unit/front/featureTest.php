<?php

class FeatureTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testAlbumAndProfile()
	{
		$compare['fillValue']  = 81;
		$compare['totalValue'] = 180;
		$compare['percentage'] = 45;
		$compare['incomplete'] = 41.7;  
		$compare['remain']=6;			
		$this->verifyPercentage(63,1,$compare);		
		$compare['incomplete'] = 13.3; 
		$compare['remain']=4;
		$this->verifyPercentage(63,7,$compare);
	}
	
	function testAlbum_CreateGroup()
	{
		$compare['fillValue']  = 81.3;
		$compare['totalValue'] = 190;
		$compare['percentage'] = 42.8;
		$compare['incomplete'] = 39.5;  
		$compare['remain']=6;			
		$this->verifyPercentage(63,1,$compare);
				
		$compare['incomplete'] = 17.8; 
		$compare['remain']=3;
		$this->verifyPercentage(63,2,$compare);
			
	}
	
	function testGroupMember_Photos()
	{
		$compare['fillValue']  = 73.3;
		$compare['totalValue'] = 130;
		$compare['percentage'] = 56.4;
		$compare['incomplete'] = 25.6;  
		$compare['remain']=5;			
		$this->verifyPercentage(63,3,$compare);
				
		$compare['incomplete'] = 17.9; 
		$compare['remain']=3;
		$this->verifyPercentage(63,5,$compare);
	
	}
	
	function testVideos_Profile()
	{
		$compare['fillValue']  = 90.5;
		$compare['totalValue'] = 133;
		$compare['percentage'] = 68;
		$compare['incomplete'] = 16.9;  
		$compare['remain']=3;			
		$this->verifyPercentage(63,6,$compare);
				
		$compare['incomplete'] = 15; 
		$compare['remain']=3;
		$this->verifyPercentage(63,7,$compare);		
	}
	
	function testVideos_Photos()
	{
		$compare['fillValue']  = 49.2;
		$compare['totalValue'] = 105;
		$compare['percentage'] = 46.8;
		$compare['incomplete'] = 31.7;  
		$compare['remain']=5;			
		$this->verifyPercentage(63,3,$compare);
		$compare['incomplete'] = 21.4; 
		$compare['remain']=3;
		$this->verifyPercentage(63,6,$compare);	
	}
	
	function testTwoAlbum_GroupMember_TwoCreateGroup()
	{
		$compare['fillValue']  = 237.9;
		$compare['totalValue'] = 410;
		$compare['percentage'] = 58;
		$compare['incomplete'] = 18.3;
		$compare['remain']=6;		
		$this->verifyPercentage(63,1,$compare);
		
		$compare['incomplete'] = 8.2; 
		$compare['remain']=3;
		$this->verifyPercentage(63,2,$compare);
		
		$compare['incomplete'] = 5.7;
		$compare['remain']=3;
		$this->verifyPercentage(63,5,$compare);
		
		$compare['incomplete'] = 9.8; 
		$compare['remain']=4;
		$this->verifyPercentage(63,8,$compare);
		
		$compare['incomplete'] = 0; 
		$compare['remain']=0;
		$this->verifyPercentage(63,9,$compare);
		
	}
}