<?php
class VideosTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	
	function testVideosOnZero()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 40;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=6;
		$this->verifyPercentage(63,6,$compare);			
	}
	
	function testVideos()
	{
		$compare['fillValue']  = 6.66;
		$compare['totalValue'] = 40;
		$compare['percentage'] = 16.67;
		$compare['incomplete'] = 83.33;
		$compare['remain']=5;
		$this->verifyPercentage(63,6,$compare);			
	}
		
	function testVideosOnLast()
	{
		$compare['fillValue']  = 40;
		$compare['totalValue'] = 40;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(63,6,$compare);			
	}	
}