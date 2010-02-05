<?php 

class PhotosTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}
		
	function testPhotosOnZero()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 60;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=9;
		$this->verifyPercentage(63,3,$compare);			
	}
	
	function testPhotos()
	{
		$compare['fillValue']  = 26.7;
		$compare['totalValue'] = 60;
		$compare['percentage'] = 44.4;
		$compare['incomplete'] = 55.6;
		$compare['remain']=5;
		$this->verifyPercentage(63,3,$compare);			
	}
	
	function testPhotosOnLast()
	{
		$compare['fillValue']  = 60;
		$compare['totalValue'] = 60;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(63,3,$compare);			
	}
	
		
}
